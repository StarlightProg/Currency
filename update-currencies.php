<?php

use App\Models\Currencies;

require_once 'vendor/autoload.php';

$currencyModel = new Currencies();

$currencyModel->add_currencies();
