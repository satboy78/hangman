<?php

namespace Hangman\Storage;

interface StorageInterface
{
    /**
     * @param string $key
     * @return array
     */
    public function read($key);

    /**
     * @param string $key
     * @param string $value
     */
    public function write($key, $value);

    /**
     * @return string
     */
    public function getStorageName();
}