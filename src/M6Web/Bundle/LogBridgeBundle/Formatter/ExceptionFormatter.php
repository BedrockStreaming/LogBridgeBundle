<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ExceptionFormatter
 */
class ExceptionFormatter extends DefaultFormatter implements ExceptionFormatterInterface
{
    protected string $requestExceptionAttribute;

    public function setRequestExceptionAttribute(string $requestExceptionAttribute): void
    {
        $this->requestExceptionAttribute = $requestExceptionAttribute;
    }

    public function getLogContent(Request $request, Response $response, array $options): string
    {
        $logContent = parent::getLogContent($request, $response, $options);

        if ($request->attributes->has($this->requestExceptionAttribute)) {
            $exception = $request->attributes->get($this->requestExceptionAttribute);

            $logContent .= $this->getExceptionTrace($exception);
        }

        return $logContent;
    }

    protected function getExceptionTrace(\Throwable $exception, int $level = 1): string
    {
        $exceptionTrace = $this->formatException($exception, $level);

        if (($previousException = $exception->getPrevious()) !== null) {
            $exceptionTrace .= $this->getExceptionTrace($previousException, $level + 1);
        }

        return $exceptionTrace;
    }

    protected function formatException(\Throwable $exception, int $level = 1): string
    {
        return
            "\nException class : \n------------------------\n".get_class($exception)."\n".
            "\nException message ($level) :\n------------------------\n".$exception->getMessage()."\n".
            "\nException trace ($level) :\n------------------------\n".$exception->getTraceAsString()."\n";
    }
}
