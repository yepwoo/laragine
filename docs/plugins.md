## Plugins

**Note:** it's important to read the module and unit sections first

To create a new module or a new unit to the plugins directory you can do so by adding `--plugins` option to the commands

Here is a complete example:

Creating New module:
```bash
php artisan laragine:module Todo --plugins
```
Initializing a unit:
```bash
php artisan laragine:unit Task --module=Todo --init --plugins
```
Publishing the unit:
```bash
php artisan laragine:unit Task --module=Todo --plugins
```