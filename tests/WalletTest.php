<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase {

    private Wallet $wallet;

    public function setUp(): void {
        $this->wallet = new Wallet('USD');
    }
    
    public function testAddFund() {
        $this->wallet->addFund(5.0);
        $this->assertEquals(5.0, $this->wallet->getBalance());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        
        $this->wallet->addFund(-15.0);
    }

    public function testRemoveFund() {
        $this->wallet->setBalance(50.0);

        $this->wallet->removeFund(10.0);
        $this->assertEquals(40.0, $this->wallet->getBalance());

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid amount');
        
        $this->wallet->addFund(-15.0);

        $this->expectExceptionMessage('Insufficient funds');

        $this->wallet->addFund(100);
    }
}

