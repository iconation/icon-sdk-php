<?php

use PHPUnit\Framework\TestCase;


class IISSTest extends TestCase
{
    //Mainnet
    private $icon_service_URL_main = 'https://ctz.solidwallet.io/api/v3';
    //Yeouido
    private $icon_service_URL_yeouido = "https://bicon.net.solidwallet.io/api/v3";

    public function test_setStake()
    {
        $var = new iconation\IconSDK\IISS($this->icon_service_URL_yeouido);

        $value = 0.5; //Stake 0.5 ICX
        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $stepLimit = "0x1b580"; //112000 steps
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($var->setStake($value, $from, $stepLimit, $private_key, $nid)->error));

        unset($var);
    }

    public function test_getStake()
    {
        $var = new iconation\IconSDK\IISS($this->icon_service_URL_yeouido);

        $address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

        $this->assertTrue(!isset($var->getStake($address)->error));

        unset($var);
    }

    public function test_setDelegation()
    {
        $var = new iconation\IconSDK\IISS($this->icon_service_URL_yeouido);

        $delegation1 = new stdClass();
        $delegation1->address = "hxec79e9c1c882632688f8c8f9a07832bcabe8be8f";
        $delegation1->value = "0x2c68af0bb140000";

        $delegation2 = new stdClass();
        $delegation2->address = "hxd3be921dfe193cd49ed7494a53743044e3376cd3";
        $delegation2->value = "0x2c68af0bb140000";

        $delegations = array(
            'delegations' => array(
                $delegation1, $delegation2
            )
        );
        $private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
        $from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $stepLimit = "0x7e3a85"; //
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($var->setDelegation($delegations, $from, $stepLimit, $private_key, $nid)->error));

        unset($var);
    }

    public function test_getDelegation()
    {
        $var = new iconation\IconSDK\IISS($this->icon_service_URL_yeouido);

        $address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $nid = "0x3";  // YEOUIDO network

        $this->assertTrue(!isset($var->getDelegation($address)->error));

        unset($var);
    }
}