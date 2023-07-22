<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>	
		<?php if(!empty($_GET["reg"])): ?>
			<p style="display:inline-block;background-color:green;color:white">
				<?php
					//если был создан новый пользователь
					if($_GET["reg"] == "success"){
						echo "Пользователь был создан!";
					}
					else{
						echo "Не удалось создать пользователя!";
					}
				?>
			</p>
		<?php endif; ?>

		<?php if(!empty($_GET["error"])): ?> 
			<p style="display:inline-block;background-color:red;color:white">
				<?php
					//проверка ошибок 
					switch ($_GET["error"]) {
						case 'emptyinput':
							echo "Все поля должны быть заполнены!";
							break;

						case 'wrongpassword':
							echo "Неверный пароль!";
							break;
						
						case 'wronglogin':
							echo "Неверный логин!";
							break;
						
						case 'connectionproblem':
							echo "Проблема с соединением!";
							break;

						default:
							echo "Какая-то ошибка!";
							break;
					}
				?>
			</p>
		<?php endif; ?>

		<form style="width: 300px;" action="login" method="POST">
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
		<a href="register"><button style="width: 150px;">Зарегистрироваться</button></a>
</body>
</html>