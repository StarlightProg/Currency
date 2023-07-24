<?php

use App\Classes\Profile;

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>Приветствую, <?= $_SESSION["login"] ?></p>
	<a href="logout"><button>Выйти</button></a>
	<button onclick="convertCurrency()">Конвертировать</button>
	
	<p>Курс валют</p>
	<p>Последнее обновление <?= $vars['currencies'][0]['created_at'] ?></p>
	<table>
		<tr>
			<th>Цифр. код</th>
			<th>Букв. код</th>
			<th>Единиц</th>
			<th>Валюта</th>
			<th id="course-title">Курс</th>
		</tr>
		<?php foreach ($vars['currencies'] as $val): ?>
			<tr class="<?=$val["Value"]?>">
				<td><?=$val["NumCode"]?></td>
				<td><?=$val["CharCode"]?></td>
				<td class="td-nominal" data-value="<?=$val["Nominal"]?>"><?=$val["Nominal"]?></td>
				<td><?=$val["Name"]?></td>
				<td class="td-value" data-value="<?=$val["Nominal"]?>"><?=$val["Value"]?></td>
			</tr>
		<?php endforeach; ?>
	</table>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script>
		var currencyValue = document.getElementsByClassName("currency-value");
		
		function convertCurrency(){
			$( ".td-value" ).each(function( index ) {
				let nominal = Number($( this ).attr("data-value"));
				let course = Number( $( this ).text().replace(',', '.') );
				$( this ).text( String((nominal / course * nominal).toFixed(4)).replace('.', ','));
			});

			if ($("#course-title").text() === "Курс") {
				$("#course-title").text("Курс в рублях");
			} else {
				$("#course-title").text("Курс");
			}
		}
	</script>
</body>
</html>