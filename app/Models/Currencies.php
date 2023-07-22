<?php

namespace App\Models;

use PDO;
use App\Core\Model;

class Currencies extends Model{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'currencies';
    }

    public function add_currencies(){
        $currencyRates = $this->parse_currencies();

        if(is_null($currencyRates)){
            return;
        }

        $values = [];

        foreach ($currencyRates as $key => $val){
            $values[] = '(' . $key . ",'" . $val["CharCode"] . "'," . $val["Nominal"] . ",'" . $val["Name"] . "','" . $val["Value"] . "', NOW())";
        }
        
        $values_str = implode(",", $values);
        
        $this->query("TRUNCATE TABLE currencies");
        $this->query("INSERT INTO `{$this->table}` (`NumCode`, `CharCode`, `Nominal`, `Name`, `Value`, `created_at`) VALUES {$values_str}");
    }

    public function get_currencies(){
        return $this->row("SELECT * FROM `{$this->table}`"); 
    }

    public function parse_currencies(){
        $url = 'https://www.cbr.ru/scripts/XML_daily.asp';
		
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        curl_close($curl);

        if ($response !== false) {
            $xml = simplexml_load_string($response);

            $currencies = [];

            foreach ($xml->Valute as $value) {
                $currencies[(string) $value->NumCode] = [
                    "CharCode" => (string) $value->CharCode,
                    "Nominal" => (string) $value->Nominal,
                    "Name" => (string) $value->Name,
                    "Value" => (string) $value->Value,
                ];
            }

            return $currencies;
        }

        return null;
    }
}