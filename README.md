<p align="center">
  <img 
    src="https://iconation.team/images/very_small.png" 
    width="120px"
    alt="ICONation logo">
</p>

<h1 align="center">ICON SDK for PHP</h1>

 [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
 
This is an SDK to communicate with the ICON blockchain, built for PHP.

Disclaimer: I cannot guarantee optimal performance of this software.
It is provided as is and without any assurances. Use it at your own risk.

Features
--------
Fully or partially supports all Iconservice functions, IRC-2 tokens and IISS calls.

Requirements & Installation
--------
Make sure you're using >=php7.2. Then check if you already have or install the required php extensions:

```shell script
apt install php-curl php-xml php-gmp php-bcmath
```

Require the package in the `composer.json` file in your project:
```shell script
composer require iconation/icon-sdk-php --no-dev
```
Testing
--------

```shell script
apt install php-mbstring
composer install
composer test
```

Usage
--------
#### Iconservice:
* icx_getLastBlock
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$res = $iconservice->getLastBlock();
```
* icx_getBlockByHeight
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$res = $iconservice->getBlockByHeight('0x2');
```
* icx_getBlockByHash
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$res = $iconservice->getBlockByHash('0x123986e1c834632f6e65915c249d81cd01453ec915e3370d364d6df7be5e6c03');
```
* icx_call
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$score = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";
$params = new stdClass();
$params->method = "balanceOf";
$params->params = new stdClass();
$params->params->_owner = "hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd";

$res = $iconservice->call($score, $params);
```
* icx_getBalance
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$res = $iconservice->getBalance('hx70e8eeb5d23ab18a828ec95f769db6d953e5f0fd');
```
* icx_getScoreApi
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$score = "cx9ab3078e72c8d9017194d17b34b1a47b661945ca";
$res = $iconservice->getBalance($score);
```
* icx_getTotalSupply
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$res = $iconservice->getTotalSupply();
```
* icx_getTransactionResult
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$txHash = '0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9';

$res = $iconservice->getTransactionResult($txHash);
```
* icx_getTransactionByHash
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$txHash = '0xb89690b7598e07c286db87f05c1ee4cfc1cf915bf061007ac3404a42dc4979e9';

$res = $iconservice->getTransactionByHash($txHash);
```
* icx_sendTransaction
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
$from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
$to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
$value = "0x2386f26fc10000"; // = 0.01 ICX

$res = $iconservice->send($from, $to, $value, $private_key);
```
* message
```php
use iconation\IconSDK\IconService\IconService;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');

$private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Sender's private key
$from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
$to = "hxf8689d6c4c8f333651469fdea2ac59a18f6c242d";
$message = "Your message goes here"; // = 0.01 ICX

$res = $iconservice->message($from, $to, $private_key, $message);
```
### IRC-2:
* name
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;

$contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$irc2 = new IRC2($contract, $iconservice);

$res = $irc2->name();
```
* symbol
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;

$contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$irc2 = new IRC2($contract, $iconservice);

$res = $irc2->symbol();
```
* decimals
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;

$contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$irc2 = new IRC2($contract, $iconservice);

$res = $irc2->decimals();
```
* totalSupply
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;

$contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$irc2 = new IRC2($contract, $iconservice);

$res = $irc2->totalSupply();
```
* balanceOf
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;

$contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$irc2 = new IRC2($contract, $iconservice);

$account = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160';

$res = $irc2->balanceOf($account);
```
* transfer
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IconService\IRC2;

$contract = 'cx8901ee4f6df58bd437de0e66c9dd3385ba4c2328';
$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$irc2 = new IRC2($contract, $iconservice);

$from = 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160';
$to = 'hxf8689d6c4c8f333651469fdea2ac59a18f6c242d';
$value = '1';
$privateKey = '3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5';

$res = $irc2->transfer($from, $to, $value, $privateKey);
```


### IISS:
* setStake
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\IISS;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$iiss = new IISS($iconservice);

$value = 0.5; //Stake 0.5 ICX
$from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";
$private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key

$res = $iiss->setStake($value, $from, $private_key);
```
* getStake
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\IISS;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$iiss = new IISS($iconservice);

$address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

$res = $iiss->getStake($address);
```
* setDelegation
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\IISS;
use iconation\IconSDK\IISS\Delegation;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$iiss = new IISS($iconservice);

$delegation1 = new Delegation("hxec79e9c1c882632688f8c8f9a07832bcabe8be8f", "0x2c68af0bb140000");
$delegation1 = $delegation1->getDelegationObject();

$delegation2 = new Delegation("hxd3be921dfe193cd49ed7494a53743044e3376cd3", "0x2c68af0bb140000");
$delegation2 = $delegation2->getDelegationObject();

$delegations = array(
                $delegation1, 
                $delegation2
               );
$private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
$from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

$res = $iiss->setDelegation($delegations, $from, $private_key);
```
* getDelegation
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\IISS;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$iiss = new IISS($iconservice);

$address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

$res = $iiss->getDelegation($address);
```
* claimIScore
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\IISS;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$iiss = new IISS($iconservice);

$private_key = "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5"; //Staker's private key
$from = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

$res = $iiss->claimIScore($from, $private_key);
```
* queryIScore
```php
use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\IISS\IISS;

$iconservice = new IconService('https://ctz.solidwallet.io/api/v3');
$iiss = new IISS($iconservice);

$address = "hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6160";

$res = $iiss->queryIScore($address);
```