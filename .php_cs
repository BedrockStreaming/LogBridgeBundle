<?php

$config = new M6Web\CS\Config\Php71;

$config->getFinder()
    ->in([
        __DIR__.'/src'
    ])->exclude([
        'Tests'
    ]);

return $config;
