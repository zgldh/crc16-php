<?php

use Crc16\Crc16;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testIBM()
    {
        $rawString = '1234567890';
        $hashAnswer = 'c57a';
        $hashResult = dechex(Crc16::IBM($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testMAXIM()
    {
        $rawString = '1234567890';
        $hashAnswer = '3a85';
        $hashResult = dechex(Crc16::MAXIM($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testUSB()
    {
        $rawString = '1234567890';
        $hashAnswer = '3df5';
        $hashResult = dechex(Crc16::USB($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testMODBUS()
    {
        $rawString = '1234567890';
        $hashAnswer = 'c20a';
        $hashResult = dechex(Crc16::MODBUS($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testCCITT()
    {
        $rawString = '1234567890';
        $hashAnswer = '286b';
        $hashResult = dechex(Crc16::CCITT($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testCCITT_FALSE()
    {
        $rawString = '1234567890';
        $hashAnswer = '3218';
        $hashResult = dechex(Crc16::CCITT_FALSE($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testX25()
    {
        $rawString = '1234567890';
        $hashAnswer = '4b13';
        $hashResult = dechex(Crc16::X25($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testXMODEM()
    {
        $rawString = '1234567890';
        $hashAnswer = 'd321';
        $hashResult = dechex(Crc16::XMODEM($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }

    public function testDNP()
    {
        $rawString = '1234567890';
        $hashAnswer = 'bc1b';
        $hashResult = dechex(Crc16::DNP($rawString));
        $this->assertEquals($hashAnswer, $hashResult);
    }
}
