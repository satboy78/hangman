<?php

namespace Hangman;

class Word 
{
    private $word;
    private $foundLetters;
    private $triedLetters;

    /**
     * Constructor
     *
     * @param string $word
     * @param array $foundLetters
     * @param array $triedLetters
     */
    public function __construct($word, array $foundLetters = array(), array $triedLetters = array())
    {
        $this->word = $word;
        $this->foundLetters = $foundLetters;
        $this->triedLetters = $triedLetters;
    }

    /**
     * Returns the word
     *
     * @return string
     */
    public function __toString()
    {
        return $this->word;
    }

    public function guessed()
    {
        $this->foundLetters = $this->getLetters();
    }

    public function getFoundLetters()
    {
        return $this->foundLetters;
    }

    public function getTriedLetters()
    {
        return $this->triedLetters;
    }

    /**
     * @return array
     */
    public function getLetters()
    {
        return array_unique(str_split($this->word));
    }

    /**
     * Returns if the word has been guessed or not.
     *
     * @return Boolean
     */
    public function isGuessed()
    {
        $diff = array_diff($this->getLetters(), $this->foundLetters);

        return 0 === count($diff);
    }

    /**
     * Tries to guess a letter.
     *
     * @param string $letter
     *
     * @return Boolean
     *
     * @throws \InvalidArgumentException
     */
    public function tryLetter($letter)
    {
        if (true !== ctype_alpha($letter)) {
            throw new \InvalidArgumentException(sprintf('The char "%s" is not a valid letter.', $letter));
        }

        $letter = strtolower($letter);

        if (in_array($letter, $this->triedLetters, true)) {
            throw new \InvalidArgumentException(sprintf('The letter "%s" has already been tried.', $letter));
        }

        $this->triedLetters[] = $letter;

        if (false !== strpos($this->word, $letter)) {
            $this->foundLetters[] = $letter;

            return true;
        }

        return false;
    }

    /**
     * Returns the word to guess.
     *
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }
}