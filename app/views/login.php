<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>	
		<?php if(!empty($_GET["reg"])): ?>
			<p style="display:inline-block;background-color:green;color:white">
				<?php
					if($_GET["reg"] == "success"){
						echo "Пользователь был создан!";
					}
					else{
						echo "Не удалось создать пользователя!";
					}
				?>
			</p>
		<?php endif; ?>

		<form style="width: 300px;" action="" method="POST">
			<div style="display: grid; grid-template-rows: 1fr; grid-row-gap: 10px;">
				<label>Логин</label>
				<input type="text" name="login" required>
				<label>Пароль</label>
				<input type="password" name="password" required>
				<input style="width: 150px;" type="submit" name="login_button" value="Войти">				
			</div>
			
		</form>

		<br>
		<br>
		<a href="registration"><button style="width: 150px;">Зарегистрироваться?</button></a>
</body>
</html>