<?php

use PHPUnit\Framework\TestCase;


/**
 *  Corresponding Class to test Wallet class
 *
 *
 * @author Dimitris Frangiadakis
 */
class WalletTest extends TestCase
{
    public function test_privateKeyGeneration()
    {
        $var = new mitsosf\IconSDK\Wallet;

        $var->create();
        unset($var);
    }

    public function test_publicKeyGeneration(){
        $var = new mitsosf\IconSDK\Wallet;

        $privateKey = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5";
        $expectedAddress = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
        $test = $var->getPublicKey($privateKey);
        var_dump($test);
        //TODO Assert stuff

        unset($var);
    }
}