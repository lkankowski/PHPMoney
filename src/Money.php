<?php declare(strict_types = 1);

namespace Finance;

use InvalidArgumentException;
use DivisionByZeroError;


class Money
{
    private string $amount;
    private Currency $currency;

    // when we need some advanced rounding policy, we could create
    // external calculator and inject it to this class for calculations

    public function __construct(string $amount, Currency $currency)
    {
        $amount = $this->sanitizeAmount($amount);
        if (! $this->isValidAmount($amount)) {
            throw new InvalidArgumentException();
        }
        $this->amount = $amount;
        $this->currency = $currency;
    }

    // candidate to extract to separate class/trait
    public static function create(string|int $amount, string $currency): Money
    {
        return new Money((string) $amount, new Currency($currency));
    }

    private function isValidAmount(string $amount): bool
    {
        return preg_match("/^-?\d+(\.\d{1,2})?$/", $amount) === 1; // can be slow - if needed change to str operations
    }

    private function sanitizeAmount(string $amount): string
    {
        $sign = substr($amount, 0, 1) === "-" ? "-" : "";
        $sanitizedAmount = ltrim($amount, "-0"); // remove leading zeros
        if (($sanitizedAmount === "") || (substr($sanitizedAmount, 0, 1) === ".")) {
            $sanitizedAmount = "0" . $sanitizedAmount;
        }
        return $sign . $sanitizedAmount;
    }

    public function add(Money $money): Money
    {
        if ($money->getCurrency() != $this->getCurrency()) {
            throw new InvalidCurrencyException();
        }
        return new Money($this->amountAdd($this->amount, $money->getAmount()), $this->currency);
    }

    private function amountAdd(string $amount1, string $amount2): string
    {
        // list($integer1, $fraction1) = explode(".", $amount1);
        // list($integer2, $fraction2) = explode(".", $amount2);
        // $fractionLenght1 = strlen($fraction1);
        // $fractionLenght2 = strlen($fraction2);
        // $multiplier1 = pow(10, max($fractionLenght1, $fractionLenght2) - $fractionLenght1);
        // $multiplier2 = pow(10, max($fractionLenght1, $fractionLenght2) - $fractionLenght2);
        // $resultInt = strval((intval($integer1 . $fraction1) * $multiplier1)
        //           + (intval($integer2 . $fraction2) * $multiplier2));
        // $newInteger = substr($resultInt, 0, -max($fractionLenght1, $fractionLenght2));
        // $newFraction = substr($resultInt, -max($fractionLenght1, $fractionLenght2));
        // return $newInteger . "." . $newFraction;
        return bcadd($amount1, $amount2, 2);
    }

    public function substract(Money $money): Money
    {
        if ($money->getCurrency() != $this->getCurrency()) {
            throw new InvalidCurrencyException();
        }
        return new Money(bcsub($this->amount, $money->getAmount(), 2), $this->currency);
    }

    public function multiplyBy(Money $money): Money
    {
        if ($money->getCurrency() != $this->getCurrency()) {
            throw new InvalidCurrencyException();
        }
        return new Money(bcmul($this->amount, $money->getAmount(), 2), $this->currency);
    }

    public function divideBy(Money $money): Money
    {
        if ($money->getCurrency() != $this->getCurrency()) {
            throw new InvalidCurrencyException();
        }
        if ($money->getAmount() === "0") {
            throw new DivisionByZeroError();
        }
        return new Money(bcdiv($this->amount, $money->getAmount(), 2), $this->currency);
    }

    public function isEqual(): bool
    {
        return false;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
