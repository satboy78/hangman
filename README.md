#Description
Build a simple HANGMAN game that works as follows:
* chooses a random word out of 6 words: (3dhubs, marvin, print, filament, order, layer).
* prints the spaces for the letters of the word (eg:     _ for order).
* the user can try to ask for a letter and that should be shown on the puzzle (eg: asks for "r" and now it shows  r  _ r for order).
* the user can only ask 5 letters that don't exist in the word and then it's game over.
* if the user wins, congratulate him.
* no need of a DB and no need to care about styling.

Extra points for automated tests!

#Installation
composer update

#Start tests
./bin/phpunit