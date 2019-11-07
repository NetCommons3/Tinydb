<?php


namespace NetCommons\Tinydb\Lib;


class EventManager {

	/**
	 * @var callable[]
	 */
	private $callbacks;

	public static function instance() : self{
		static $instance;
		if ($instance === null) {
			$instance = new self();
		}
		return $instance;
	}

	public function attach($event, callable $callable) {
		$this->callbacks[$event][] = $callable;
	}

	public function dispatch(string $event, &...$args) {
		foreach ($this->callbacks[$event] ?? [] as $callback) {
			call_user_func_array($callback, $args);
		}

	}
	public function dispatchByArray(string $event, &$args) {
		foreach ($this->callbacks[$event] ?? [] as $callback) {
			call_user_func_array($callback, $args);
		}
	}

}