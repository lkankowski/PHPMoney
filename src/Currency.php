<?php declare(strict_types = 1);

namespace Finance;

use Exception;


class Currency
{
    private string $currencySymbol;
    private const CURRENCIES = ["PLN", "USD", "EUR"];

    public function __construct(string $currencySymbol)
    {
        if (! in_array($currencySymbol, self::CURRENCIES)) {
            throw new InvalidCurrencyException();
        }
        $this->currencySymbol = $currencySymbol;
    }

    public function getStringValue(): string
    {
        return $this->currencySymbol;
    }
}
