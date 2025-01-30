<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase {

    private Person $person1;

    private Person $person2;

    public function setUp(): void {
        $this->person1 = new Person("Liam","USD");
        $this->person1->getWallet()->setBalance(10);
        $this->person2 = new Person("maiL","USD");
        $this->person2->getWallet()->setBalance(5);
    }
    
    public function testHasFund() {
        $result = $this->person1->hasFund();
        $this->assertTrue($result);
        $this->assertIsBool($result);
    }

    
    public function testTransfertFund(): void
    {
        $this->person1->transfertFund(3, $this->person2); 
        $this->assertEquals(7,$this->person1->getWallet()->getBalance());
        $this->assertEquals(8,$this->person2->getWallet()->getBalance());


    }

    public function testdivideWallet(): void
    {
        $pers = new Person('amLi','USD');
        $this->person1->divideWallet([$this->person2, $pers]); 
        $this->assertEquals(0, $this->person1->getWallet()->getBalance());
        $this->assertEquals(5, $pers->getWallet()->getBalance());
        $this->assertEquals(10, $this->person2->getWallet()->getBalance());
    }

    public function testBuyProduct(): void
    {
        $product = new Product('Saucisse', ['USD' => 5],'food');
        $this->person1->buyProduct($product);
        $this->assertEquals(5, $this->person1->getWallet()->getBalance());

        $product2 = new Product('Pizza', ['EUR' => 5],'food');
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Can\'t buy product with this wallet currency');
        
        $this->person1->buyProduct($product2);
    }
}

