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
        $this->contract = 'cx273548dff8bb77ffaac5a342c4c04aeae0bc48fa';
        $this->iconService = new IconService('https://lisbon.net.solidwallet.io/api/v3');
        $this->transactionBuilder = new TransactionBuilder($this->iconService);
        $this->irc2 = new IRC2($this->contract, $this->iconService);
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object(new IRC2($this->contract, $this->iconService)));
    }

    public function testName()
    {
        $this->assertSame('MyIRC2Token', $this->irc2->name()->result);
    }

    public function testSymbol()
    {
        $this->assertSame('MIT', $this->irc2->symbol()->result);
    }

    public function testDecimals()
    {
        $this->assertSame('0x12', $this->irc2->decimals()->result);
    }

    public function testTotalSupply()
    {
        $this->assertSame('0x3635c9adc5dea00000', $this->irc2->totalSupply()->result);
    }

    public function testBalanceOf()
    {
        $this->assertTrue(!isset($this->irc2->balanceOf('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160')->error));
    }

    public function testTransfer()
    {
        $this->assertTrue(!isset($this->irc2->transfer('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
                'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
                '13.8',
                '3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5',
                null,
                '0x2'
            )->error));
    }

    public function testTransferWithData()
    {
        $this->assertTrue(!isset($this->irc2->transfer('hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160',
                'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d',
                '1',
                '3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5',
                '0x186a00',
                '0x2',
                'test'
            )->error));
    }

}