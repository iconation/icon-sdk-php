<?php

use iconation\IconSDK\IconService\IconService;
use iconation\IconSDK\Tokens\IRC3;
use iconation\IconSDK\Wallet\Wallet;
use PHPUnit\Framework\TestCase;


class IRC3Test extends TestCase
{
    private string $contract;
    private IconService $iconService;
    private IRC3 $irc3;
    private Wallet $wallet;
    private Wallet $wallet2;
    private string $tokenId;

    public function __construct($name = 'IRC3Test')
    {
        parent::__construct($name);

        //MyIRC3Token (NFT)
        $this->contract = 'cxea4ae4f7a2c04a8864022792f01c03d92e115042';
        $this->iconService = new IconService('https://lisbon.net.solidwallet.io/api/v3');
        $this->irc3 = new IRC3($this->contract, $this->iconService);
        $this->wallet = new Wallet(privateKey: "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a5");
        $this->wallet2 = new Wallet(privateKey: "3468ea815d8896ef4552f10768caf2660689b965975c3ec2c1f5fe84bc3a77a1");
    }

    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object(new IRC3($this->contract, $this->iconService)));
    }

    public function testName()
    {
        $this->assertSame('MyIRC3Token', $this->irc3->name()->result);
    }

    public function testSymbol()
    {
        $this->assertSame('NFT', $this->irc3->symbol()->result);
    }

    public function testBalanceOf()
    {
        $this->assertTrue(!isset($this->irc3->balanceOf(
                owner: $this->wallet->getPublicAddress(),
            )->error));

        $this->assertTrue(!isset($this->irc3->balanceOf(
                owner: 'hx8dc6ae3d93e60a2dddf80bfc5fb1cd16a2bf6161',
            )->error));

        $this->assertFalse(!isset($this->irc3->balanceOf(
                owner: 'hx12345',
            )->error));
    }

    public function testOwnerOf()
    {
        $this->prepareToken();

        $this->assertTrue(!isset($this->irc3->ownerOf(
                tokenId: $this->tokenId,
            )->error));


        $this->assertFalse(!isset($this->irc3->ownerOf(
                tokenId: (string)rand(1001, 2000)
            )->error));
    }

    public function testGetApproved()
    {
        $this->prepareToken();

        sleep(5);

        $this->assertTrue(!isset($this->irc3->getApproved(
                tokenId: $this->tokenId,
            )->error));


        $nonExistingTokenResponse = $this->irc3->getApproved(
            tokenId: (string)rand(1001, 2000)
        );
        $this->assertTrue(!isset($nonExistingTokenResult->error));

        $this->assertEquals('hx0000000000000000000000000000000000000000', $nonExistingTokenResponse->result);
    }

    public function testTotalSupply()
    {
        $this->assertTrue(!isset($this->irc3->totalSupply()->error));
    }


    public function testTokenByIndex()
    {
        $this->prepareToken();
        sleep(5);

        $this->assertTrue(!isset($this->irc3->tokenByIndex(index: 0)->error));

        $this->cleanUp($this->wallet);
    }

    public function testTokenOfOwnerByIndex()
    {
        $this->prepareToken();
        sleep(5);

        $this->assertTrue(!isset($this->irc3->tokenOfOwnerByIndex(
                owner: $this->wallet->getPublicAddress(),
                index: 0
            )->error));

        $this->cleanUp($this->wallet);
    }


    public function testMint()
    {
        $this->_mint();

        $this->cleanUp($this->wallet);
    }

    private function _mint(): void
    {
        $tokenId = (string)rand(1, 1000);
        $this->assertTrue(!isset($this->irc3->mint(
                from: $this->wallet->getPublicAddress(),
                tokenId: $tokenId,
                wallet: $this->wallet,
                nid: '0x2',
            )->error));

        $this->tokenId = $tokenId; // Need this for testing
    }

    private function prepareToken(): void
    {
        if (!isset($this->tokenId)) {
            $this->_mint();
            sleep(5);
            $this->irc3 = new IRC3($this->contract, $this->iconService);
        }
    }

    public function testBurn()
    {
        $this->prepareToken();

        $this->assertTrue(!isset($this->irc3->burn(
                from: $this->wallet->getPublicAddress(),
                tokenId: $this->tokenId,
                wallet: $this->wallet,
                nid: '0x2',
            )->error));
    }

    public function testApprove()
    {
        $this->prepareToken();

        sleep(5);

        $this->assertTrue(!isset($this->irc3->approve(
                to: $this->wallet2->getPublicAddress(),
                tokenId: $this->tokenId,
                wallet: $this->wallet,
                nid: '0x2',
            )->error));
    }

    public function testTransfer()
    {
        $this->prepareToken();

        $this->assertTrue(!isset($this->irc3->transfer(
                to: $this->wallet2->getPublicAddress(),
                tokenId: $this->tokenId,
                wallet: $this->wallet,
                nid: '0x2',
            )->error));

        $this->cleanUp($this->wallet2);
    }

    public function testTransferFrom()
    {
        $this->testApprove();

        sleep(5);
        $this->assertTrue(!isset($this->irc3->transferFrom(
                from: $this->wallet->getPublicAddress(),
                to: $this->wallet2->getPublicAddress(),
                tokenId: $this->tokenId,
                wallet: $this->wallet2,
                nid: '0x2',
            )->error));

        $this->cleanUp($this->wallet);
        $this->cleanUp($this->wallet2);
    }

    private function cleanUp(Wallet $wallet): void
    {
        $numberOfTokens = hexdec($this->irc3->balanceOf(
            owner: $wallet->getPublicAddress(),
        )->result);

        for ($index = $numberOfTokens; $index > 0; $index--) {
            try {
                $tokenId = hexdec($this->irc3->tokenOfOwnerByIndex(
                    owner: $wallet->getPublicAddress(),
                    index: $index,
                )->result);
                $this->irc3->burn(
                    from: $wallet->getPublicAddress(),
                    tokenId: strval($tokenId),
                    wallet: $wallet,
                    nid: '0x2',
                );
            } catch (Exception $e) {
                $this->cleanUp($wallet);
                break;
            }
        }
    }
}