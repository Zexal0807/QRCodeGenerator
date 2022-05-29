# QR Code Generator

## Introduction

I QR Code sono dei tipi speciali di codici a barre che permettono di codificare varie informazioni (lettere, numeri e caratteri Kanji), in questo progetto ho implementato una guida teorica, implementeranno gli algoritmi descritti al fine di creare dei QR Code

Guida : [https://www.thonky.com/qr-code-tutorial/introduction](https://www.thonky.com/qr-code-tutorial/introduction)

## Todo

- Implement Kanji encode
- Implement save method

## How to use

Import `QRcode.php`

Use a method for generate a Matrix Object, on Matrix object you can use `print` method for generate a html table

### Available methods

```php
public static function createPhoneNumber($phone, ErrorCorrection $errorCorrection){}

public static function createSms($to, $message, ErrorCorrection $errorCorrection){}

public static function createEmail($to, $subject, $message, ErrorCorrection $errorCorrection){}

public static function createUrl($link, ErrorCorrection $errorCorrection){}

public static function createWifi($ssid, $cry, $password, ErrorCorrection $errorCorrection){}

public static function createPosition($lat, $lng, ErrorCorrection $errorCorrection){}

public static function createEvent($title, $location, $starttime, $endtime, ErrorCorrection $errorCorrection){}
```

## Example

```php
require_once('./lib/QRCode.php');

$errorCorrection = ErrorCorrection::$CORRECTION_M;

$matrix = QRCode::createPhoneNumber("createPhoneNumber", $errorCorrection);
echo $matrix->print();
```

`print($matrixSize = 500)` method return a html string where there's a table where each cell a attribute color
You can specify the matrix size in pixel, by default is 500 pixel

Here the result

![Result](./doc/example.png)

You can alsa add a logo in center of QRCode using `addLogo($filepath, $logoSize = 60)` on matrix object
You can specify the size, by default is 60% of the space

```php
require_once('./lib/QRCode.php');

$errorCorrection = ErrorCorrection::$CORRECTION_M;

$matrix = QRCode::createPhoneNumber("createPhoneNumber", $errorCorrection);
$matrix->addLogo("doc/logo.png");

echo $matrix->print();
```

Here the result

![Result](./doc/example-logo.png)
