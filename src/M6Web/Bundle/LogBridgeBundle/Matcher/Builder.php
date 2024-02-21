<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use M6Web\Bundle\LogBridgeBundle\Config\Parser as ConfigParser;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as StatusTypeManager;
use Symfony\Component\Config\ConfigCache;

/**
 * Builder
 */
class Builder implements BuilderInterface
{
    private ConfigParser $configParser;

    private bool $debug = false;

    private string $cacheDir = '';

    /** @var class-string<MatcherInterface> */
    private string $matcherClassName;

    private ?MatcherInterface $matcher = null;

    public function __construct(
        private StatusTypeManager $statusTypeManager,
        private array $filters,
        private array $activeFilters
    ) {
    }

    protected function buildMatcherCache(): string
    {
        $configs = [];
        $configs['filters'] = $this->filters;
        $configs['active_filters'] = $this->activeFilters;

        $configuration = $this->configParser->parse($configs);
        $dumper = new Dumper\PhpMatcherDumper($this->statusTypeManager);
        $options = [];

        if (isset($this->matcherClassName)) {
            $options['class'] = $this->getMatcherClassName();
        }

        return $dumper->dump($configuration, $options);
    }

    public function getMatcher(): MatcherInterface
    {
        if (!isset($this->matcher)) {
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
     * Absolute path matcher class
     */
    public function getAbsoluteCachePath(): string
    {
        return sprintf('%s/%s.php', $this->getCacheDir(), $this->getMatcherClassName());
    }

    public function isDebug(?bool $debug = null): bool
    {
        if (\is_bool($debug)) {
            $this->debug = $debug;
        }

        return $this->debug;
    }

    public function setCacheDir(string $cacheDir): self
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }

    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    public function setConfigParser(ConfigParser $configParser): self
    {
        $this->configParser = $configParser;

        return $this;
    }

    /**
     * @param class-string<MatcherInterface> $matcherClassName
     */
    public function setMatcherClassName(string $matcherClassName): self
    {
        $this->matcherClassName = $matcherClassName;

        return $this;
    }

    /**
     * @return class-string<MatcherInterface>
     */
    public function getMatcherClassName(): string
    {
        return $this->matcherClassName;
    }
}
