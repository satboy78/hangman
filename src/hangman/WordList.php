<?php

namespace Hangman;

use Hangman\Loader\GameLoaderInterface;

class WordList
{
    private $words;

    /**
     *
     */
    public function __construct()
    {
        $this->words = array();

    }

    /**
     * Gets a random word from the words array
     *
     * @param int $length
     *
     * @throws \InvalidArgumentException
     */
    public function getRandomWord($length)
    {
        // I want a word of the exact length passed to this method
        if (!is_int($length)) {
            throw new \InvalidArgumentException(sprintf('The length %s is not valid. Only integer values are accepted.', $length));
        }

        // I want a really random word, of random length
        if ($length === 0) {
            $length = $this->getRandomLength();
        }

        // I want a random word of the exact length passed to this method
        if (!array_key_exists($length, $this->words)) {
            throw new \InvalidArgumentException(sprintf('Sorry, There isn\'t any word of length %u.', $length));
        }

        $key = array_rand($this->words[$length]);

        return $this->words[$length][$key];
    }


    /**
     * Returns an allowed length for the words of the game
     *
     * @return int
     */
    private function getRandomLength() {
        return array_rand($this->words);
    }

    /**
     * Adds a word to the words array
     *
     * @param string $word
     */
    public function addWord($word)
    {
        $length = strlen($word);

        if (!isset($this->words[$length])) {
            $this->words[$length] = array();
        }

        if (!in_array($word, $this->words[$length])) {
            $this->words[$length][] = $word;
        }
    }

    /**
     * Loads a game
     *
     * @param GameLoaderInterface $loader
     */
    public function load(GameLoaderInterface $loader)
    {
        $loader->load();

        foreach ($loader->getWords() as $word) {
            $this->addWord($word);
        }
    }
}