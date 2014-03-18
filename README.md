# LogBridgeBundle

Symfony Bundle from log Request/Response with Monolog.


## Features

 - semantic configuration
 - sf2 event dispatcher integration
 - log request filter



## Install

**With composer**
```
    "require": {
        "m6web/log-bridge-bundle": "~1.0"
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

**```config.yml```** :

```
    #app/config.yml
    m6web_log_bridge:
        logger: monolog.service_name
        resources:
            - %kernel.root_dir%/config/m6web_log_bridge.yml
```


**Define your filters** :

```
    #app/config/m6web_log_bridge.yml
    environments:
        preprod:
            - get_article_error
            - post_article_all
        prod: all #form all filter associated
        recette:
            - all_error

    filters:
        get_article_error:
            route: get_article
            method: ['GET']
            status: [422, 500]
        post_article_all:
            route: post_article
            method: all
            status: all
        get_article_not_found:
            route: get_article
            method: ['GET']
            status: [404]
        edit_category:
            route: get_category
            method: ['POST', 'PUT']
            status: [400, 422, 500]
        all_error: # All route, all method in error
            route: all
            method: all
            status: [400, 404, 422, 500]

```


### Log contents example

    Request
    ------------------------
    content-type        : 
    content-length      : 
    host                : domain.tld
    x-real-ip           : 2a01:a580:2:2003:c8c9:13f5:7984:47bd
    x-forwarded-for     : 2a01:a580:2:2003:c8c9:13f5:7984:47bd
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


## Tests

You can run the unit tests with the following command:

```
    php vendor/bin/atoum -d src/M6Web/Bundle/LogBridgeBundle/Tests/Units
```
