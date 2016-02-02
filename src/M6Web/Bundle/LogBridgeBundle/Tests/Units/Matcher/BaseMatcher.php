<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

use M6Web\Bundle\LogBridgeBundle\Tests\Units\BaseTest;
use M6Web\Bundle\LogBridgeBundle\Config\Parser;

class BaseMatcher extends BaseTest
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
        return __DIR__ .'/../../Fixtures/Resources/config/config.yml';
    }


    protected function getCacheDir()
    {
        return __DIR__.'/../../Fixtures/Resources/cache';
    }


    protected function getParser()
    {
        return new Parser($this->getMockedRouter());
    }

    protected function getMatcherClassName()
    {
        return 'TestLogMatcher';
    }
}
