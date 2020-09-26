<?php
    $page_title = 'Word Puzzle Maker';
    include_once('helpers/functions.php');
    session_start();
    include('inc/header.php');
?>


<script src="js/solutionRectangles.js"></script>

<div class="jumbotron" id="jumbos"></div>

<?php

function addRectangle($rectID,$beginCoord,$direction,$length){

    echo "<div class='rectangle' id='" . $rectID . "'></div>";
    echo "<script type='text/javascript' >changeCSS('" . $rectID ."', '". $beginCoord ."', ". $direction .", ". $length .");";
    echo "var rect = ['" . $rectID ."', '" . $beginCoord ."', " . $direction .", " . $length . "];";
    echo "console.log(rect);";
    echo "rectangles.push(rect);</script>";

}

$_SESSION['jsRectangles'] = array();
$_SESSION['fillerTypes'] = $_GET['fillerTypes'];
global $solutionDirections;
$_SESSION['one_char_length'] = 0.5;
$_SESSION['length_multiplier'] = 55;
$_SESSION['length_increaser'] = 1.4;
$_SESSION['length_factor'] = 0.35;
$solutionDirections = array();
mb_internal_encoding("UTF-8");

// Incluce the functions to make the board
include_once("helpers/functions.php");
include_once("parser/word_processor.php");

if((empty($_GET['puzzlename']))||(empty($_GET['puzzlewords']))){
    echo "<script type=\"text/javascript\">
            alert('Missing Puzzle Name or Word Bank Please Re-enter -- Close this window and add a name');
            </script>";
    die(0);
}

$_SESSION['puzzlename'] = $_GET['puzzlename'];
$_SESSION['language'] = $_GET['language'];

//Get the direction the words can be laid out in
// Default all
if((empty($_GET['word-direction']))){
    $_SESSION['direction'] = "all";
} else {
    $_SESSION['direction'] = $_GET['word-direction'];
}

//Get whether the words can share chars or not
// Default yes
if(empty($_GET['sharechars'])){
    $_SESSION['sharechars'] = true;
} else {
    $_SESSION['sharechars'] = $_GET['sharechars'];
}

global $answerPuzzle;
// WORD PUZZLE MAKER
// Generates a word search puzzle based on a word list
// entered by user. User can also specify the size of
// the puzzle and print out an answer key if desired
global $wordList;
$wordList= $_GET['puzzlewords'];

// త ల ్ ల ి
if($_SESSION['language']=== "English"){
$wordList = strtoupper($wordList);}
//get puzzle data from HTML form
$currentWord = explode("\n", $wordList);
//var_dump($currentWord);
$_SESSION['numWords'] = sizeof($currentWord);
$rawWordList = array();
$answerWordList = array();

foreach ($currentWord as $singleWord){
    //take out trailing newline characters
    $singleWord = rtrim($singleWord);
    if($_SESSION['language']=== "English"){
        $singleWord = strtoupper($singleWord);
    }

    // Remove double instances of words
    if(!in_array($singleWord,$rawWordList)){

        $wordProc = new wordProcessor($singleWord);
        // Get the logical chars for the word
        $logChars = $wordProc->parseToLogicalChars($singleWord,$_SESSION['language']);
        foreach($logChars as $singleChar){
            if($singleChar === " "){
                $singleChar = "";
            }
        }
        // Word List to be pushed into the array for the puzzle -- remove spaces
        array_push($rawWordList,$logChars);
        // Answer word list to be displayed
        array_push($answerWordList,$logChars);
    }
}

global $answerKeyList;

//Answer Coordinates
global $answerCoordinates;
$answerCoordinates= array();

//Answerboard
global $answerBoard;
$answerBoard = "";

// The answer keys
$answerKeyList = $answerWordList;
$_SESSION['answerKeyList'] = $answerKeyList;
global $currentWord;
$currentWord = $rawWordList;
//check for a word list
if(empty($currentWord)){
    //make default puzzle
    print "Sorry, no data found";
} else {
    $width = $_GET["width"];
    $_SESSION['width'] = $width;
    $height = $_GET["height"];
    $_SESSION['height'] = $height;
    $boardData = array(
        "width" => $width,
        "height" => $height,
        "puzzlewords" => $currentWord
    );
}
//try to get a word list from user input
if(parseList() == TRUE){
    $legalBoard = FALSE;
    //keep trying to build a board until you get a legal result
    while ($legalBoard == FALSE){
        clearBoard();
        $legalBoard = fillBoard();
    } // end while

    //make the answer key
    $key = $board;
    
    //make the final puzzle
    addFoils();
    $puzzle = makeBoard($board);

    //print out the result page
    printPuzzle();
} // end parsed list if

?>

<?php include('inc/footer.php');