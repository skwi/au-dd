# Au DD Bundle

Enforce usage of proper debug tool by trolling teammates with an autoplaying video of PNL's "Au DD" song when using the `dd` method from the Symfony VarDumper Component.

## Installation

Via Composer

```sh
$ composer require skwi/au-dd-bundle --dev
```

## Usage

Simply install the bundle and wait for your teammates to use the `dd` function from Symfony VarDumper Component.

```php
<?php 

// [...]

dd($var);
```

Profit ! (and teach others [how to properly debug PHP code](https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html))
