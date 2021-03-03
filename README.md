Font Awesome InsertTag
======================

This extension provides two insert tags for creating font awesome icons in Contao CMS.

Features
--------

Font Awesome Inserttag supports FontAwesome 4 and FontAwesome 5 as well.

### Icon Insert Tags

There are a couple of insert tags for icon generation. For Font Awesome 4 there is the previously known `fa` insert tag.
To support the styles introduced in Font Awesome 5 there a specific insert tags the styles `fas`, `far`, `fal`, `fab`. 

Following options are supported:
 * All values after the first double column get prefixed with `fa-` Prefix: `{{fa::phone}}` 
   ```html
   <i class="fa fa-phone" aria-hidden="true"></i>
   ```
 * Multiple values are supported: `{{fa::phone 4x muted}}`
   ```html
   <i class="fa fa-phone fa-4x fa-muted" aria-hidden="true"></i>
   ```
 * Additional values could be passed as second param devided by a colon: `{{fa::phone 4x muted:pull-left custom}}`
  ```html
  <i class="fa fa-phone fa-4x fa-muted pull-left custom" aria-hidden="true"></i>
  ```
  The former syntax with a double colon "::" between two params is deprecated but still supported.

It works the same with the new short codes provided by Font Awesome 5. If you're migrating from Font Awesome 4 to 5 and
have some old insert tags you may have a look at the provided configuration option `default_style`.


### Insert Tag "fa-stack"

The second insert tag support the icon stack feature of font awesome. All features described above are supported for
every icon. Furthermore the icon stack wrapper itself can be adjusted by classes:

`{fa-stack::square:first-icon::plus:secon-icon::lg:custom-stack}`

```html
  <span class="fa-stack fa-lg custom-stack"><i class="fa fa-square first-icon" aria-hidden="true"></i><i class="fa fa-plus second-icon" aria-hidden="true"></i></span>
```

*Icon stacks only works with Font Awesome 4. Support of icon layers introduced in Font Awesome 5 is not supported yet.* 

Requirements
------------

Version 2 is designed for Contao 4.4 and above. It can be installed by using the managed edition of Contao.

If you want to add the bundle yourself just add `Netzmacht\Contao\FontAwesomeInsertTag\NetzmachtFontAwesomeInsertTagBundle` 
to your app kernel.


Configuration
-------------

You can override the templates being used for the icon or icon-stack in your config.yml. The default configuration is:

```yaml
config:
  netzmacht_font_awesome_insert_tag:
    icon_template: '<i class="%%s" aria-hidden="true"></i>'
    stack_template: '<span class="fa-stack%%s">%%s%%s</span>'
    default_style: 'fa'
```

If you migrate from Font Awesome 4 to 5 you might want to set the default style to `far` or `fas`.
