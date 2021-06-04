<?php


namespace fyreplace\util;


class Settings {

    private static array $settings;

    private static function getSettings(): array {
        if (!isset(self::$settings)) {
            self::$settings = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR .  "site_config.json"), true);
        }
        return self::$settings;
    }

    public static function getArray(string $key): array {
        return self::getSettings()[$key];
    }

    public static function get(string $key): string {
        return self::getSettings()[$key];
    }

}