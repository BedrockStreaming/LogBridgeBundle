<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

/**
 * Interface ExceptionFormatterInterface
 *
 * @package M6Web\Bundle\LogBridgeBundle\Formatter
 */
interface ExceptionFormatterInterface extends FormatterInterface
{
    /**
     * @param string $requestExceptionAttribute
     *
     * @return void
     */
    public function setRequestExceptionAttribute($requestExceptionAttribute);
}
