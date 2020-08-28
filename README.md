# Government Bundle

[![Build Status](https://travis-ci.org/avkluchko/government-bundle.svg)](https://travis-ci.org/avkluchko/government-bundle)
[![Total Downloads](https://poser.pugx.org/avkluchko/government-bundle/downloads)](https://packagist.org/packages/avkluchko/government-bundle)
[![Latest Stable Version](https://poser.pugx.org/avkluchko/government-bundle/v/stable)](https://packagist.org/packages/avkluchko/government-bundle)
[![License](https://poser.pugx.org/avkluchko/government-bundle/license)](https://packagist.org/packages/avkluchko/government-bundle)

Utilities for use with official Russians classifiers and dictionaries.

## Requirements

The minumum requirement by Government Bundle is that your web-server supports PHP 7.1 or above. 

**Warning!** If your server use PHP x32, than will work only simple validation without check control sum.

## Installation

Install the package with:

```console
composer require avkluchko/government-bundle
```

If you're *not* using Symfony Flex, you'll also
need to enable the `AVKluchko\GovernmentBundle\GovernmentBundle`
in your `AppKernel.php` file

## Usage

PSRN Validator - validate Primary State Registration Number (OGRN).

```php
// src/Controller/SomeController.php
use AVKluchko\GovernmentBundle\Validator\OGRNValidator;

// ...
class SomeController
{
    public function index(OGRNValidator $validator)
    {
        $isValid = $validator->isValid('some_psrn');
        // ...
    }
}
```
