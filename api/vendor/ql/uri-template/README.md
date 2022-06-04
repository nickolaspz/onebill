# URI Template #

[![Build Status](https://travis-ci.org/QuickenLoans/uri-template.png?branch=master)](https://travis-ci.org/QuickenLoans/uri-template) [![Coverage Status](https://coveralls.io/repos/QuickenLoans/uri-template/badge.png?branch=master)](https://coveralls.io/r/QuickenLoans/uri-template?branch=master) [![Latest Stable Version](https://poser.pugx.org/ql/uri-template/v/stable.png)](https://packagist.org/packages/ql/uri-template)

This is a full implementation of [RFC 6570](http://tools.ietf.org/html/rfc6570).

There are many other PHP implementations of RFC 6570 out there, but this one
tries to go above and beyond with the following features:

- Takes care to handle non-ascii character encoding issues properly.
- Has 100% unit test code coverage.
- Unit tests not only the RFC examples of non-error scenarios but also failure
  situations covered by the text.
- Does not use any regular expressions.
- The main expander is a PHP class that is invokable, allowing for easy use and
  allowing it to be autoloaded (unlike a single function).
- This package also priovides a 'strict class' that will throw an exeption if
  the URI template uses invalid syntax in any way if your code wants to
  gaurentee the template before using it.
- This package works with HHVM without issue.

This particular implementation only allows URI templates in the UTF-8 character
set.

## Installation ##

This code is available through `composer`. Use `ql/uri-template` as the package
name in your require section in the `composer.json` file and you'll be all set.

This is a minimal `composer.json` file that includes this package:

```json
{
    "require": {
        "ql/uri-template": "1.*"
    }
}
```

## Usage ##

```php
<?php
use QL\UriTemplate\UriTemplate;

$tpl = '/authenticate/{username}{?password}';
$tpl = new UriTemplate($tpl);

$url = $tpl->expand([
    'username' => 'mnagi',
    'password' => 'hunter2',
]);

echo $url; // outputs "/authenticate/mnagi?password=hunter2"
```

Note that the above example throws exceptions for an invalid template or an
invalid set of variables. Some applications may *expect* malformed URI
templates and wish to deal with them in a more graceful way. In this case it is
recommended you use the `Expander` class directly.

```php
<?php
use QL\UriTemplate\Expander;

$tpl = '/authenticate/{username}{?password}';
$exp = new Expander;

$url = $exp($tpl, ['username' => 'mnagi', 'password' => 'hunter2' ]);

echo $url; // outputs "/authenticate/mnagi?password=hunter2"
```

### Handling Errors

The difference between the two (other than how they are invoked) is when there
are errors of some kind:

```php
<?php
use QL\UriTemplate\Expander;
use QL\UriTemplate\UriTemplate;
use QL\UriTemplate\Exception;

$badTpl = '/foo{ba';
$expander = new Expander;

// error with template in Expander
$expander($badTpl, []);
echo $expander->lastError() . "\n"; // "Unclosed expression at offset 4: /foo{ba"

// error with template in UriTemplate
try {
    $tpl = new UriTemplate($badTpl);
} catch (Exception $e) {
    echo $e->getMessage() . "\n"; // outputs "Unclosed expression at offset 4: /foo{ba"
}

// error with variables in template
$expander('/foo/{bar}', ['bar' => new stdClass]);
echo $expander->lastError() . "\n"; // "Objects without a __toString() method are not allowed as variable values."

// error with variables in UriTemplate
$tpl = new UriTemplate('/foo/{bar}');
$tpl->expand(['bar' => STDIN]); // this will throw an exception with message "Resources are not allowed as variable values."
```

### Options

The `Expander` class's invoke method allows an array of options to be passed in
to it. Right now the only option available is the ability to preserve template
variables if the calling code hasn't passed all of them in.

Take the following URI Template and set of variables:

```text
Template:  /events{?product,date,days,seats,before,at,after}
Variables: { "product": 10, "days": 20 }

"preserveTpl" set to false: /events?product=10&days=20
"preserveTpl" set to true:  /events?product=10&days=20{&date,seats,before,at,after}
```

A full code example of turning `preserveTpl` on:

```php
use QL\UriTemplate\Expander;

$tpl = '/events{?product,date,days,seats,before,at,after}';
$vars = ['product' => 10, 'days' => 20];
$expander = new Expander;
$result = $expander($tpl, $vars, ['preserveTpl' => true]);
echo $result . "\n";
```

## Requirements ##

This package requires PHP 5.6+ (though it will likely work in 5.5), the ctype 
extension and the mbstring extension. Additionally, it only allows for UTF-8
templates (though this could be changed in the future).
