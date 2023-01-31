<?php

declare(strict_types = 1);

namespace Drupal\Tests\ui_examples\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\ui_examples\Definition\ExampleDefinition;

/**
 * @coversDefaultClass \Drupal\ui_examples\Definition\ExampleDefinition
 *
 * @group ui_examples
 */
class ExampleDefinitionTest extends UnitTestCase {

  /**
   * Test getters.
   *
   * @param string $getter
   *   The getter callback.
   * @param string $name
   *   The name of the plugin attributes.
   * @param mixed $value
   *   The attribute's value.
   *
   * @covers ::getCategory
   * @covers ::getDescription
   * @covers ::getLabel
   * @covers ::getRender
   * @covers ::getWeight
   * @covers ::id
   * @covers ::isEnabled
   *
   * @dataProvider definitionGettersProvider
   */
  public function testGetters(string $getter, string $name, $value): void {
    $definition = new ExampleDefinition([$name => $value]);
    // @phpstan-ignore-next-line
    $this->assertEquals(\call_user_func([$definition, $getter]), $value);
  }

  /**
   * Provider.
   *
   * @return array
   *   Data.
   */
  public function definitionGettersProvider(): array {
    return [
      ['getProvider', 'provider', 'my_module'],
      ['id', 'id', 'plugin_id'],
      ['getLabel', 'label', 'Plugin label'],
      ['getDescription', 'description', 'Plugin description.'],
      ['getRender', 'render', ['#plain_text' => 'Hello world']],
      ['getWeight', 'weight', 10],
      ['isEnabled', 'enabled', FALSE],
      ['isEnabled', 'enabled', TRUE],
    ];
  }

}
