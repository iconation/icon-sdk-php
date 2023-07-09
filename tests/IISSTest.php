<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\Bond;
use iconation\IconSDK\IISS\Delegation;
use iconation\IconSDK\IISS\IISS;
use iconation\IconSDK\Wallet\Wallet;
use PHPUnit\Framework\TestCase;


class IISSTest extends TestCase
{
    private IconService $iconService;
    private IISS $iiss;
    private Wallet $wallet;

    public function __construct($name = 'IISSTest')
    {
        parent::__construct($name);

        //Lisbon
        $this->iconService = new IconService("https://lisbon.net.solidwallet.io/api/v3");
        $this->iiss = new IISS($this->iconService);
        $this->wallet = new Wallet(privateKey: "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5");
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object(new IISS( $this->iconService)));
    }

    public function test_setStake()
    {
        $value = 100; // ICX
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->setStake(
            value: $value,
            from: $this->wallet->getPublicAddress(),
            wallet: $this->wallet,
            nid: $nid
            )->error));
    }

    public function test_getStake()
    {
        $this->assertTrue(!isset($this->iiss->getStake(address: $this->wallet->getPublicAddress())->error));
    }

    public function test_setDelegation()
    {
        $delegation1 = new Delegation(address: "hxec79e9c1c882632688f8c8f9a07832bcabe8be8f", value: "0x2c68af0bb140000");
        $delegation1 = $delegation1->getDelegationObject();

        $delegation2 = new Delegation(address: "hxd3be921dfe193cd49ed7494a53743044e3376cd3", value: "0x2c68af0bb140000");
        $delegation2 = $delegation2->getDelegationObject();

        $delegations = array(
            $delegation1, $delegation2
        );

        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->setDelegation(
            delegations: $delegations,
            from: $this->wallet->getPublicAddress(),
            wallet: $this->wallet,
            nid: $nid
            )->error));
    }

    public function test_getDelegation()
    {
        $this->assertTrue(!isset($this->iiss->getDelegation(address: $this->wallet->getPublicAddress())->error));
    }

//    public function test_setBond()
//    {
//
//        $bond1 = new Bond("hxe45ef7de9eef0200a4090e57d6b92f40377eaea1", "0x2c68af0bb140000");
//        $bond1 = $bond1->getBondObject();
//
//        $bond2 = new Bond("hxe21a90699ce258a01b8b4b5b00984163bff7affc", "0x2c68af0bb140000");
//        $bond2 = $bond2->getBondObject();
//
//        $bonds = [$bond1, $bond2];
//
//        $nid = "0x2";  // Lisbon network
//
//        $this->assertTrue(!isset($this->iiss->setBond(
//                bonds: $bonds,
//                from: $this->wallet->getPublicAddress(),
//                wallet: $this->wallet,
//                nid: $nid
//            )->error));
//    }

    public function test_getBonderList()
    {
        $this->assertTrue(!isset($this->iiss->getBonderList(address: "hxe45ef7de9eef0200a4090e57d6b92f40377eaea1")->error));
    }

    public function test_getBond()
    {
        $this->assertTrue(!isset($this->iiss->getBond(address: $this->wallet->getPublicAddress())->error));
    }

    public function test_claimIScore()
    {

        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->claimIScore(
                from: $this->wallet->getPublicAddress(),
                wallet: $this->wallet,
                nid: $nid
            )->error));
    }

    public function test_queryIScore()
    {
        $this->assertTrue(!isset($this->iiss->queryIScore(address: $this->wallet->getPublicAddress())->error));
    }

//    public function test_registerPrep()
//    {
//        $this->assertTrue(!isset($this->iiss->registerPrep(
//            name: "ICONationTest",
//            email: "https://iconation.team",
//            country: "France",
//            city: "Paris",
//            website: "https://iconation.team",
//            details: "https://iconation.team",
//            p2pEndpoint: "http://127.0.0.1:9000",
//            from: $this->wallet->getPublicAddress(),
//            wallet: $this->wallet,
//            nodeAddress: null,
//            nid: "0x2",
//            )->error));
//    }
//
//    public function test_unregisterPrep()
//    {
//        $this->assertTrue(!isset($this->iiss->unregisterPrep(
//            from: $this->wallet->getPublicAddress(),
//            wallet: $this->wallet,
//            nid: "0x2"
//            )->error));
//    }
}