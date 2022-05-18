<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

/**
 * Interface ExceptionFormatterInterface
 */
interface ExceptionFormatterInterface extends FormatterInterface
{
    /**
     * @param string $requestExceptionAttribute
     */
    public function setRequestExceptionAttribute($requestExceptionAttribute);
}
