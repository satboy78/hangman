<?php

namespace Hangman\Storage;

class SessionStorage implements StorageInterface
{
    private $sessionName;

    /**
     * Constructor.
     *
     * @param string $sessionName
     */
    public function __construct($sessionName)
    {
        $this->sessionName = $sessionName;
        session_name($sessionName);
        session_start();
    }

    /**
     * @param string $key
     * @return array
     */
    public function read($key)
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : array();
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function write($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @return string
     */
    public function getStorageName()
    {
        return $this->sessionName;
    }
}
