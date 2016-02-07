<?php

namespace Hangman\Loader;

abstract class GameFileLoader implements GameLoaderInterface
{
    protected $words;
    protected $file;

    /**
     * Constructor
     *
     * @param string $file
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($file)
    {
        if (!file_exists($file) || !is_readable($file)) {
            throw new \InvalidArgumentException(sprintf('File "%s" does not exist or is not readable.', $file));
        }

        $this->file = $file;
    }

    /**
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }
}