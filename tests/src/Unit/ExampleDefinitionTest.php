<?php

declare(strict_types=1);

namespace Drupal\Tests\ui_examples\Unit;

use Drupal\Core\Url;
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
  public static function definitionGettersProvider(): array {
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

  /**
   * Test getLinks.
   *
   * @param array $links
   *   The links like in the YAML declaration.
   * @param array $expected
   *   The expected result.
   *
   * @covers ::getLinks
   *
   * @dataProvider definitionGetLinksProvider
   */
  public function testGetLinks(array $links, array $expected): void {
    $definition = new ExampleDefinition([
      'links' => $links,
    ]);
    $this->assertEquals($expected, $definition->getLinks());
  }

  /**
   * Provider.
   *
   * @return array
   *   Data.
   */
  public static function definitionGetLinksProvider(): array {
    return [
      [
        [
          'https://test.com',
          [
            'url' => 'https://example.com',
            'title' => 'Example',
          ],
        ],
        [
          [
            'url' => 'https://test.com',
            'title' => 'External documentation',
          ],
          [
            'url' => 'https://example.com',
            'title' => 'Example',
          ],
        ],
      ],
    ];
  }

  /**
   * Test getRenderLinks.
   *
   * @param array $links
   *   The links like in the YAML declaration.
   * @param array $expected
   *   The expected result.
   *
   * @covers ::getRenderLinks
   *
   * @dataProvider definitionGetRenderLinksProvider
   */
  public function testGetRenderLinks(array $links, array $expected): void {
    $definition = new ExampleDefinition([
      'links' => $links,
    ]);
    $this->assertEquals($expected, $definition->getRenderLinks());
  }

  /**
   * Provider.
   *
   * @return array
   *   Data.
   */
  public static function definitionGetRenderLinksProvider(): array {
    return [
      [
        [
          'https://test.com',
          [
            'url' => 'https://example.com',
            'title' => 'Example',
          ],
        ],
        [
          [
            '#type' => 'link',
            '#url' => Url::fromUri('https://test.com'),
            '#title' => 'External documentation',
          ],
          [
            '#type' => 'link',
            '#url' => Url::fromUri('https://example.com'),
            '#title' => 'Example',
          ],
        ],
      ],
    ];
  }

}
