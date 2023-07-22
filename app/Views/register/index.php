<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
		<?php if(!empty($_GET["error"])): ?> 
			<p style="display:inline-block;background-color:red;color:white">
				<?php
					//проверка ошибок 
					switch ($_GET["error"]) {
						case 'emptyinput':
							echo "Все поля должны быть заполнены!";
							break;

						case 'userexists':
							echo "Такой пользователь уже существует!";
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

		<form style="width: 300px;" action="register/add" method="POST">
			<div style="display: grid; grid-template-rows: 1fr; grid-row-gap: 5px;">
				<label>Логин</label>
				<input type="text" name="login" required>
				<label>Email</label>
				<input type="email" name="email">
				<label>Пароль</label>
				<input type="password" name="password" required>
				<input style="width: 150px;" type="submit" name="register_button" value="Зарегистрироваться">
			</div>
		</form>	

		<a href="/"><button style="width: 150px;">Логиниться</button></a>
</body>
</html>