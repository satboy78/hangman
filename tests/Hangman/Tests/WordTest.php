<?php

namespace Hangman\Tests;

use Hangman\Word;

class WordTest extends \PHPUnit_Framework_TestCase
{
    public function testGetWord()
    {
        $word = new Word('order');
        $this->assertEquals(array('o', 'r', 'd', 'e'), $word->getLetters());
        $this->assertEquals('order', (string) $word);
        $this->assertEquals('order', $word->getWord());
    }

    public function testIsGuessed()
    {
        $word = new Word('order');
        $word->tryLetter('o');
        $this->assertFalse($word->isGuessed());
        $word->tryLetter('r');
        $this->assertFalse($word->isGuessed());
        $word->tryLetter('d');
        $this->assertFalse($word->isGuessed());
        $word->tryLetter('e');
        $this->assertTrue($word->isGuessed());
    }

    public function testTryLetterWithTriedLetter()
    {
        $word = new Word('order');
        $this->assertFalse($word->tryLetter('a'));
        $this->setExpectedException('\InvalidArgumentException');
        $word->tryLetter('a');
    }

    public function testTryLetterWithUnauthorizedLetter()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $word = new Word('order');
        $word->tryLetter('7');
    }

    public function testTryLetter()
    {
        $word = new Word('order');
        $this->assertTrue($word->tryLetter('d'));
        $this->assertEquals(array('d'), $word->getFoundLetters());
    }

    public function testGuessed()
    {
        $word = new Word('fillament');
        $this->assertFalse($word->isGuessed());
        $word->guessed();
        $this->assertTrue($word->isGuessed());
    }
}
