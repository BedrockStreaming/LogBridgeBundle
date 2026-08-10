# LogBridgeBundle [![Build Status](https://img.shields.io/endpoint.svg?url=https%3A%2F%2Factions-badge.atrox.dev%2FBedrockStreaming%2FLogBridgeBundle%2Fbadge%3Fref%3Dmaster&style=flat)](https://actions-badge.atrox.dev/BedrockStreaming/LogBridgeBundle/goto?ref=master)

Symfony Bundle to log Request/Response with Monolog. 

**NOTE:** The actual version of this bundle support `Symfony >= 4.4`.
If you need support for older versions, please use `~7.0` release.

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
    active_filters:
        - get_article_error
        - post_article_all
        - all_error
    filters:
            get_article_error:
                route: get_article
                routes: ['get_article']
                method: ['GET']
                status: [422, 500]
                level: 'error'
                options:
                    response_body: true # from add Response body content (with DefaultFormatter)
            post_article_all:
                route: post_article
                routes: ['post_article']
                method: ~ # from all methods
                status: ~ # from all status
            get_article_not_found:
                route: get_article
                routes: ['get_article']
                method: ['GET']
                status: [404]
                level: 'warning'
            edit_category:
                route: get_category
                routes: ['get_category']
                method: ['POST', 'PUT']
                status: [400-422, ^510, !530-550]
                level: 'error'
                options:
                    post_parameters: true # From add post parameters in response content (with DefaultFormatter)
                    request_body: true # From add request body in request content (with DefaultFormatter)
            all_error: # All route, all method in error
                route: ~
                routes: ~
                method: ~
                status: [31*, 4*, 5*]
                level: 'critical'
    content_formatter: m6web_log_bridge.log_content_formatter # Provider service name
    ignore_headers: # key list from mask/ignore header info
        - php-auth-pw
    prefix_key: ~ # define prefix key on log context
    logger: 
        channel: my_channel_to_log # monolog channel, optional, default 'log_bridge'
```

Routes support multiples formats :
```yaml
routes: ['my_route'] # Add only this route
routes: ['my_route', 'another_route'] # Add multiples routes
routes: ['!excluded_one', '!excluded_two'] # Add all routes except the excluded
```

*By default, `level` is `info`*

You can declare all the options you want. 
By default, only `response_body`, `post_parameters` and `request_body` is supported by the DefaultFormatter

Status support multiples formats :
```yaml
status: [401] # Add status 401
status: [^456] # Add status hundred greater than 450 (456, 457, 458, ..., 499)
status: [4*] # Add status hundred (200, 400, 401, 402, ..., 499)
status: [41*] # Add status decade (410, 411, 412, ..., 419)
status: [425-440] # Add range status (425, 426, 427, ..., 440)
status: [2*, 301, !203-210] # Add status (200, 201, 202, 211, ..., 299, 301)
```
*Instead of add can be use `!` to exclude status*



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

## Define your Provider from format log content

It is advisable to extend default provider M6Web\Bundle\LogBridgeBundle\Formatter\DefaultFormatter


**default definition from service provider :** 

```
    services:
        m6web_log_bridge.log_content_provider:
            class: '%m6web_log_bridge.log_content_provider.class%'
            arguments:
                - '%kernel.environment%'
                - '%m6web_log_bridge.ignore_headers%'
                - '%m6web_log_bridge.prefix_key%'
            calls:
                - [ setTokenStorage, [ '@security.token_storage' ] ]
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


## Logging exceptions

The bundle allow detailed logging of exceptions. This is ensured by the use of `exception.log` in the configuration.

```yaml
# app/config.yml

m6_web_log_bridge:
    exception: 
        log: true
        request_attribute: LogBridgeException
```

This switch allows the bundle to register a listener which will save any received exception and passed it within the request under the defined attribute.

If you use the default formatter, change it using the configuration. The bundle provides another formatter implementation able to log exceptions.
  
```yaml
# app/config.yml

m6_web_log_bridge:
    content_formatter: m6web_log_bridge.log_content_exception_formatter
```

If you prefer to use your own formatter, you will be able to read exceptions directly from the request under the attribute specified in `m6_web_log_bridge.exception.request_attribute`.


## Tests

You can run the unit tests with the following command:

```
    php bin/atoum -d src/M6Web/Bundle/LogBridgeBundle/Tests/Units
```
