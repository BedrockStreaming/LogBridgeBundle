<?php

$config = new class() extends \PhpCsFixer\Config {
    public function __construct()
    {
        parent::__construct('Bedrock(PHP 7.1)');
    }

    public function getRules()
    {
        return (new \M6Web\CS\Config\Php71())->getRules() + ['increment_style' => false];
    }
};

$config->getFinder()
    ->in([
        __DIR__.'/src'
    ])->exclude([
        'Tests'
    ]);

return $config;
