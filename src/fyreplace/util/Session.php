<?php

namespace fyreplace\util;

use JetBrains\PhpStorm\Pure;

//TODO: Session expiration
class Session {

    private array $definitions = array();

    public function set(string $key, mixed $value): void {
        $this->definitions[] = $key;
        $_SESSION[$key] = $value;
    }

    #[Pure] public function hasKey(string $key): bool {
        return in_array($key, $this->definitions, true);
    }

    public function get(string $key): mixed {
        return $_SESSION[$key];
    }

    public static function getSession(): Session {
        if(!isset($_SESSION["self"])){
            self::startSession();
        }
        return $_SESSION["self"];
    }

    public function unset(string $key): void {
        unset($_SESSION[$key], $this->definitions[$key]);
    }

    private static function startSession(): void {
        session_start();
        if(!isset($_SESSION["self"])) {
            $_SESSION["self"] = new self();
        }
    }

    public function stopSession(): void {
        session_unset();
        session_destroy();
    }

    public function getOrRun(string $key, callable $onFail, mixed ...$args){
        if(!$this->hasKey($key)){
            if(is_null($args)){
                return $onFail();
            }
            return $onFail($args);
        }
        return $this->get($key);
    }

}