<?php

return [


	'env' 				=> getenv('APP_ENV'),
	'debug' 			=> getenv('APP_DEBUG') == 'true' ? true : false,
	'views_path'		=> '/views',
	'root_path'			=> __DIR__ . '/..',
	'template_engine'	=> 'php'


];