<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface FormatterInterface
 */
interface FormatterInterface
{
    public function getLogContent(Request $request, Response $response, array $options): string;

    public function getLogContext(Request $request, Response $response, array $options): array;
}
