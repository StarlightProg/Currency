<?php

use App\Classes\Profile;

    session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>Приветствую, <?= $_SESSION["login"] ?></p>
	<a href="logout"><button>Выйти</button></a>
	<a href="/profile?convert=true"><button>Конвертировать</button></a>

	<?php 
		var_dump($vars['currencies']);
	?>
	
	<p>Курс валют</p>
	<?php
		function getCurrencyRate()
		{
			$url = 'https://www.cbr.ru/scripts/XML_daily.asp';
		
			// Инициализируем cURL-сессию
			$curl = curl_init($url);
		
			// Устанавливаем опции для cURL-сессии
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
			// Выполняем запрос
			$response = curl_exec($curl);
		
			// Закрываем cURL-сессию
			curl_close($curl);
		
			// Проверяем, удалось ли выполнить запрос
			if ($response !== false) {
				// Используем библиотеку SimpleXML для разбора XML-данных
				$xml = simplexml_load_string($response);

				$currencies = [];

				//var_dump($xml);

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
		
		// Пример использования функции для получения текущего курса валют
		$currencyRates = getCurrencyRate();
		// if ($currencyRates !== null) {
		// 	echo "Курс доллара: " . $currencyRates['usd'] . "\n";
		// 	echo "Курс евро: " . $currencyRates['euro'] . "\n";
		// } else {
		// 	echo "Не удалось получить данные о курсах валют\n";
		// }
	?>
	<table>
		<?php foreach ($currencyRates as $key => $val): ?>
			<tr>
				<td><?=$key?></td>
				<td><?=$val["CharCode"]?></td>
				<td><?=$val["Nominal"]?></td>
				<td><?=$val["Name"]?></td>
				<td><?=$val["Value"]?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>