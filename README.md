# Money Class

## Assumptions
* PHP 8.1 (cli)
* Can be negative (i.e. on corrective invoice)
* Fraction of value must be correctly rounded - float/double types are not appropriate
* The value will be stored as string - can be changed later if needed (i.e. dedicated class for numbers)
* Rounding to 0.01 - for some currencies the smalest amount can be different (0.5, 0.1, 1, 5, etc.), so if needed it must be changed
* Calculations must be in the same currency - otherwise throw exception
* Currencies supported: USD, EUR, PLN

BC Math Functions ?
