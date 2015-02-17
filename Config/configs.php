<?php

$config['App'] = [
	'additionalEncoding' => 1,
	'warnAboutNamedParams' => 1,
	'monitorHeaders' => true
];

$config['Search'] = [
	'Prg' => [
		'commonProcess' => ['filterEmpty' => true, 'paramType' => 'querystring'],
		'presetForm' =>['paramType' => 'querystring']
	],
	'Searchable' => [],
];

$config['Core'] = [
	'disableModelInstanceNotice' => true
];

$config['Paginator'] = [
	'paramType' => 'querystring'
];
