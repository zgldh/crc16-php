# crc16-php
crc16 hash methods for PHP

## Usage:
`composer require zgldh/crc16-php`

```
use Crc16\Crc16;

$rawData = '1234567890'; 
$result = Crc16::IBM($rawData);           // dechex($result) === 'c57a'
$result = Crc16::MAXIM($rawData);         // dechex($result) === '3a85'
$result = Crc16::USB($rawData);           // dechex($result) === '3df5'
$result = Crc16::MODBUS($rawData);        // dechex($result) === 'c20a'
$result = Crc16::CCITT($rawData);         // dechex($result) === '286b'
$result = Crc16::CCITT_FALSE($rawData);   // dechex($result) === '3218'
$result = Crc16::X25($rawData);           // dechex($result) === '4b13'
$result = Crc16::XMODEM($rawData);        // dechex($result) === 'd321'
$result = Crc16::DNP($rawData);           // dechex($result) === 'bc1b'
```

提示： `$rawData` 可以是任意二进制数据，**不要**预先转换成十六进制字符串。
`$result` 是原始整数结果，想得到16进制字符串结果请使用 `dechex` 函数进行转换。  
## Test
`composer run-script test`

## Thanks
Thanks for the algorithm author of https://blog.csdn.net/zhang197093/article/details/89061957
