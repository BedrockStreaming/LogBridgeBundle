<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

use M6Web\Bundle\LogBridgeBundle\Tests\Units\BaseTest;
use M6Web\Bundle\LogBridgeBundle\Config\Parser;

class BaseMatcher extends BaseTest
{
    protected function cacheClear(): void
    {
        $files = glob($this->getCacheDir() .'/*');

        if ($files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }

    protected function getCacheDir(): string
    {
        return __DIR__.'/../../Fixtures/Resources/cache';
    }


    protected function getParser(): Parser
    {
        return new Parser($this->getMockedRouter());
    }

    protected function getMatcherClassName(): string
    {
        return 'TestLogMatcher';
    }

    protected function getActiveFilters(): array
    {
        return [
            'get_clip_all_status',
            'put_clip_form_all_200',
            'delete_clip_450_more_without_452_to_458',
        ];
    }

    protected function getFilters(): array
    {
        return [
            'get_clip_all_status' => [
                'route' =>  'get_clip',
                'method' => ['GET', 'PUT'],
                'status' => ['200'],
                'options' => [
                    'response_body' => true,
                    'post_parameters' => true
                ]
            ],
            'put_clip_form_all_200' => [
                'route' =>  null,
                'method' => ['PUT'],
                'status' => ['!^240', '2*'],
            ],
            'delete_clip_500_all_hundred_without_580_to_590' => [
                'route' =>  null,
                'method' => ['DELETE'],
                'status' => ['5*', '!58*'],
            ],
            'edit_clip_5*_30*_without_550_549' => [
                'route' =>  'edit_clip',
                'method' => ['PATH'],
                'status' => ['5*', '!550', '!549', '30*'],
            ],
            'edit_clip_404_to_410' => [
                'route' =>  'edit_clip',
                'method' => ['POST'],
                'status' => ['404-410'],
            ],
            'delete_clip_450_more_without_452_to_458' => [
                'route' =>  'delete_clip',
                'method' => ['DELETE'],
                'status' => ['^450', '!452-458'],
            ],
            'get_program_200_hundred_without_290_more' => [
                'route' =>  'get_program',
                'method' => ['GET'],
                'status' => ['2*', '!^290'],
            ],
        ];
    }
}
