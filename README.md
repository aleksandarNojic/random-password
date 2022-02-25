# random-password
Generate random password of a given length and strength

## Installation
This project is using composer.

> $ composer require nojic/random-password

#Usage
Generate random password which accepts two params
first is strength between 1-3
second is length at least 6
```
<?php

use Nojic\RandomPassword\RandomPassword;

$randomPassword = new RandomPassword(3, 10);
echo $randomPassword->generate();
```
