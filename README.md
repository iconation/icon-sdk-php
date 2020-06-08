<p align="center">
  <img 
    src="https://iconation.team/images/very_small.png" 
    width="120px"
    alt="ICONation logo">
</p>

<h1 align="center">ICON SDK for PHP (Unofficial)</h1>

 [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
 
This is an unofficial SDK to communicate with the ICON JSON-RPC server, built for PHP.

Disclaimer: I cannot guarantee optimal performance of this software.
It is provided as is and without any assurances. Use it at your own risk.

Features
--------
Already fully or partially supports the following JSON-RPC functions:

* icx_getLastBlock
* icx_getBlockByHeight
* icx_getBlockByHash
* icx_call
* icx_getBalance
* icx_getScoreApi
* icx_getTotalSupply
* icx_getTransactionResult
* icx_getTransactionByHash
* ise_getStatus
* icx_sendTransaction

There is also some wallet support, see Wallet.php file for more info.
More detailed documentation coming soon.


TODO
--------


* Usage:..
* More tests, especially on the wallet part
* Debug and p-rep functions seem not to be working on ICON's part atm. 
Will promptly update when they become available.
* Refactoring
