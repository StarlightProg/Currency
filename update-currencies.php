<?php

use App\Models\Currencies;

require_once 'vendor/autoload.php';

$currencyModel = new Currencies();

var_dump($currencyModel->parse_currencies());
