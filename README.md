# LogBridgeBundle [![Build Status](https://travis-ci.org/M6Web/LogBridgeBundle.svg?branch=master)](https://travis-ci.org/M6Web/LogBridgeBundle)

Symfony Bundle to log Request/Response with Monolog. 

**NOTE:** Require `Symfony >= 2.6` since version 3.0. For previsous version of symfony use the `~2.2` release.


## Features

 - semantic configuration
 - sf2 event dispatcher integration
 - log request filter



## Install

**With composer**
```
    "require": {
        "m6web/log-bridge-bundle": "~3.0"
    }
```

**Add to your AppKernel**
```
    $bundles = [
    // ...
        new M6Web\Bundle\LogBridgeBundle\M6WebLogBridgeBundle(),
    //...
    ];
```


## Usage

```yaml
# app/config.yml

m6_web_log_bridge:
    resources:
        - %kernel.root_dir%/config/m6web_log_bridge.yml
    content_formatter: m6web_log_bridge.log_content_provider # Provider service name
    ignore_headers: # key list from mask/ignore header info
        - php-auth-pw
    prefix_key: ~ # define prefix key on log context
    logger: 
        channel: my_channel_to_log # monolog channel, optional, default 'log_bridge'
```

By default, this bundle use a builtin logger with monolog support `m6web_log_bridge.logger`
You can override this configuration by writing your own logger who must implements `Psr\Log\LoggerInterface` : 

```yaml
# app/config.yml

m6_web_log_bridge:
    logger: 
        service: acme.logger
```

```yaml
services:
    acme.logger:
        class: Acme\DemoBundle\Logger\logger
        arguments: ["@logger"]
        tags:
            - { name: monolog.logger, channel: log_bridge }
```
*`Acme\DemoBundle\Logger\logger` must be implement `Psr\Log\LoggerInterface`*

**Define your filters** :

```
    #app/config/m6web_log_bridge.yml
    environments:
        preprod:
            - get_article_error
            - post_article_all
        prod: ~ #form all filter associated
        recette:
            - all_error

    filters:
        get_article_error:
            route: get_article
            method: ['GET']
            status: [422, 500]
            level: 'error'
            options:
                response_body: true # from add Response body content (with DefaultFormatter)
        post_article_all:
            route: post_article
            method: ~ # from all methods
            status: ~ # from all status
        get_article_not_found:
            route: get_article
            method: ['GET']
            status: [404]
            level: 'warning'
        edit_category:
            route: get_category
            method: ['POST', 'PUT']
            status: [400, 422, 500]
            level: 'error'
            options:
                post_parameters: true # From add post parameters in response content (with DefaultFormatter)
        all_error: # All route, all method in error
            route: ~
            method: ~
            status: [400, 404, 422, 500]
            level: 'critical'

```
*By default, `level` is `info`*

You can declare all the options you want. 
By default, only `response_body` and `post_parameters` is supported by the DefaultFormatter


## Define your Provider from format log content

It is advisable to extend default provider M6Web\Bundle\LogBridgeBundle\Formatter\DefaultFormatter


**default definition from service provider :** 

```
    services:
        m6web_log_bridge.log_content_provider:
            class: %m6web_log_bridge.log_content_provider.class%
            arguments:
                - %kernel.environment%
                - %m6web_log_bridge.ignore_headers%
                - %m6web_log_bridge.prefix_key%
            calls:
                - [ setContext, [ @security.context ] ]
```

**From override :**

```
    services:
        acme.my_log_provider:
            class: Acme\Bundle\MyBundle\Provider\LogContentProvider
            parent: m6web_log_bridge.log_content_formatter
```

or simply override this parameter : ```m6web_log_bridge.log_content_formatter.class```


### Log contents example

    Request
    ------------------------
    content-type        : 
    content-length      : 
    host                : domain.tld
    x-real-ip           : *********
    x-forwarded-for     : *********
    x-forwarded-proto   : http
    x-forwarded-port    : 80
    remote-user         : u_glinel
    connection          : close
    cache-control       : max-age=0
    authorization       : Basic ************
    accept              : text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
    user-agent          : Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/127.0.0.1 Chrome/127.0.0.1 Safari/537.36
    accept-encoding     : gzip,deflate,sdch
    accept-language     : fr-FR,fr;q=0.8,en-US;q=0.6,en;q=0.4
    cookie              : PHPSESSID=************
    php-auth-user       : u_glinel
    x-php-ob-level      : 1
    ------------------------
    Response
    ------------------------
    HTTP 1.0 200
    Age:           2
    Etag:          
    Vary:          
    Cache-Control: no-cache
    Content-Type:  application/json
    Date:          dd mm yyyy hh:ii:ss GMT
    ------------------------
    Response body
    ------------------------
    Here response content



## Tests

You can run the unit tests with the following command:

```
    php bin/atoum -d src/M6Web/Bundle/LogBridgeBundle/Tests/Units
```
