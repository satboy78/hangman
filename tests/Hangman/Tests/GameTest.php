<?php

namespace Hangman\Tests;

use Hangman\Game;
use Hangman\Word;

class GameTest extends \PHPUnit_Framework_TestCase
{
    public function testTryValidLetter()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $this->assertTrue($game->tryLetter('a'));
        $this->assertFalse($game->tryLetter('x'));
    }

    public function testTryUnauthorizedLetter()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $this->setExpectedException('\InvalidArgumentException');
        $this->assertFalse($game->tryLetter('3'));
    }

    public function testTryRightWord()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $this->assertInstanceOf('hangman\\Word', $game->getWord());
        $this->assertTrue($game->tryWord('filament'));
        $this->assertEquals(0, $game->getAttempts());
    }

    public function testTryWrongWord()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $this->assertFalse($game->tryWord('magnificent'));
        $this->assertEquals($game->getMaxAttempts(), $game->getAttempts());
    }

    public function testRepeatedLetter()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $game->tryLetter('u');
        $this->assertFalse($game->isHanged());

        $this->setExpectedException('\InvalidArgumentException');
        $game->tryLetter('u');
    }

    public function testIsLetterFound()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $this->assertFalse($game->isLetterFound('h'));

        $game->tryLetter('a');
        $this->assertTrue($game->isLetterFound('a'));
    }

    public function testGetRemainingAttempts()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $game->tryLetter('f');
        $this->assertEquals($game->getMaxAttempts(), $game->getRemainingAttempts());

        $game->tryLetter('o');
        $this->assertEquals($game->getMaxAttempts() - 1, $game->getRemainingAttempts());

        $game->tryWord('foo');
        $this->assertEquals(0, $game->getRemainingAttempts());
    }

    public function testIsWonWithWordTrial()
    {
        $game = new Game(new Word('filament'), 0, 5);
        $this->assertFalse($game->isWon());

        $game->tryWord('filament');
        $this->assertTrue($game->isWon());
    }

    public function testIsWonWithLettersTrial()
    {
        $game = new Game(new Word('filament'), 0, 5);
        $this->assertFalse($game->isWon());

        $game->tryLetter('f');
        $this->assertFalse($game->isWon());

        $game->tryLetter('i');
        $this->assertFalse($game->isWon());

        $game->tryLetter('l');
        $this->assertFalse($game->isWon());

        $game->tryLetter('a');
        $this->assertFalse($game->isWon());

        $game->tryLetter('m');
        $this->assertFalse($game->isWon());

        $game->tryLetter('e');
        $this->assertFalse($game->isWon());

        $game->tryLetter('n');
        $this->assertFalse($game->isWon());

        $game->tryLetter('t');
        $this->assertTrue($game->isWon());
    }

    public function testIsHangedWithWordTrial()
    {
        $game = new Game(new Word('filament'), 0, 5);
        $this->assertFalse($game->isHanged());

        $game->tryWord('foo');
        $this->assertTrue($game->isHanged());
    }

    public function testIsHangedWithLetterTrial()
    {
        $game = new Game(new Word('filament'), 0, 5);

        $game->tryLetter('g');
        $this->assertFalse($game->isHanged());

        $game->tryLetter('h');
        $this->assertFalse($game->isHanged());

        $game->tryLetter('j');
        $this->assertFalse($game->isHanged());

        $game->tryLetter('k');
        $this->assertFalse($game->isHanged());

        $game->tryLetter('y');
        $this->assertTrue($game->isHanged());
    }
}
