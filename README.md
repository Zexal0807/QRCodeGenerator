# QR Code Generator

## Introduction

I QR Code sono dei tipi speciali di codici a barre che permettono di codificare varie informazioni (lettere, numeri e caratteri Kanji), in questo progetto ho implementato una guida teorica, implementeranno gli algoritmi descritti al fine di creare dei QR Code

Guida : [https://www.thonky.com/qr-code-tutorial/introduction](https://www.thonky.com/qr-code-tutorial/introduction)

## Todo

- Implement Kanji encode
- Create specific method for different content type
- Implement logo
- Implement all level size

## How to use

```php
require_once('./lib/QRCode.php');

$data = "tel:3333333333";
$errorCorrection = ErrorCorrection::$CORRECTION_M;

$matrix = QRCode::create($data, $errorCorrection);

echo $matrix->print();

```

`print` method return a html string where there's a table where each cell a attribute color

So add style for see QRCode

```css
td[color="BLACK"] {
  color: white;
  background-color: black;
}

td[color="WHITE"] {
  background-color: white;
}

td[color="RESERVED"] {
  background-color: blue;
}

td {
  border-collapse: collapse;
}

table {
  width: 500;
  height: 500;
  margin: 15px;
  border-collapse: collapse;
}
```

Reserved cell will bge used in future, for example for add image

Here the result

![Result](./doc/example.png)
