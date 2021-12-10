<?php declare(strict_types = 1);

namespace Tests\Unit;

use Finance\Currency;
use Finance\Money;
use Finance\InvalidCurrencyException;
use InvalidArgumentException;
use DivisionByZeroError;
use PHPUnit\Framework\TestCase;


final class MoneyTest extends TestCase
{
    public function testValidCreateMoneyInstance(): void
    {
        $money1  = new Money("10", new Currency("USD"));
        $money2  = new Money("10.01", new Currency("USD"));
        $money3  = new Money("-10", new Currency("USD"));
        $money4  = new Money("-10.01", new Currency("USD"));
        $money5  = Money::create(10, "USD");
        $money6  = Money::create("10", "USD");
        $money7  = Money::create("10.01", "USD");
        $money8  = Money::create(-10, "USD");
        $money9  = Money::create("-10", "USD");
        $money10 = Money::create("-10.01", "USD");
        $money11 = Money::create("0", "USD");
        $money12 = Money::create(".01", "USD");
        $money13 = Money::create("-.01", "USD");

        $this->assertTrue(true); // no exception thrown
    }

    /**
     * @dataProvider moneyAmountInvalidCases
     */
    public function testInvalidCreateMoneyInstance($invalidAmount): void
    {
        $this->expectException(InvalidArgumentException::class);
        $money1 = new Money($invalidAmount, new Currency("USD"));
    }

    public function moneyAmountInvalidCases(): array
    {
        return [
            ["abc"], ["10.001"], ["-10.001"], ["10,01"]
        ];
    }

    public function testAddAmount(): void
    {
        // given
        $money1 = Money::create("100.74", "USD");
        $money2 = Money::create("50.05", "USD");

        // when
        $newMoney = $money1->add($money2);

        // then
        $this->assertEquals(Money::create("150.79", "USD"), $newMoney);
    }

    public function testSubstractAmount(): void
    {
        // given
        $money1 = Money::create("100.74", "USD");
        $money2 = Money::create("50.05", "USD");

        // when
        $newMoney = $money1->substract($money2);

        // then
        $this->assertEquals(Money::create("50.69", "USD"), $newMoney);
    }

    public function testMultiplyByAmount(): void
    {
        // given
        $money1 = Money::create("100.5", "USD");
        $money2 = Money::create("10.5", "USD");

        // when
        $newMoney = $money1->multiplyBy($money2);

        // then
        $this->assertEquals(Money::create("1055.25", "USD"), $newMoney);
    }

    public function testDivideByAmount(): void
    {
        // given
        $money1 = Money::create("1000.0", "USD");
        $money2 = Money::create("30.7", "USD");

        // when
        $newMoney = $money1->divideBy($money2);

        // then
        $this->assertEquals(Money::create("32.57", "USD"), $newMoney);
    }

    public function testDivideByZero(): void
    {
        // given
        $money1 = Money::create("1000.0", "USD");
        $money2 = Money::create("0", "USD");

        // when & then
        $this->expectException(DivisionByZeroError::class);
        $newMoney = $money1->divideBy($money2);
    }

     /**
     * @dataProvider moneyInvalidCurrencyCases
     */
    public function testInvalidCurrencyForCalculations($operation): void
    {
        $money1 = Money::create("100.0", "USD");
        $money2 = Money::create("50", "PLN");

        $this->expectException(InvalidCurrencyException::class);
        $newMoney = $money1->$operation($money2);
    }

    public function moneyInvalidCurrencyCases(): array
    {
        return [
            ["add"], ["substract"], ["multiplyBy"], ["divideBy"]
        ];
    }
}
