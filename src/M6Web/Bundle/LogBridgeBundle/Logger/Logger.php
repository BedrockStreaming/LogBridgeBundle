<?php
/**
 * Class - not so cool - to build a default logger
 */


namespace M6Web\Bundle\LogBridgeBundle\Logger;

use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    protected $logger;

    /**
     * @param object $logger logger
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = array())
    {

        return $this->logger->emergency($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = array())
    {

        return $this->logger->alert($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = array())
    {

        return $this->logger->critical($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = array())
    {

        return $this->logger->error($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = array())
    {

        return $this->logger->warning($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = array())
    {

        return $this->logger->notice($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = array())
    {

        return $this->logger->info($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = array())
    {

        return $this->logger->debug($message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {

        return $this->logger->log($level, $message, $context);
    }
}