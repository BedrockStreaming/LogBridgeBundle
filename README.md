# LogBridgeBundle


## Install

** With composer **
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

in ```config.yml```:

```
    m6_web_log_bridge:
        logger: monolog.service_name
        resources:
            - %kernel.root_dir%/config/log_request_filter.yml
```




## Tests

You can run the unit tests with the following command:

```
    php vendor/bin/atoum -d src/M6Web/Bundle/LogBridgeBundle/Tests/Units
```
