<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ExceptionFormatter
 */
class ExceptionFormatter extends DefaultFormatter implements ExceptionFormatterInterface
{
    /** @var string */
    protected $requestExceptionAttribute;

    /**
     * @param string $requestExceptionAttribute
     */
    public function setRequestExceptionAttribute($requestExceptionAttribute)
    {
        $this->requestExceptionAttribute = $requestExceptionAttribute;
    }

    /**
     * Overload getLogContent to add details about the exception.
     *
     * @param Request  $request  Request service
     * @param Response $response Response service
     * @param array    $options  Request options
     *
     * @return string
     */
    public function getLogContent(Request $request, Response $response, array $options)
    {
        $logContent = parent::getLogContent($request, $response, $options);

        if ($request->attributes->has($this->requestExceptionAttribute)) {
            $exception = $request->attributes->get($this->requestExceptionAttribute);

            $logContent .= $this->getExceptionTrace($exception);
        }

        return $logContent;
    }

    /**
     * @param int $level
     *
     * @return string
     */
    protected function getExceptionTrace(\Throwable $exception, $level = 1)
    {
        $exceptionTrace = $this->formatException($exception, $level);

        if (($previousException = $exception->getPrevious()) !== null) {
            $exceptionTrace .= $this->getExceptionTrace($previousException, $level + 1);
        }

        return $exceptionTrace;
    }

    /**
     * @param int $level
     *
     * @return string
     */
    protected function formatException(\Throwable $exception, $level = 1)
    {
        return
            "\nException class : \n------------------------\n".get_class($exception)."\n".
            "\nException message ($level) :\n------------------------\n".$exception->getMessage()."\n".
            "\nException trace ($level) :\n------------------------\n".$exception->getTraceAsString()."\n";
    }
}
