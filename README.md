# UI Examples

## Introduction

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
* `album` is the plugin ID. The page path is built from the plugin ID.
* `label` is used in the library.
* `description` is used in the library.
* `render` is the render array to render on the example page.

You can disable a plugin by declaring a plugin with the same ID and if your
module has a higher weight than the module declaring the plugin, example:

```yaml
album:
  enabled: false
```

See the test modules for a complete example.

## RECOMMENDED MODULES

[UI Suite Bootstrap](https://github.com/pdureau/ui_suite_bootstrap) is an
example of a site-building friendly Drupal theme using
[UI Examples](https://www.drupal.org/project/ui_examples) with
[UI Patterns](https://www.drupal.org/project/ui_patterns),
[Layout Options](https://www.drupal.org/project/layout_options) and
[UI Styles](https://www.drupal.org/project/ui_styles) modules, to implements
[Bootstrap](https://getbootstrap.com/) 4:

![Overview](doc/schema.png)


## INSTALLATION

Install and enable this module like any other Drupal module.


## CONFIGURATION

The module has no modifiable settings.


MAINTAINERS
-----------

Current maintainers:
* Pierre Dureau (pdureau) - https://www.drupal.org/user/1903334
* Florent Torregrosa (Grimreaper) - https://www.drupal.org/user/2388214

This project has been sponsored by:
* Smile - http://www.smile.fr
