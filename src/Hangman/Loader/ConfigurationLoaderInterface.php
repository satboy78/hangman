<?php

namespace Hangman\Loader;

interface ConfigurationLoaderInterface
{
    /**
     * Loads configuration parameters.
     *
     * @return void
     */
    public function load();

    /**
     * Returns max number of attempts.
     *
     * @return integer
     */
    public function getMaxAttempts();
}