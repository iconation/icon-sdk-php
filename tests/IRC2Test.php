<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;
use iconation\IconSDK\Transaction\TransactionBuilder;
use PHPUnit\Framework\TestCase;


class IRC2Test extends TestCase
{
    private $contract;
    private $transactionBuilder;
    private $iconService;
    private $irc2;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        //IWinToken (IWIN)
        $this->contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
        $this->iconService = new IconService('https://bicon.net.solidwallet.io/api/v3');
        $this->transactionBuilder = new TransactionBuilder($this->iconService);
        $this->irc2 = new IRC2($this->contract, $this->iconService);
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object(new IRC2($this->contract, $this->iconService)));
    }

    public function testName()
    {
        $this->assertSame('IWinToken', $this->irc2->name());
    }

    public function testSymbol()
    {
        $this->assertSame('IWIN', $this->irc2->symbol());
    }

    public function testDecimals()
    {
        $this->assertSame('0x12', $this->irc2->decimals());
    }

    public function testTotalSupply()
    {
        $this->assertSame('0x1431e0fae6d7217caa0000000', $this->irc2->totalSupply());
    }

    public function testBalanceOf()
    {
        $this->assertTrue(!isset($this->irc2->balanceOf('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160')->error));
        //$this->assertSame('0x43c33c1937564800000', $this->irc2->balanceOf('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160'));
    }

    public function testTransfer()
    {
        $this->assertTrue(!isset($this->irc2->transfer('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
                'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
                '1',
                '3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5',
                '0x186a00',
                '0x3'
            )->error));
    }

    public function testTransferWithData()
    {
        $this->assertTrue(!isset($this->irc2->transfer('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
                'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
                '1',
                '3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5',
                '0x186a00',
                '0x3',
                'test'
            )->error));
    }

}