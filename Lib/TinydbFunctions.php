<?php
function __tinydbd($domain, $msg, $args = null) {
	if ($domain !== 'tinydb') {
		return __d($domain, $msg, $args);
	}
	$dbTypeInstance = \Edumap\Tinydb\Lib\CurrentDbType::instance();
	if ($dbTypeInstance === null) {
		return __d($domain, $msg, $args);
	}
	$dbType = $dbTypeInstance->getDbType();
	$domain = Inflector::underscore($dbType);

	App::uses('I18n', 'I18n');

	// dbtypeの言語で翻訳
	$translated = I18n::translate($msg, null, $domain);
	// 翻訳されてなければtinydbで翻訳される
	$translated = I18n::translate($translated, null, 'tinydb');
	// 引数差し込む
	$arguments = func_get_args();
	return I18n::insertArgs($translated, array_slice($arguments, 2));
}