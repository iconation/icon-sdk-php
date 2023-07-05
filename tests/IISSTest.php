<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\Bond;
use iconation\IconSDK\IISS\Delegation;
use iconation\IconSDK\IISS\IISS;
use PHPUnit\Framework\TestCase;


class IISSTest extends TestCase
{
    private $iconService;
    private $iiss;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        //Lisbon
        $this->iconService = new IconService("https://lisbon.net.solidwallet.io/api/v3");
        $this->iiss = new IISS($this->iconService);
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object(new IISS( $this->iconService)));
    }

    public function test_setStake()
    {
        $value = 10; //Stake 0.5 ICX
        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->setStake($value, $from, $private_key, $nid)->error));
    }

    public function test_getStake()
    {
        $address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

        $this->assertTrue(!isset($this->iiss->getStake($address)->error));
    }

    public function test_setDelegation()
    {
        $delegation1 = new Delegation("hxec79e9c1c882632688f8c8f9a07832bcabe8be8f", "0x2c68af0bb140000");
        $delegation1 = $delegation1->getDelegationObject();

        $delegation2 = new Delegation("hxd3be921dfe193cd49ed7494a53743044e3376cd3", "0x2c68af0bb140000");
        $delegation2 = $delegation2->getDelegationObject();

        $delegations = array(
            $delegation1, $delegation2
        );
        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->setDelegation($delegations, $from, $private_key, $nid)->error));
    }

    public function test_getDelegation()
    {
        $address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

        $this->assertTrue(!isset($this->iiss->getDelegation($address)->error));
    }

    public function test_setBond()
    {

        $bond1 = new Bond("hxe45ef7de9eef0200a4090e57d6b92f40377eaea1", "0x2c68af0bb140000");
        $bond1 = $bond1->getBondObject();

        $bond2 = new Bond("hxe21a90699ce258a01b8b4b5b00984163bff7affc", "0x2c68af0bb140000");
        $bond2 = $bond2->getBondObject();

        $bonds = [$bond1, $bond2];

        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->setBond($bonds, $from, $private_key, $nid)->error));
    }

    public function test_getBond()
    {
        $address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

        $this->assertTrue(!isset($this->iiss->getBond($address)->error));
    }

    public function test_claimIScore()
    {
        //TODO Check on production

        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $nid = "0x2";  // Lisbon network

        $this->assertTrue(!isset($this->iiss->claimIScore($from, $private_key, $nid)->error));
    }

    public function test_queryIScore()
    {
        $address = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160';

        $this->assertTrue(!isset($this->iiss->queryIScore($address)->error));
    }

    public function test_registerPrep()
    {
        $this->assertTrue(!isset($this->iiss->registerPrep(
            "ICONationTest",
            "https://iconation.team",
            "France",
            "Paris",
            "https://iconation.team",
            "https://iconation.team",
            "http://127.0.0.1:9000",
            "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160",
            "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5",
            null,
            "0x2",
            )->error));
    }

    public function test_unregisterPrep()
    {
        $this->assertTrue(!isset($this->iiss->unregisterPrep(
            "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160",
            "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5",
            "0x2"
            )->error));
    }
}