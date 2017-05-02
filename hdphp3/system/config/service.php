<?php
return [
	//服务提供者
	'providers' => [
		'system\service\HdForm\HdFormProvider'
	],

	//服务外观
	'facades'   => [
		'HdForm'     => 'system\service\HdForm\HdFormFacade',
	],
];