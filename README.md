Font Awesome InsertTag
======================

Diese Erweiterung ist aus der Erweiterung [netzmacht/contao-font-awesome](https://github.com/netzmacht/contao-font-awesome)
extrahiert wurden und bietet **keine** neuen Funktionen.

Sie bietet einen InsertTag an, der für Font-Awesome Icons ersetzt:

Der InsertTag
-------------

Folgende Formate werden unterstützt:

 * Alle Attribute nach dem ersten `::` erhalten den `fa-` Prefix: `{{fa::phone}}` 
   ```html
   <i class="fa fa-phone"></i>
   ```
 * Dabei können mehrere Attribute angegeben werden: `{{fa::phone 4x muted}}`
   ```html
   <i class="fa fa-phone fa-4x fa-muted"></i>
   ```
 * Weiterhin können weitere Klassen mitgegebn werden: `{{fa::phone 4x muted::pull-left custom}}`
  ```html
  <i class="fa fa-phone fa-4x fa-muted pull-left custom"></i>
  ```

Das Icon-Template
-----------------

Soll statt dem `<i>` - Tag ein Span verwendet werden? Kein Problem. Der InsertTag basiert auf einen Template:

Dieser kann z.b. in `system/config/initconfig.php` überschrieben werden:

```php
$GLOBALS['TL_CONFIG']['faInsertTagTemplate'] = '<i class="fa fa-%s"></i>';
```

