# QR Code Generator

## Introduction

I QR Code sono dei tipi speciali di codici a barre che permettono di codificare varie informazioni (lettere, numeri e caratteri Kanji), in questo progetto ho implementato una guida teorica, implementeranno gli algoritmi descritti al fine di creare dei QR Code

Guida : [https://www.thonky.com/qr-code-tutorial/introduction](https://www.thonky.com/qr-code-tutorial/introduction)

## Todo

- Implement Kanji encode
- Implement all level size
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

`print` method return a html string where there's a table where each cell a attribute color

Reserved cell will bge used in future, for example for add image

Here the result

![Result](./doc/example.png)

You can alsa add a logo in center of QRCode using `addLogo($filepath)` on matrix object

```php
require_once('./lib/QRCode.php');

$errorCorrection = ErrorCorrection::$CORRECTION_M;

$matrix = QRCode::createPhoneNumber("createPhoneNumber", $errorCorrection);
$matrix->addLogo("doc/logo.png");

echo $matrix->print();
```

Here the result

![Result](./doc/example-logo.png)
