# Laravel Treasury

[![PHP Quality Checks](https://github.com/drradao/laravel-treasury/actions/workflows/main.yml/badge.svg)](https://github.com/drradao/laravel-treasury/actions/workflows/main.yml)

## Preface

This package is still under development and is not ready for production use, it's kind of a proof of concept. I'll be using it in my own projects and will be updating it as I go. Feel free to use it at your own risk.
Since I've never used it, I don't know if I'll keep these flows or if I'll change them in the future. **Things will probably change a lot.**

_(This readme is a work in progress, also.)_

## Introduction

Laravel Treasury is a package that allows you to manage your application's internal currencies.
It provides a simple and laravelish way to debit and credit your users' vaults.

There are many alternatives to this package that can be a bit overwhelming for some simple use cases, hence the creation of this package.

## Installation

### Package installation

> Not yet available on packagist. As soon as I'm happy with it, I'll publish it there.

Add the repository to your `composer.json` file:

```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/drradao/laravel-treasury.git"
      }
    ]
}
```

Install the package via composer:

```bash
composer require drradao/laravel-treasury
```


### Preparing your owner models

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use \DRRAdao\Treasury\Traits\HasVaults;

    // ...
}
```

---

## Usage

### Opening a vault

```php
// Credits vault (default)
$user->vault('credits');

// Gold vault
$user->vault('gold');
```

### Debiting and crediting

```php
// Debiting
$user->vault('credits')->debit(100);

// Crediting
$user->vault('credits')->credit(100);
```

### Checking balance

```php
// Current balance
$user->vault('credits')->balance();
```

### Recreating balance from transactions

```php
$user->vault('credits')->syncBalance();
```


### Listing transactions

```php
Get a query builder instance for the transactions of a vault
$user->vault('credits')->transactions();
```

---

## Configuration

### Publishing the config file

```bash
php artisan vendor:publish --provider="DRRAdao\LaravelTreasury\TreasuryServiceProvider" --tag="config"
```

### Currencies

You can define your currencies in the `config/treasury.php` file.

```php
return [
    'currencies' => [
        'gold' => [
            'max_balance' => 16777215,
        ],
        'diamonds' => [
            'max_balance' => 2000,
        ],
    ],
];
```

> Maybe I'll add more options in the future. Maybe a unit. 

## Digging deeper

> This section is still a work in progress. A deeper look into the package's internals will be added here.
> 
> How the vaults are created, how the transactions are stored, etc.
> Some of the logic will be explained, like the TreasureKeeper and CurrencyVault classes.

## Roadmap

- [ ] Add tests
- [ ] Add more configuration options
- [ ] Add more documentation
- [ ] Add more examples
- [ ] Add more features (but keep it simple)
