<?php

return [

	'' => [
		'controller' => 'login',
		'action' => 'index',
	],

	'login' => [
		'controller' => 'login',
		'action' => 'login',
	],

	'register' => [
		'controller' => 'register',
		'action' => 'index',
	],

	'register/add' => [
		'controller' => 'register',
		'action' => 'register',
	],

	'profile/{id:\d+}' => [
		'controller' => 'profile',
		'action' => 'index',
	],

	'profile/logout' => [
		'controller' => 'profile',
		'action' => 'logout',
	],
	
];