<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface LogInterface
 *
 * @package M6Web\Bundle\LogBridgeBundle\Formatter
 */
interface LogInterface
{

    /**
     * @param Request  $request  Request service
     * @param Response $response Response service
     *
     * @return string
     */
    public function getLogContent(Request $request, Response $response);

    /**
     * @param Request  $request  Request service
     * @param Response $response Response service
     *
     * @return string
     */
    public function getLogContext(Request $request, Response $response);

} 