<?php

return (new \M6Web\CS\Config\BedrockStreaming())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                __DIR__.'/src'
            ])
            ->exclude([
                'Tests'
            ])
    );
