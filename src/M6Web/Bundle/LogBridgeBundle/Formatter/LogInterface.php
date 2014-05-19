<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface LogInterface {

    public function getLogContent(Request $request, Response $response);
    public function getLogContext(Request $request, Response $response);

} 