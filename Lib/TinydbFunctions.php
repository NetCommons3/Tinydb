<?php
/**
 * Tinydb用関数
 */

/**
 * __tinydbd __dの代わりに使う. 具象プラグインに同じメッセージの翻訳が定義されてたらそちらを使う。
 * なければ、Tinydbのメッセージを使う
 *
 * @param string $domain domain
 * @param string $msg message
 * @param mixed|null $args その他引数
 * @return string
 */
function __tinydbd($domain, $msg, $args = null) {
	if ($domain !== 'tinydb') {
		return __d($domain, $msg, $args);
	}
	$dbTypeInstance = \NetCommons\Tinydb\Lib\CurrentDbType::instance();
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
