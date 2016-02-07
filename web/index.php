<?php

require __DIR__.'/../vendor/autoload.php';

use Hangman\Word;
use Hangman\WordList;
use Hangman\GameContext;
use Hangman\Loader\JsonGameFileLoader;
use Hangman\Loader\JsonConfigurationFileLoader;
use Hangman\Storage\SessionStorage;

$charsMap = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
    'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
    'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
);

// load the list of the words used in the game
$list = new WordList();
$list->load(new JsonGameFileLoader(__DIR__.'/../data/words.json'));

// load configuration parameters
$configuration = new JsonConfigurationFileLoader(__DIR__.'/../data/configuration.json');
$configuration->load();
$maxAttempts  =$configuration->maxAttempts;

$context = new GameContext(new SessionStorage('play_hangman'));

// Wanna play again / reset current game?
if (array_key_exists('new', $_GET) && strcmp($_GET['new'], 'true') === 0) {
    $context->reset();
}

// Restores the last unfinished game
// getRandomWord() accepts an int as a parameter; 0 for a random length
if (!$game = $context->loadGame($maxAttempts)) {
    $game = $context->newGame(new Word($list->getRandomWord(0)), $maxAttempts);
}

// Checks if the letter / word chosen by the user is valid
if (!empty($_GET['letter'])) {
    try {
        $game->tryLetter($_GET['letter']);
    } catch (Exception $e) {
        $msg = $e->getMessage();
    }
} elseif (!empty($_POST['word'])) {
    $game->tryWord($_POST['word']);
}

// Save current game in the storage
$context->save($game);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/starter-template.css" rel="stylesheet">
        <title>Hangman - The Game!</title>
    </head>
    <body>
        <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
            <a class="navbar-brand" href="#">Hangman - The Game!</a>
            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?new=true">New game</a>
                </li>
            </ul>
        </nav>
        <div class="container">
            <div class="starter-template">
                <h1>Hangman - The Game!</h1>

                <?php if ($msg !== null) : ?>
                    <p><?php echo $msg; ?></p>
                <?php endif ?>
                <?php if ($game->isHanged()) : ?>
                    <p>Sorry, you're hanged! The word to guess was <strong><?php echo $game->getWord() ?></strong>. Play a <a href="index.php?new=true">new game.</a></p>
                <?php elseif ($game->isWon()) : ?>
                    <p>Wow! You found the word <strong><?php echo $game->getWord() ?></strong> and won this game. Play a <a href="index.php?new=true">new one!</a></p>
                <?php else : ?>
                    <p>Remaining attempts: <?php echo $game->getRemainingAttempts() ?></p>
                    <p>
                        <?php foreach (str_split((string) $game->getWord()) as $letter) : ?>
                            <?php echo $game->isLetterFound($letter) ? $letter : '_' ?>
                            &nbsp;
                        <?php endforeach ?>
                    </p>
                <?php endif ?>

                <h2>Choose a letter:</h2>

                    <p>
                    <?php foreach ($charsMap as $letter) : ?>
                        <a href="index.php?letter=<?php echo $letter ?>"><?php echo $letter ?></a>&nbsp;
                    <?php endforeach ?>
                    </p>

                <h2>Choose a word</h2>

                <form action="index.php" method="post">
                    <p>
                        <label for="word">...and the word is:</label>
                        <input type="text" name="word"/>
                        <button type="submit">I guess it!</button>
                    </p>
                </form>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>