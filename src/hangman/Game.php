<?php

namespace Hangman;

class Game 
{
    private $maxAttempts;
    private $word;
    private $attempts;

    /**
     * Constructor
     *
     * @param Word $word
     * @param int $attempts
     * @param int $maxAttempts
     */
    public function __construct(Word $word, $attempts = 0, $maxAttempts)
    {
        $this->word = $word;
        $this->maxAttempts = $maxAttempts;
        $this->attempts = (int) $attempts;
    }

    /**
     * Gets the context of the current game
     *
     * @return array
     */
    public function getContext()
    {
        return array(
            'word'          => (string) $this->word,
            'attempts'      => $this->attempts,
            'found_letters' => $this->word->getFoundLetters(),
            'tried_letters' => $this->word->getTriedLetters()
        );
    }

    /**
     * @return int $remainingAttempts
     */
    public function getRemainingAttempts()
    {
        return $this->maxAttempts - $this->attempts;
    }

    /**
     * @param string $letter
     * @return bool
     */
    public function isLetterFound($letter)
    {
        return in_array($letter, $this->word->getFoundLetters(), true);
    }

    /**
     * @return bool
     */
    public function isHanged()
    {
        return $this->maxAttempts === $this->attempts;
    }

    /**
     * @return bool
     */
    public function isWon()
    {
        return $this->word->isGuessed();
    }

    /**
     * @return Word
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @return int
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param string $word
     * @return bool
     */
    public function tryWord($word)
    {
        if ($word === $this->word->getWord()) {
            $this->word->guessed();

            return true;
        }

        $this->attempts = $this->maxAttempts;

        return false;
    }

    /**
     * @param string $letter
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function tryLetter($letter)
    {
        $result = $this->word->tryLetter($letter);

        if (false === $result) {
            $this->attempts++;
        }

        return $result;
    }
}