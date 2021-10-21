<?php

declare(strict_types = 1);

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
  public static $modules = [
    'ui_examples',
    'ui_examples_test',
  ];

  /**
   * Tests that examples can be provided by YAML files.
   */
  public function testDetectedExamples() {
    /** @var \Drupal\ui_examples\ExamplePluginManagerInterface $examples_manager */
    $examples_manager = $this->container->get('plugin.manager.ui_examples');
    $definitions = $examples_manager->getDefinitions();

    $this->assertEquals(1, count($definitions), 'There is one example detected.');

    $expectations = [
      'test' => [
        'id' => 'test',
        'provider' => 'ui_examples_test',
        'label' => $this->t('Test'),
        'description' => $this->t('Test plugin.'),
        'enabled' => TRUE,
      ],
    ];
    foreach ($expectations as $example_id => $expected_example_structure) {
      foreach ($expected_example_structure as $key => $value) {
        $this->assertEquals($value, $definitions[$example_id][$key]);
      }
    }
  }

  /**
   * Test that it is possible to override an already declared example.
   */
  public function testOverridingDefinition() {
    $this->enableModules(['ui_examples_test_disabled']);

    // Test when the module overriding the definition is executed before.
    module_set_weight('ui_examples_test_disabled', -1);
    /** @var \Drupal\ui_examples\ExamplePluginManagerInterface $examples_manager */
    $examples_manager = $this->container->get('plugin.manager.ui_examples');
    $this->assertArrayHasKey('test', $examples_manager->getDefinitions());

    // Test when the module overriding the definition is executed after.
    module_set_weight('ui_examples_test_disabled', 1);
    drupal_flush_all_caches();
    /** @var \Drupal\ui_examples\ExamplePluginManagerInterface $examples_manager */
    $examples_manager = $this->container->get('plugin.manager.ui_examples');
    $this->assertArrayNotHasKey('test', $examples_manager->getDefinitions());
  }

}