# UI Examples

This module allows developers to provide example pages from modules or themes by defining render arrays in a YML files.


## Example of a plugin declaration in the YML file

```yaml
album:
  label: Bootstrap Album
  description: Simple one-page template for photo galleries, portfolios, and more. https://getbootstrap.com/docs/4.4/examples/album/
  render:
    ...
```

Where:

* `album` is the plugin ID. The page path is built from the plugin ID.
* 'label' is used in the library
* 'description' is used in the library
* 'render' is the render array to render on the page