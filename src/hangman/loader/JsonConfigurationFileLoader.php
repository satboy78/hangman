<?php

namespace Hangman\Loader;

class JsonConfigurationFileLoader extends ConfigurationFileLoader
{
    /**
     * Loads configuration parameters from json
     */
    public function load()
    {
        $json = json_decode(file_get_contents($this->file));
        $this->maxAttempts = $json->maxAttempts;
    }
}