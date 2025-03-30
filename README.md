# PhPease [![Continuous Integration](https://badgen.net/github/checks/timoreith/PhPease/main)](https://github.com/timoreith/PhPease/actions) [![Latest Release](https://badgen.net/github/release/timoreith/PhPease)](https://github.com/timoreith/PhPease/releases/latest)

Little PHP helpers with the purpose of easing and abstracting code for recurring tasks.

## Installation

To install the package, use Composer:

```sh
composer require timoreith/phpease
```

## Usage Examples

Here are some examples of how to use the classes and functions provided by this package:

### ResultContainer

```php
use PhPease\ResultContainer;

$result = new ResultContainer();
$result->setSuccess(true)
       ->setMessage('Operation successful')
       ->setResult(['data' => 'value']);

echo $result->toJson();
```

### var_to_array

```php
use function PhPease\Variable\var_to_array;

// Example 1: Convert a string to an array
$string = "apple, banana, cherry";
$array = var_to_array($string);
print_r($array); // Output: ['apple', 'banana', 'cherry']

// Example 2: Convert a string to an array and apply a callback
$string = "1, 2, 3";
$array = var_to_array($string, 'intval');
print_r($array); // Output: [1, 2, 3]
```

## Running Tests

To run the tests, use PHPUnit:

```sh
./vendor/bin/phpunit
```

## Contributing
Feel free to contribute by submitting issues or pull requests. Please follow the coding standards and write tests for new features.  

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

