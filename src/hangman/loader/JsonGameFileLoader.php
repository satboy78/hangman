<?php

namespace Hangman\Loader;

class JsonGameFileLoader extends GameFileLoader
{
    /**
     * Loads the words from json
     */
    public function load()
    {
        $json = json_decode(file_get_contents($this->file));
        foreach ($json->words as $word) {
            $this->words[] = (string) $word;
        }
    }
}