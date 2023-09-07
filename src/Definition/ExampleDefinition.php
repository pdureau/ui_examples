<?php

declare(strict_types = 1);

namespace Drupal\ui_examples\Definition;

use Drupal\Component\Plugin\Definition\PluginDefinition;
use Drupal\Core\Url;

/**
 * Example definition class.
 */
class ExampleDefinition extends PluginDefinition {

  /**
   * Example definition.
   *
   * @var array
   */
  protected array $definition = [
    'id' => '',
    'enabled' => TRUE,
    'label' => '',
    'description' => '',
    'links' => [],
    'render' => '',
    'weight' => 0,
    'additional' => [],
    'provider' => '',
  ];

  /**
   * Constructor.
   */
  public function __construct(array $definition = []) {
    foreach ($definition as $name => $value) {
      if (\array_key_exists($name, $this->definition)) {
        $this->definition[$name] = $value;
      }
      else {
        $this->definition['additional'][$name] = $value;
      }
    }

    $this->id = $this->definition['id'];
  }

  /**
   * Getter.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|string
   *   Property value.
   */
  public function getLabel() {
    return $this->definition['label'];
  }

  /**
   * Setter.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup|string $label
   *   Property value.
   *
   * @return $this
   */
  public function setLabel($label) {
    $this->definition['label'] = $label;
    return $this;
  }

  /**
   * Getter.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|string
   *   Property value.
   */
  public function getDescription() {
    return $this->definition['description'];
  }

  /**
   * Setter.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup|string $description
   *   Property value.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->definition['description'] = $description;
    return $this;
  }

  /**
   * Getter.
   *
   * @return bool
   *   Property value.
   */
  public function isEnabled(): bool {
    return $this->definition['enabled'];
  }

  /**
   * Getter.
   *
   * @return array
   *   Render array.
   */
  public function getRender(): array {
    return $this->definition['render'];
  }

  /**
   * Setter.
   *
   * @param array $render
   *   Render array.
   *
   * @return $this
   */
  public function setRender(array $render) {
    $this->definition['render'] = $render;
    return $this;
  }

  /**
   * Getter.
   *
   * @return int
   *   Property value.
   */
  public function getWeight(): int {
    return $this->definition['weight'];
  }

  /**
   * Setter.
   *
   * @param int $weight
   *   Property value.
   *
   * @return $this
   */
  public function setWeight(int $weight) {
    $this->definition['weight'] = $weight;
    return $this;
  }

  /**
   * Getter.
   *
   * @return array
   *   Property value.
   */
  public function getAdditional(): array {
    return $this->definition['additional'];
  }

  /**
   * Setter.
   *
   * @param array $additional
   *   Property value.
   *
   * @return $this
   */
  public function setAdditional(array $additional) {
    $this->definition['additional'] = $additional;
    return $this;
  }

  /**
   * Getter.
   *
   * @return string
   *   Property value.
   */
  public function getProvider(): string {
    return $this->definition['provider'];
  }

  /**
   * Setter.
   *
   * @param string $provider
   *   Property value.
   *
   * @return $this
   */
  public function setProvider(string $provider) {
    $this->definition['provider'] = $provider;
    return $this;
  }

  /**
   * Getter.
   *
   * @return array
   *   The link.
   */
  public function getLinks(): array {
    $links = [];

    foreach ($this->definition['links'] as $link) {
      if (!\is_array($link)) {
        $link = [
          'url' => $link,
        ];
      }

      $link += [
        'title' => 'External documentation',
      ];

      $links[] = $link;
    }

    return $links;
  }

  /**
   * Construct render links.
   *
   * @return array
   *   Render links.
   */
  public function getRenderLinks(): array {
    $renderLinks = [];
    foreach ($this->getLinks() as $link) {
      $renderLinks[] = $this->renderLink($link);
    }
    return $renderLinks;
  }

  /**
   * Setter.
   *
   * @param array $links
   *   Property value.
   *
   * @return $this
   */
  public function setLinks(array $links) {
    $this->definition['links'] = $links;
    return $this;
  }

  /**
   * Return array definition.
   *
   * @return array
   *   Array definition.
   */
  public function toArray(): array {
    $definition = $this->definition;
    $definition['render_links'] = $this->getRenderLinks();
    return $definition;
  }

  /**
   * Render link.
   *
   * @param array $link
   *   A link from getLinks method.
   *
   * @return array
   *   The link render element.
   */
  protected function renderLink(array $link): array {
    $renderLink = [
      '#type' => 'link',
      '#title' => $link['title'],
    ];

    if (!empty($link['url'])) {
      $renderLink['#url'] = Url::fromUri($link['url']);
    }

    if (!empty($link['options'])) {
      $renderLink['#options'] = $link['options'];
    }

    if (!empty($link['attributes'])) {
      $renderLink['#attributes'] = $link['attributes'];
    }

    return $renderLink;
  }

}
