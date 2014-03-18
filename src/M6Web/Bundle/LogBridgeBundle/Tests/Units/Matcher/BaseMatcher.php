<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Config\Parser;
use M6Web\Bundle\LogBridgeBundle\Tests\MockRouter;

class BaseMatcher extends atoum
{
    protected function cacheClear()
    {
        $files = glob($this->getCacheDir() .'/*');

        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }

    protected function getResource()
    {
        return __DIR__ .'/../../Resources/config/config.yml';
    }


    protected function getCacheDir()
    {
        return __DIR__.'/../../Resources/cache';
    }


    protected function getParser()
    {
        return new Parser(new MockRouter());
    }

    protected function getMatcherClassName()
    {
        return 'TestLogMatcher';
    }


}