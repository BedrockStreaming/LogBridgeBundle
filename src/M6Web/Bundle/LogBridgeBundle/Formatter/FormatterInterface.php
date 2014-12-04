<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface FormatterInterface
 *
 * @package M6Web\Bundle\LogBridgeBundle\Formatter
 */
interface FormatterInterface
{
    /**
     * @param Request  $request  Request service
     * @param Response $response Response service
     * @param array    $options  Request options
     *
     * @return string
     */
    public function getLogContent(Request $request, Response $response, array $options);

    /**
     * @param Request  $request  Request service
     * @param Response $response Response service
     * @param array    $options  Request options
     *
     * @return string
     */
    public function getLogContext(Request $request, Response $response, array $options);

}
