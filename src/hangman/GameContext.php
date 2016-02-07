<?php

namespace hangman;

use Hangman\Storage\StorageInterface;

class GameContext
{
    private $storage;

    /**
     * Constructor.
     *
     * @param StorageInterface $storage The chosen storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Resets the game
     */
    public function reset()
    {
        $this->storage->write($this->storage->getStorageName(), array());
    }

    /**
     * Load new game
     *
     * @param $maxAttempts
     * @param Word $word
     *
     * @return Game $game
     */
    public function newGame(Word $word, $maxAttempts)
    {
        return new Game($word, 0, $maxAttempts);
    }

    /**
     * Load game
     *
     * @param $maxAttempts
     *
     * @return Game $game
     */
    public function loadGame($maxAttempts)
    {
        $data = $this->storage->read($this->storage->getStorageName());

        if (!count($data)) {
            return false;
        }

        $word = new Word(
            $data['word'],
            $data['found_letters'],
            $data['tried_letters']
        );

        return new Game($word, $data['attempts'], $maxAttempts);
    }

    /**
     * Save the current game
     *
     * @param Game $game
     */
    public function save(Game $game)
    {
        $data = $game->getContext();

        $this->storage->write($this->storage->getStorageName(), $data);
    }
}
