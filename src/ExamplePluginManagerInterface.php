<?php

declare(strict_types=1);

namespace Drupal\ui_examples;

use Drupal\Component\Plugin\PluginManagerInterface;

/**
 * Defines an interface for ui_examples plugin managers.
 */
interface ExamplePluginManagerInterface extends PluginManagerInterface {

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\ui_examples\Definition\ExampleDefinition|null
   *   The plugin definition. NULL if not found.
   *
   * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
   */
  public function getDefinition($plugin_id, $exception_on_invalid = TRUE);

  /**
   * {@inheritdoc}
   *
   * @return \Drupal\ui_examples\Definition\ExampleDefinition[]
   *   The plugins definitions.
   */
  public function getDefinitions();

}
