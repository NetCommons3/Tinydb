<?php
/**
 * Tinydb EventManager
 */

namespace NetCommons\Tinydb\Lib;


/**
 * Class EventManager
 *
 * @package NetCommons\Tinydb\Lib
 */
class EventManager {

/**
 * @var callable[] コールバックリスト
 */
	private $__callbacks;

/**
 * instance
 *
 * @return EventManager
 */
	public static function instance() {
		static $instance;
		if ($instance === null) {
			$instance = new self();
		}
		return $instance;
	}

/**
 * attach
 *
 * @param string $event event name
 * @param callable $callable コールバック
 * @return void
 */
	public function attach($event, callable $callable) {
		$this->__callbacks[$event][] = $callable;
	}

/**
 * dispatch
 *
 * @param string $event event name
 * @param mixed &$args 引数
 * @return void
 */
	public function dispatch(string $event, &...$args) {
		foreach ($this->__callbacks[$event] ?? [] as $callback) {
			call_user_func_array($callback, $args);
		}
	}

/**
 * dispatchByArray
 *
 * @param string $event event name
 * @param mixed &$args 引数
 * @return void
 */
	public function dispatchByArray(string $event, &$args) {
		foreach ($this->__callbacks[$event] ?? [] as $callback) {
			call_user_func_array($callback, $args);
		}
	}

}