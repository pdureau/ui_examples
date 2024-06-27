<?php

declare(strict_types=1);

namespace Drupal\Tests\ui_examples\Kernel;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests the UI Examples plugin manager.
 *
 * @group ui_examples
 */
class PluginTest extends KernelTestBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'ui_examples',
    'ui_examples_test',
  ];

  /**
   * Tests that examples can be provided by YAML files.
   */
  public function testDetectedExamples(): void {
    /** @var \Drupal\ui_examples\ExamplePluginManagerInterface $examples_manager */
    $examples_manager = $this->container->get('plugin.manager.ui_examples');
    /** @var array $definitions */
    $definitions = $examples_manager->getDefinitions();

    $this->assertEquals(1, \count($definitions), 'There is one example detected.');

    $expectations = [
      'test' => [
        'id' => 'test',
        'provider' => 'ui_examples_test',
        'label' => $this->t('Test'),
        'description' => $this->t('Test plugin.'),
        'links' => [
          [
            'url' => 'https://test.com',
            'title' => 'External documentation',
          ],
          [
            'url' => 'https://example.com',
            'title' => 'Example',
          ],
        ],
        'enabled' => TRUE,
      ],
    ];
    foreach ($expectations as $plugin_id => $expected_plugin_structure) {
      $definition_as_array = $definitions[$plugin_id]->toArray();
      foreach ($expected_plugin_structure as $key => $value) {
        $this->assertEquals($value, $definition_as_array[$key]);
      }
    }
  }

  /**
   * Test that it is possible to override an already declared example.
   */
  public function testOverridingDefinition(): void {
    $this->enableModules(['ui_examples_test_disabled']);

    // Test when the module overriding the definition is executed before.
    \module_set_weight('ui_examples_test_disabled', -1);
    /** @var \Drupal\ui_examples\ExamplePluginManagerInterface $examples_manager */
    $examples_manager = $this->container->get('plugin.manager.ui_examples');
    $this->assertArrayHasKey('test', $examples_manager->getDefinitions());

    // Test when the module overriding the definition is executed after.
    \module_set_weight('ui_examples_test_disabled', 1);
    \drupal_flush_all_caches();
    /** @var \Drupal\ui_examples\ExamplePluginManagerInterface $examples_manager */
    $examples_manager = $this->container->get('plugin.manager.ui_examples');
    $this->assertArrayNotHasKey('test', $examples_manager->getDefinitions());
  }

}
