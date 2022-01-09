## Testing

This section is very important and it's **`required`** to apply all the instructions here, in order for you to run the tests correctly.

We need to do 3 things in `phpunit.xml` in the root directory:

(1) change the value of `bootstrap` attribute to `vendor/yepwoo/laragine/src/autoload.php` in `phpunit` tag (it's the same as `vendor/autoload.php` but with needed stuff to run the tests correctly in the generated modules and units).

(2) add the following to `Unit` test suite:

`<directory suffix=".php">./core/*/Tests/Unit</directory>`

`<directory suffix=".php">./plugins/*/Tests/Unit</directory>`

(3) add the following to `Feature` test suite:

`<directory suffix=".php">./core/*/Tests/Feature</directory>`

`<directory suffix=".php">./plugins/*/Tests/Feature</directory>`

Here is the full code snippet:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/yepwoo/laragine/src/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
            <directory suffix=".php">./core/*/Tests/Unit</directory>
            <directory suffix=".php">./plugins/*/Tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
            <directory suffix=".php">./core/*/Tests/Feature</directory>
            <directory suffix=".php">./plugins/*/Tests/Feature</directory>
        </testsuite>
    </testsuites>

    ...

</phpunit>
```