<?php


namespace Crc16;


class Crc16
{
    /**
     * CRC-16/IBM
     * @param $str
     * @return mixed
     */
    public static function IBM($str)
    {
        return self::hash($str, 0x8005, 0, 0, true, true);
    }

    /**
     * CRC-16/MAXIM
     * @param $str
     * @return mixed
     */
    public static function MAXIM($str)
    {
        return self::hash($str, 0x8005, 0, 0xffff, true, true);
    }

    /**
     * CRC-16/USB
     * @param $str
     * @return mixed
     */
    public static function USB($str)
    {
        return self::hash($str, 0x8005, 0xffff, 0xffff, true, true);
    }

    /**
     * CRC-16/MODBUS
     * @param $str
     * @return mixed
     */
    public static function MODBUS($str)
    {
        return self::hash($str, 0x8005, 0xffff, 0, true, true);
    }

    /**
     * CRC-16/CCITT
     * @param $str
     * @return mixed
     */
    public static function CCITT($str)
    {
        return self::hash($str, 0x1021, 0, 0, true, true);
    }

    /**
     * CRC-16/CCITT-FALSE
     * @param $str
     * @return mixed
     */
    public static function CCITT_FALSE($str)
    {
        return self::hash($str, 0x1021, 0xffff, 0, false, false);
    }

    /**
     * CRC-16/X25
     * @param $str
     * @return mixed
     */
    public static function X25($str)
    {
        return self::hash($str, 0x1021, 0xffff, 0xffff, true, true);
    }

    /**
     * CRC-16/XMODEM
     * @param $str
     * @return mixed
     */
    public static function XMODEM($str)
    {
        return self::hash($str, 0x1021, 0, 0, false, false);
    }

    /**
     * CRC-16/DNP
     * @param $str
     * @return mixed
     */
    public static function DNP($str)
    {
        return self::hash($str, 0x3d65, 0, 0xffff, true, true);
    }

    /**
     * 将一个字符按比特位进行反转 eg: 65 (01000001) --> 130(10000010)
     * @param $char
     * @return string $char
     */
    private static function reverseChar($char)
    {
        $byte = ord($char);
        $tmp = 0;
        for ($i = 0; $i < 8; ++$i) {
            if ($byte & (1 << $i)) {
                $tmp |= (1 << (7 - $i));
            }
        }
        return chr($tmp);
    }

    /**
     * 将一个字节流按比特位反转 eg: 'AB'(01000001 01000010)  --> '\x42\x82'(01000010 10000010)
     * @param $str
     * @return mixed
     */
    private static function reverseString($str)
    {
        $m = 0;
        $n = strlen($str) - 1;
        while ($m <= $n) {
            if ($m == $n) {
                $str{$m} = self::reverseChar($str{$m});
                break;
            }
            $ord1 = self::reverseChar($str{$m});
            $ord2 = self::reverseChar($str{$n});
            $str{$m} = $ord2;
            $str{$n} = $ord1;
            $m++;
            $n--;
        }
        return $str;
    }

    /**
     * @param string $str         待校验字符串
     * @param int $polynomial     二项式
     * @param int $initValue      初始值
     * @param int $xOrValue       输出结果前异或的值
     * @param bool $inputReverse  输入字符串是否每个字节按比特位反转
     * @param bool $outputReverse 输出是否整体按比特位反转
     * @return int
     */
    public static function hash($str, $polynomial, $initValue, $xOrValue, $inputReverse = false, $outputReverse = false)
    {
        $crc = $initValue;

        for ($i = 0; $i < strlen($str); $i++) {
            if ($inputReverse) {
                // 输入数据每个字节按比特位逆转
                $c = ord(self::reverseChar($str{$i}));
            } else {
                $c = ord($str{$i});
            }
            $crc ^= ($c << 8);
            for ($j = 0; $j < 8; ++$j) {
                if ($crc & 0x8000) {
                    $crc = (($crc << 1) & 0xffff) ^ $polynomial;
                } else {
                    $crc = ($crc << 1) & 0xffff;
                }
            }
        }
        if ($outputReverse) {
            // 把低地址存低位，即采用小端法将整数转换为字符串
            $ret = pack('cc', $crc & 0xff, ($crc >> 8) & 0xff);
            // 输出结果按比特位逆转整个字符串
            $ret = self::reverseString($ret);
            // 再把结果按小端法重新转换成整数
            $arr = unpack('vshort', $ret);
            $crc = $arr['short'];
        }
        return $crc ^ $xOrValue;
    }
}