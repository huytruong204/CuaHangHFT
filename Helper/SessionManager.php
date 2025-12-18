<?php
class SessionManager
{
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }
    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    public static function exists($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }
    public static function remove($key)
    {
        self::start();
        if (self::exists($key)) {
            unset($_SESSION[$key]);
        }
    }
    public static function destroy()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
    }
}
