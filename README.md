# Money Class

## Assumptions
* PHP 8.1 (cli)
* Can be negative (i.e. on corrective invoice)
* Fraction of value must be correctly rounded - float types are not appropriate
* The value will be stored as string - can be changed later if needed (i.e. dedicated class for numbers)
* Rounding to 0.01 - for some currencies the smalest amount can be different (0.5, 0.1, 1, 5, etc.), so if needed it must be changed
* Calculations must be in the same currency - otherwise throw exception
* Currencies supported: USD, EUR, PLN
* For calculations use `BC Math Functions`
  * `Money::add` also implemented as pure string operations, but commented out - if we don't want to have dependency on 'BC Math', then it should be moved to separate class
* Instances of Money are immutable
* Preffered self descriptive names and strict typing over comments

# Build
```
composer install
```

## Run test
```
.\vendor\bin\phpunit
```

## Troubleshoting
When class not found, try:
```
composer dump-autoload
```
