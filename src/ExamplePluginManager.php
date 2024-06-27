<?php

declare(strict_types=1);

namespace Drupal\ui_examples;

use Drupal\Component\Plugin\Exception\PluginException;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\ContainerDerivativeDiscoveryDecorator;
use Drupal\Core\Plugin\Discovery\YamlDirectoryDiscovery;
use Drupal\Core\Plugin\Discovery\YamlDiscoveryDecorator;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ui_examples\Definition\ExampleDefinition;

/**
 * Provides the default example manager.
 *
 * @method \Drupal\ui_examples\Definition\ExampleDefinition|null getDefinition($plugin_id, $exception_on_invalid = TRUE)
 * @method \Drupal\ui_examples\Definition\ExampleDefinition[] getDefinitions()
 */
class ExamplePluginManager extends DefaultPluginManager implements ExamplePluginManagerInterface {

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected ThemeHandlerInterface $themeHandler;

  /**
   * Provides default values for all style_plugin plugins.
   *
   * @var array
   */
  protected $defaults = [
    // Add required and optional plugin properties.
    'id' => '',
    'enabled' => TRUE,
    'label' => '',
    'description' => '',
    'render' => [],
    'weight' => 0,
    'additional' => [],
    'provider' => '',
  ];

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler.
   */
  public function __construct(
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler,
    ThemeHandlerInterface $theme_handler,
  ) {
    $this->setCacheBackend($cache_backend, 'ui_examples', ['ui_examples']);
    $this->alterInfo('ui_examples_examples');
    $this->moduleHandler = $module_handler;
    $this->themeHandler = $theme_handler;
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    // Search in ui_examples folder in modules and themes.
    $directories = \array_map(static function ($directory) {
      return [$directory . '/ui_examples'];
    }, $this->moduleHandler->getModuleDirectories() + $this->themeHandler->getThemeDirectories());
    $this->discovery = new YamlDirectoryDiscovery($directories, 'ui_examples');
    $this->discovery
      ->addTranslatableProperty('label', 'label_context')
      ->addTranslatableProperty('description', 'description_context');

    // Search ui_examples.yml files at the root of modules and themes.
    $this->discovery = new YamlDiscoveryDecorator($this->discovery, 'ui_examples', $this->moduleHandler->getModuleDirectories() + $this->themeHandler->getThemeDirectories());
    $this->discovery
      ->addTranslatableProperty('label', 'label_context')
      ->addTranslatableProperty('description', 'description_context');
    $this->discovery = new ContainerDerivativeDiscoveryDecorator($this->discovery);

    return $this->discovery;
  }

  /**
   * {@inheritdoc}
   *
   * @phpstan-ignore-next-line
   */
  protected function alterDefinitions(&$definitions) {
    /** @var \Drupal\ui_examples\Definition\ExampleDefinition[] $definitions */
    foreach ($definitions as $definition_key => $definition) {
      if (!$definition->isEnabled()) {
        unset($definitions[$definition_key]);
      }
    }

    parent::alterDefinitions($definitions);
  }

  /**
   * {@inheritdoc}
   *
   * @phpstan-ignore-next-line
   */
  public function processDefinition(&$definition, $plugin_id): void {
    // Call parent first to set defaults while still manipulating an array.
    // Otherwise, as there is currently no derivative system among CSS variable
    // plugins, there is no deriver or class attributes.
    parent::processDefinition($definition, $plugin_id);

    if (empty($definition['id'])) {
      throw new PluginException(\sprintf('Example plugin property (%s) definition "id" is required.', $plugin_id));
    }

    $definition = new ExampleDefinition($definition);

    // Makes links titles translatable.
    $links = \array_map(static function ($link) {
      if (\is_array($link) && !$link['title'] instanceof TranslatableMarkup) {
        // phpcs:ignore Drupal.Semantics.FunctionT.NotLiteralString
        $link['title'] = new TranslatableMarkup($link['title'], [], ['context' => 'ui_examples']);
      }
      return $link;
    }, $definition->getLinks());
    $definition->setLinks($links);
  }

  /**
   * {@inheritdoc}
   *
   * @phpstan-ignore-next-line
   */
  protected function providerExists($provider): bool {
    return $this->moduleHandler->moduleExists($provider) || $this->themeHandler->themeExists($provider);
  }

}
