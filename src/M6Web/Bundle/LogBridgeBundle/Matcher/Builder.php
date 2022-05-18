<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use M6Web\Bundle\LogBridgeBundle\Config\Parser as ConfigParser;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as StatusTypeManager;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Builder
 */
class Builder implements BuilderInterface
{
    /** @var StatusTypeManager */
    private $statusTypeManager;

    /** @var string */
    private $environment;

    /** @var array */
    private $cacheResources;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var Loader */
    private $configParser;

    /** @var bool */
    private $debug;

    /** @var string */
    private $cacheDir;

    /** @var string */
    private $matcherClassName;

    /** @var MatcherInterface */
    private $matcher;

    /** @var array */
    private $filters;

    /** @var array */
    private $activeFilters;

    /**
     * __construct
     *
     * @param StatusTypeManager $statusTypeManager Status type manager
     * @param array             $filters           Filters
     * @param array             $activeFilters     Active Filters
     * @param string            $environment       Environment name
     */
    public function __construct(StatusTypeManager $statusTypeManager, array $filters, array $activeFilters, $environment)
    {
        $this->statusTypeManager = $statusTypeManager;
        $this->filters = $filters;
        $this->activeFilters = $activeFilters;
        $this->environment = $environment;
        $this->dispatcher = null;
        $this->configParser = null;
        $this->debug = false;
        $this->cacheDir = '';
        $this->matcherClassName = '';
        $this->matcher = null;
    }

    /**
     * buildMatcherCache
     *
     * @return string
     */
    protected function buildMatcherCache()
    {
        $configs['filters'] = $this->filters;
        $configs['active_filters'] = $this->activeFilters;

        $configuration = $this->configParser->parse($configs);
        $dumper = new Dumper\PhpMatcherDumper($this->statusTypeManager, $this->environment);
        $options = [];

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
            $matcherCache = new ConfigCache($this->getAbsoluteCachePath(), $this->isDebug());

            if (!$matcherCache->isFresh()) {
                $cacheCode = $this->buildMatcherCache();
                $matcherCache->write($cacheCode);
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
     * isDebug
     *
     * @param bool $debug Debug
     *
     * @return bool
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
