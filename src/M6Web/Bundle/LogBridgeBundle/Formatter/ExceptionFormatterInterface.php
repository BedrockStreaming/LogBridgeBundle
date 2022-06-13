<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

/**
 * Interface ExceptionFormatterInterface
 */
interface ExceptionFormatterInterface extends FormatterInterface
{
    public function setRequestExceptionAttribute(string $requestExceptionAttribute): void;
}
