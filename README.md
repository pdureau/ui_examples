# UI Examples

This module allows developers to provide example pages from modules or themes by
defining render arrays in a YAML files.

Examples library is located at `/examples`.

Each example page is a plugin, declared like that:

```yaml
album:
  label: 'Bootstrap Album'
  description: 'Simple one-page template for photo galleries and more.'
  render:
    ...
```

Where:
- `album` is the plugin ID. The page path is built from the plugin ID.
- `label` is used in the library.
- `description` is used in the library.
- `render` is the render array to render on the example page.

You can disable a plugin by declaring a plugin with the same ID and if your
module has a higher weight than the module declaring the plugin, example:

```yaml
album:
  enabled: false
```

See the test modules for a complete example.


## Requirements

This module requires no modules outside of Drupal core.


## Installation

Install as you would normally install a contributed Drupal module. For further
information, see
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).


## Configuration

The module has no modifiable settings. There is no configuration.
