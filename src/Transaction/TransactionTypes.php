<?php

namespace iconation\IconSDK\Transaction;

abstract class TransactionTypes{
    const LAST_BLOCK = 'icx_getLastBlock';
    const BLOCK_BY_HEIGHT = 'icx_getBlockByHeight';
    const BLOCK_BY_HASH = 'icx_getBlockByHash';
    const TRANSACTION_RESULT = 'icx_getTransactionResult';
    const TRANSACTION_BY_HASH = 'icx_getTransactionByHash';
    const TOTAL_SUPPLY = 'icx_getTotalSupply';
    const BALANCE = 'icx_getBalance';
    const SCORE_API = 'icx_getScoreApi';
    const SEND_TRANSACTION = 'icx_sendTransaction';
    const SEND_TRANSACTION_AND_WAIT = 'icx_sendTransactionAndWait';
    const WAIT_TRANSACTION_RESULT = 'icx_waitTransactionResult';
    const CALL = 'icx_call';
    const ESTIMATE_STEP = 'debug_estimateStep';
    const REP_LIST = 'rep_getList';
    const STATUS = 'ise_getStatus';

}