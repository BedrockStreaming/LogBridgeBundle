<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use M6Web\Bundle\LogBridgeBundle\Config\Parser as ConfigParser;
use M6Web\Bundle\LogBridgeBundle\Config\Configuration;
use M6Web\Bundle\LogBridgeBundle\Config\Definition\FilterConfiguration;
use M6Web\Bundle\LogBridgeBundle\EventDispatcher\BuilderEvent;

/**
 * Builder
 */
class Builder implements BuilderInterface
{
    /**
     * @var string
     */
    const LOAD_RESOURCES_EVENT = 'm6web_log_bridge.load_resources';

    /**
     * @var string
     */
    const COMPILE_RESOURCES_EVENT = 'm6web_log_bridge.compile_resources';

    /**
     * @var array
     */
    private $resources;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var array
     */
    private $cacheResources;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var Loader
     */
    private $configParser;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var string
     */
    private $matcherClassName;

    /**
     * @var MatcherInterface
     */
    private $matcher;

    /**
     * __construct
     *
     * @param array  $resources   Resources
     * @param string $environment Environment name
     */
    public function __construct(array $resources, $environment)
    {
        $this->resources        = $resources;
        $this->environment      = $environment;
        $this->cacheResources   = [];
        $this->dispatcher       = null;
        $this->configParser     = null;
        $this->debug            = false;
        $this->cacheDir         = '';
        $this->matcherClassName = '';
        $this->matcher          = null;
    }

    /**
     * dispatch
     * Dispatch event if EventDispatcher service exists
     *
     * @param string $eventName Event name
     * @param Event  $event     Event class
     *
     * @internal param string $name Event name
     */
    protected function dispatch($eventName, $event)
    {
        if ($this->dispatcher) {
            $this->dispatcher->dispatch($eventName, $event);
        }
    }

    /**
     * loadConfigResources
     *
     * @return array
     */
    protected function loadConfigResources()
    {
        $config = [];
        $event  = new BuilderEvent($this, $config);

        /*
         * Dispatch event before Load and validate/compile resource
         * From add or extends configuration
         */
        $this->dispatch(self::LOAD_RESOURCES_EVENT, $event);

        $config = $event->getConfig();

        foreach ($this->resources as $resource) {
            $config = array_merge($config, $this->parse($resource));

            $this->cacheResources[] = $resource;
        }

        $event->setConfig($config);
        $this->dispatch(self::COMPILE_RESOURCES_EVENT, $event);

        return $event->getConfig();
    }

    /**
     * parse
     *
     * @param string $path File path
     *
     * @return array
     */
    protected function parse($path)
    {
        if (!is_file($path) || !$content = file_get_contents($path)) {
            throw new Exception(sprintf('failed to open stream: No such file or is not readable "%s"', $path));
        }

        return Yaml::parse($content, true);
    }

    /**
     * buildMatcherCache
     *
     * @return string
     */
    protected function buildMatcherCache()
    {
        $configs       = $this->loadConfigResources();
        $configuration = $this->configParser->parse($configs);
        $dumper        = new Dumper\PhpMatcherDumper($this->environment);
        $options       = array();

        if ($this->matcherClassName) {
            $options['class'] = $this->getMatcherClassName();
        }

        return $dumper->dump($configuration, $options);
    }

    /**
     * getMatcher
     *
     * @return MatcherInterface
     */
    public function getMatcher()
    {
        if (!$this->matcher) {
            $cacheCode    = $this->buildMatcherCache();
            $matcherCache = new ConfigCache($this->getAbsoluteCachePath(), $this->isDebug());

            if (!$matcherCache->isFresh()) {
                $resources = [];

                foreach ($this->cacheResources as $resource) {
                    $resources[] = new FileResource($resource);
                }

                $matcherCache->write($cacheCode, $resources);
            }

            require_once $this->getAbsoluteCachePath();

            $this->matcher = (new \ReflectionClass($this->getMatcherClassName()))->newInstance();
        }

        return $this->matcher;
    }

    /**
     * getAbsoluteCachePath
     * Absolute path matcher class
     *
     * @return string
     */
    public function getAbsoluteCachePath()
    {
        return sprintf('%s/%s.php', $this->getCacheDir(), $this->getMatcherClassName());
    }

    /**
     * setResources
     *
     * @param array $resources Resources
     *
     * @return Builder
     */
    public function setResources(array $resources)
    {
        $this->resources = $resources;

        return $this;
    }

    /**
     * getResources
     *
     * @return array
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * addResource
     *
     * @param string $resource Resource
     *
     * @return Builder
     */
    public function addResource($resource)
    {
        if (!in_array($resource, $this->resources)) {
            $this->resources[] = $resource;
        }

        return $this;
    }

    /**
     * setCacheResources
     *
     * @param array $cacheResources Resources
     *
     * @return Builder
     */
    public function setCacheResources(array $cacheResources)
    {
        $this->cacheResources = $cacheResources;

        return $this;
    }

    /**
     * getCacheResources
     *
     * @return array
     */
    public function getCacheResources()
    {
        return $this->cacheResources;
    }

    /**
     * addResource
     *
     * @param array $cacheResource
     *
     * @internal param string $resource Resource
     *
     * @return Builder
     */
    public function addCacheResource($cacheResource)
    {
        if (!in_array($cacheResource, $this->cacheResources)) {
            $this->cacheResources[] = $cacheResource;
        }

        return $this;
    }

    /**
     * isDebug
     *
     * @param boolean $debug Debug
     *
     * @return boolean
     */
    public function isDebug($debug = null)
    {
        if (is_bool($debug)) {
            $this->debug = $debug;
        }

        return $this->debug;
    }

    /**
     * setCacheDir
     *
     * @param string $cacheDir cache directory path
     *
     * @return Builder
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }

    /**
     * getCacheDir
     *
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * setDispatcher
     *
     * @param EventDispatcherInterface $dispatcher
     *
     * @return Builder
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * setConfigParser
     *
     * @param Loader $configParser Config loader
     *
     * @return Builder
     */
    public function setConfigParser(ConfigParser $configParser)
    {
        $this->configParser = $configParser;

        return $this;
    }

    /**
     * setMatcherClassName
     *
     * @param string $matcherClassName Matcher class name
     *
     * @return Builder
     */
    public function setMatcherClassName($matcherClassName)
    {
        $this->matcherClassName = $matcherClassName;

        return $this;
    }

    /**
     * getMatcherClassName
     *
     * @return string
     */
    public function getMatcherClassName()
    {
        return $this->matcherClassName;
    }

}
