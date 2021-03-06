<?php

declare(strict_types=1);

/*
 * This file is part of the ekino Drupal Debug project.
 *
 * (c) ekino
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ekino\Drupal\Debug\Option;

use Ekino\Drupal\Debug\Action\DisplayPrettyExceptions\DisplayPrettyExceptionsOptions;
use Ekino\Drupal\Debug\Action\DisplayPrettyExceptionsASAP\DisplayPrettyExceptionsASAPOptions;
use Ekino\Drupal\Debug\Action\ThrowErrorsAsExceptions\ThrowErrorsAsExceptionsOptions;
use Ekino\Drupal\Debug\Action\WatchContainerDefinitions\WatchContainerDefinitionsOptions;
use Ekino\Drupal\Debug\Action\WatchModulesHooksImplementations\WatchModulesHooksImplementationsOptions;
use Ekino\Drupal\Debug\Action\WatchRoutingDefinitions\WatchRoutingDefinitionsOptions;
use Ekino\Drupal\Debug\Resource\Model\ResourcesCollection;
use Psr\Log\LoggerInterface;

class OptionsStackBuilder
{
    /**
     * @var OptionsInterface[]
     */
    private $options;

    private function __construct()
    {
        $this->options = array();
    }

    /**
     * @return OptionsStackBuilder
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return OptionsStack
     */
    public function getOptionsStack(): OptionsStack
    {
        return OptionsStack::create($this->options);
    }

    /**
     * @param string|null          $charset
     * @param string|null          $fileLinkFormat
     * @param LoggerInterface|null $logger
     */
    public function setDisplayPrettyExceptionsOptions(?string $charset, ?string $fileLinkFormat, ?LoggerInterface $logger): self
    {
        return $this->set(new DisplayPrettyExceptionsOptions($charset, $fileLinkFormat, $logger));
    }

    /**
     * @param string|null $charset
     * @param string|null $fileLinkFormat
     */
    public function setDisplayPrettyExceptionsASAPOptions(?string $charset, ?string $fileLinkFormat): self
    {
        return $this->set(new DisplayPrettyExceptionsASAPOptions($charset, $fileLinkFormat));
    }

    /**
     * @param int                  $levels
     * @param LoggerInterface|null $logger
     */
    public function setThrowErrorsAsExceptionsOptions(int $levels, ?LoggerInterface $logger): self
    {
        return $this->set(new ThrowErrorsAsExceptionsOptions($levels, $logger));
    }

    /**
     * @param string              $cacheFilePath
     * @param ResourcesCollection $resourcesCollection
     */
    public function setWatchContainerDefinitionsOptions(string $cacheFilePath, ResourcesCollection $resourcesCollection): self
    {
        return $this->set(new WatchContainerDefinitionsOptions($cacheFilePath, $resourcesCollection));
    }

    /**
     * @param string              $cacheFilePath
     * @param ResourcesCollection $resourcesCollection
     */
    public function setWatchModulesHooksImplementationsOptions(string $cacheFilePath, ResourcesCollection $resourcesCollection): self
    {
        return $this->set(new WatchModulesHooksImplementationsOptions($cacheFilePath, $resourcesCollection));
    }

    /**
     * @param string              $cacheFilePath
     * @param ResourcesCollection $resourcesCollection
     */
    public function setWatchRoutingDefinitionsOptions(string $cacheFilePath, ResourcesCollection $resourcesCollection): self
    {
        return $this->set(new WatchRoutingDefinitionsOptions($cacheFilePath, $resourcesCollection));
    }

    /**
     * @param OptionsInterface $options
     */
    private function set(OptionsInterface $options): self
    {
        $this->options[\get_class($options)] = $options;

        return $this;
    }
}
