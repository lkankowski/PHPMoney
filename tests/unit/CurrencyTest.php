<?php declare(strict_types = 1);

namespace Tests\Unit;

use Finance\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;


final class CurrencyTest extends TestCase
{
    public function testCreateValidCurrencyInstance(): void
    {
        $zloty = new Currency("PLN");
        $this->assertSame("PLN", $zloty->getStringValue());
        $dolar = new Currency("USD");
        $this->assertSame("USD", $dolar->getStringValue());
        $euro = new Currency("EUR");
        $this->assertSame("EUR", $euro->getStringValue());
    }

    public function testInvalidCreateCurrencyInstance(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $zloty = new Currency("ABC");
    }

    public function testCurrencyEquals(): void
    {
        $dolar1 = new Currency("USD");
        $dolar2 = new Currency("USD");
        $euro   = new Currency("EUR");

        $this->assertEquals($dolar1, $dolar2);
        $this->assertNotEquals($dolar1, $euro);
    }
}
