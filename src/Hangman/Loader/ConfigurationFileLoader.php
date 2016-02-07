<?php

namespace Hangman\Loader;

abstract class ConfigurationFileLoader implements ConfigurationLoaderInterface
{
    public $maxAttempts;
    protected $file;

    /**
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
     * @return int
     */
    public function getMaxAttempts()
    {
        return $this->maxAttempts;
    }
}