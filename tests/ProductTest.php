<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase {

    private Product $product;

    private Product $product2;


    public function setUp(): void {
        $this->product = new Product('Saucisse', ['USD' => 5, 'EUR' => 4],'food');
        $this->product2 = new Product('écouteurs', ['EUR'=> 2],'tech');
    }
    
    public function testTVA() {
        $this->assertEquals(0.1, $this->product->getTVA());

        $this->assertEquals(0.2, $this->product2->getTVA());
        
        $this->assertIsFloat($this->product->getTVA());
        
    }

    
    public function testListCurrencies(): void
    {
        $this->assertEquals(['USD', 'EUR'], $this->product->listCurrencies());
    }

    public function testGetPrice(): void
    {
        $this->assertEquals(5, $this->product->getPrice('USD'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid currency');
        $this->product->getPrice('EUROS');

        $this->expectExceptionMessage('Invalid currency');
        $this->product2->getPrice('USD');
    }
}

