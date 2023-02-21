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
	<a href="/profile?convert=true"><button>Конвертировать</button></a>
	
	<p>Курс валют</p>
	<?php
		var_dump(Profile::get_currencies());
	?>
</body>
</html>