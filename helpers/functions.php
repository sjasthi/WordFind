<script type="text/javascript">rectangles = [];</script>
<?php
mb_internal_encoding("UTF-8");
/**
 * Created by PhpStorm.
 * User: hashem alssaad
 * Date: 3/9/2016
 * Time: 10:08 PM
 */
function makeBoard($theBoard){
    //given a board array, return an HTML table based on the array
    global $boardData,$answerBoard,$answerCoordinates;
    $puzzle = "";
    $puzzle .= "<table border = 0 align=center style='font-size:24px;color:black' >\n";
    $answerBoard .= "<table id='answer' align=center border = 0 style='font-size:24px;color:black' >\n";
    //check logic here
    for ($row = 0; $row < $boardData["height"]; $row++){
        $puzzle .= "<tr>\n";
        $answerBoard .= "<tr class='answerkey'>\n";
        //$puzzle .="<div style='border: 2px solid red;border-radius:4px;'>";
        for ($col = 0; $col < $boardData["width"]; $col++){
            $puzzle .= "  <td width = 15 style='background-color:white;'>{$theBoard[$row][$col]}</td>\n";
            //Check to see whether the current letter is part of a word or not
            $answerLetter = false;
            //Loop through the answer coordinates and see if the letter corresponds to an answer
            for($i = 0; $i < sizeof($answerCoordinates);$i++){
                for($j = 0; $j < sizeof($answerCoordinates[$i]);$j++){
                    $index = $answerCoordinates[$i][$j];
                    if($index[0] == $row && $index[1] == $col){
                        $answerLetter = true;
                    }
                }
            }
            if($answerLetter){
                $answerBoard .= "  <td style='width:50px;height:50px;padding:0px;text-align:center;background-color:white;color:black;' id=".$row.$col.">{$theBoard[$row][$col]}</td>\n";
            }
            else{
                $answerBoard .= "  <td style='width:50px;height:50px;padding:0px;text-align:center;background-color:white;color:black;' id=".$row.$col.">{$theBoard[$row][$col]}</td>\n";
            }


        } // end col for loop
        $puzzle .= "</tr>\n";
        $answerBoard .= "</tr>\n";
        //$puzzle .="</div>";
    } // end row for loop
    $puzzle .= "</table>\n";
    $answerBoard .= "</table>\n";
    return $puzzle;
} // end printBoard;



function makeAnswerKey($theBoard){
    //given a board array, return an HTML table based on the array
    global $boardData;
    $puzzle = "";
    $puzzle .= "<table align=center border = 0  >\n";
    //check logic here
    for ($row = 0; $row < $boardData["height"]; $row++){
        $puzzle .= "<tr>\n";
        for ($col = 0; $col < $boardData["width"]; $col++){
            $puzzle .= "  <td width = 15 >{$theBoard[$row][$col]}</td>\n";
        } // end col for loop
        $puzzle .= "</tr>\n";
    } // end row for loop
    $puzzle .= "</table>\n";
    return $puzzle;
}

function isCharConsonant($hexcode, $language){
    $retVal = false;
    $englishVowels = array("041","045","049","04f","055");

    $TeluguVstart = hexdec("0x0C05");
    $TeluguVend = hexdec("0x0C14");

    $HindiVstart = hexdec("0x0904");
    $HindiVend = hexdec("0x0914");

    $GujaratiVstart = hexdec("0x0A85");
    $GujaratiVend = hexdec("0x0A94");

    $MalayalamVstart = hexdec("0x0D05");
    $MalayalamVend = hexdec("0x0D14");


    switch($language){

        case "English":
            if(!in_array($hexcode,$englishVowels)){
                $retVal = true;
            }
            break;

        case "Telugu":
            $TeluguChar = hexdec($hexcode);
            if($TeluguChar < $TeluguVstart && $TeluguChar > $TeluguVend){
                $retVal = true;
            }
            break;

        case "Hindi":
            $HindiChar = hexdec($hexcode);
            if($HindiChar < $HindiVstart && $HindiChar > $HindiVend){
                $retVal = true;
            }
            break;

        case "Gujarati":
            $GujaratiChar = hexdec($hexcode);
            if($GujaratiChar < $GujaratiVstart && $GujaratiChar > $GujaratiVend){
                $retVal = true;
            }
        break;
        case "Malayalam":
            $MalayalamChar = hexdec($hexcode);
            if($MalayalamChar < $MalayalamVstart && $MalayalamChar > $MalayalamVend){
                $retVal = true;
            }
        break;


    }
    return $retVal;
}

function isCharVowel($hexcode, $language){
    $retVal = false;
    $englishVowels = array("041","045","049","04f","055");

    $TeluguVstart = hexdec("0x0C05");
    $TeluguVend = hexdec("0x0C14");

    $HindiVstart = hexdec("0x0904");
    $HindiVend = hexdec("0x0914");

    $GujaratiVstart = hexdec("0x0A85");
    $GujaratiVend = hexdec("0x0A94");

    $MalayalamVstart = hexdec("0x0D05");
    $MalayalamVend = hexdec("0x0D14");

    switch($language){
        case "English":
            if(in_array($hexcode,$englishVowels)){
                $retVal = true;
            }
            break;

        case "Telugu":
            $TeluguChar = hexdec($hexcode);
            if($TeluguChar >= $TeluguVstart && $TeluguChar <= $TeluguVend){
                $retVal = true;
            }
            break;
        case "Hindi":
            $HindiChar = hexdec($hexcode);
            if($HindiChar >= $HindiVstart && $HindiChar <= $HindiVend){
                $retVal = true;
            }
            break;
        case "Gujarati":
            $GujaratiChar = hexdec($hexcode);
            if($GujaratiChar >= $GujaratiVstart && $GujaratiChar <= $GujaratiVend){
                $retVal = true;
            }
            break;
        case "Malayalam":
            $MalayalamChar = hexdec($hexcode);
            if($MalayalamChar >= $MalayalamVstart && $MalayalamChar <= $MalayalamVend){
                $retVal = true;
            }
            break;


    }
    return $retVal;

}

function addFoils(){
    $fillerChars = $_SESSION['fillerTypes'];
	$fillerChars1 = $_GET['fillerTypes'];;
    //add random dummy characters to board
    $language = $_SESSION['language'];
    global $board, $boardData;
	$myfile = fopen("helpers/telugu_seed.txt", "r") or die("Unable to open file!");
//echo fread($myfile,filesize("telugu_seed.txt"));
$lines=array();
$word=array();
$vowels=array();
$constants=array();
$vowelMixers=array();
$singleConstantBlends=array();
$doubleConstantBlends=array();
$tripleConstantBlends=array();
$constantBlendsAndVowels=array();
$any=array();
while (!feof($myfile))
{
$line=fgets($myfile);
//$lines = explode("\n", $line);
$lines[]=$line;
//echo "first word: " . $lines[0] . " second word: " . $lines[1]  . "<br>";
//array_push($word, preg_split('/ +/', $line));
//echo "I like " . $lines[0] . "<br>";
//echo "I words " . $word[0] . "<br>";
}
//print_r($word);
foreach($lines as $w){
	$word = explode(" ",trim($w));
	//echo "the word " . $w. "<br>";
	//echo " first words " . $word[0] . "<br>";
	if (in_array("VOWELS", $word)) {
		$vowels[]=$word[1];
	}
	elseif (in_array("CONSONANTS", $word)) {
                $constants[]=$word[1];
        }
	elseif (in_array("VOWELMIXERS", $word)) {
                $vowelMixers[]=$word[1];
        }
	elseif (in_array("SINGLECONSONANTBLENDS", $word)) {
                $singleConstantBlends[]=$word[1];
        }
	elseif (in_array("DOUBLECONSONANTBLENDS", $word)) {
                $doubleConstantBlends[]=$word[1];
        }
	elseif (in_array("TRIPLECONSONANTBLENDS", $word)) {
                $tripleConstantBlends[]=$word[1];
        }
	elseif (in_array("CONSONANTBLENDSANDVOWELS", $word)) {
                $constantBlendsAndVowels[]=$word[1];
        }
	//echo " second word " . $word[1] . "<br>";
}
//foreach($any as $v){
//	echo "the vowel is " .  $v . "<br>";
//}
//foreach($constants as $v){
//        echo "the constant is " .  $v . "<br>";
//}
$any = array_merge($vowels, $constants, $vowelMixers, $singleConstantBlends, $doubleConstantBlends, $tripleConstantBlends, $constantBlendsAndVowels);
//foreach($any as $v){
//        echo "the constant is " .  $v . "<br>";
//}
//echo "I like " . $vowels[0] . ", " . $vowels[1] . " and " . $vowels[2] . ".";
//echo $fillerChars;
//echo $fillerChars1;
fclose($myfile);

    switch($language) {
        case "English":
            for ($row = 0; $row < $boardData["height"]; $row++){
                for ($col = 0; $col < $boardData["width"]; $col++){
                    if ($board[$row][$col] == "."){
                        $validChar = false;
                        while(!$validChar) {

                            $english_char="";
                            $startHex = "0x0041";
                            $endHex = "0x005A";
                            $num = rand(hexdec($startHex), hexdec($endHex));
                            $hexcode = dechex($num);
                            if($hexcode == 0x004F){
                                continue;
                            }

                            if ($fillerChars == "Consonants") {
                                if(isCharVowel($hexcode,$language)){
                                    continue;
                                }
                                $english_char .= sprintf("\\u%'04s", dechex($num));
                                if(json_decode('"' . $english_char . '"') == "O"){
                                    continue;
                                }
                                $board[$row][$col] = json_decode('"' . $english_char . '"');
                                $validChar = true;
                            }
                            elseif($fillerChars == "Vowels"){
                                if(isCharConsonant($hexcode,$language)){
                                    continue;
                                }
                                $english_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $english_char . '"');
                                $validChar = true;
                            }
                            else{
                                $english_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $english_char . '"');
                                $validChar = true;
                            }


                        }
                    } // end if
                } // end col for loop
            } // end row for loop
            break;

        case "Telugu":

            for ($row = 0; $row < $boardData["height"]; $row++){
                for ($col = 0; $col < $boardData["width"]; $col++){
                    if ($board[$row][$col] == "."){
                        //Make sure the character is valid
                        $validChar = false;
                        while(!$validChar) {

                            $telugu_char = "";
                            $startHex = "0x0c05";
                            $endHex = "0x0c39";
                            $num = rand(hexdec($startHex), hexdec($endHex));
                            $hexcode = dechex($num);
//                            var_dump($hexcode);

                            if(is_blank_Telugu($hexcode)){
                                continue;
                            }
                            elseif($fillerChars == "Consonants"){
//                                if(isCharVowel($hexcode,$language)){
//
//                                    continue;
//                                }
				$k = array_rand($constants);
                                $telugu_char .= $constants[$k];
                                $board[$row][$col] = $telugu_char;
                                $validChar = true;
                            }
                            elseif($fillerChars == "Vowels"){
//                                if(isCharConsonant($hexcode,$language)){
//                                    continue;
//                                }
				$k = array_rand($vowels);
                                $telugu_char .= $vowels[$k];
                                $board[$row][$col] = $telugu_char;
                                $validChar = true;
                            }
			 elseif($fillerChars == "SCB"){
//                                $telugu_char .= sprintf("\\u%'04s", dechex($num));
//                                $board[$row][$col] = json_decode('"' . $telugu_char . '"');
//                                $validChar = true;
				$k = array_rand($singleConstantBlends);
				$telugu_char .= $singleConstantBlends[$k];
				$board[$row][$col] = "  " . $telugu_char . "  ";
				$validChar = true;
                            }
			 elseif($fillerChars == "DCB"){
//                                $telugu_char .= sprintf("\\u%'04s", dechex($num));
//                                $board[$row][$col] = json_decode('"' . $telugu_char . '"');
//                                $validChar = true;
                                $k = array_rand($doubleConstantBlends);
                                $telugu_char .= $doubleConstantBlends[$k];
                                $board[$row][$col] = "  " . $telugu_char . "  ";
                                $validChar = true;
                            }
			 elseif($fillerChars == "TCB"){
//                                $telugu_char .= sprintf("\\u%'04s", dechex($num));
//                                $board[$row][$col] = json_decode('"' . $telugu_char . '"');
//                                $validChar = true;
                                $k = array_rand($tripleConstantBlends);
                                $telugu_char .= $tripleConstantBlends[$k];
                                $board[$row][$col] = "  " . $telugu_char . "  ";
                                $validChar = true;
                            }
			 elseif($fillerChars == "CDV"){
//                                $telugu_char .= sprintf("\\u%'04s", dechex($num));
//                                $board[$row][$col] = json_decode('"' . $telugu_char . '"');
//                                $validChar = true;
                                $k = array_rand($constantBlendsAndVowels);
                                $telugu_char .= $constantBlendsAndVowels[$k];
                                $board[$row][$col] = "  " . $telugu_char . "  ";
                                $validChar = true;
                            }

			else{
//                                $telugu_char .= sprintf("\\u%'04s", dechex($num));
//                                $board[$row][$col] = json_decode('"' . $telugu_char . '"');
//                                $validChar = true;
                                $k = array_rand($any);
                                $telugu_char .= $any[$k];
                                $board[$row][$col] = "  " . $telugu_char . "  ";
                                $validChar = true;
                            }

                        }
                    } // end if
                } // end col for loop
            } // end row for loop
            break;

        case "Hindi":
            for ($row = 0; $row < $boardData["height"]; $row++){
                for ($col = 0; $col < $boardData["width"]; $col++){
                    if ($board[$row][$col] == "."){
                        //Make sure the character is valid
                        $validChar = false;
                        while(!$validChar) {

                            $hindi_char = "";
                            $startHex = "0x0904";
                            $endHex = "0x0939";
                            $num = rand(hexdec($startHex), hexdec($endHex));
                            $hexcode = dechex($num);

                            if($fillerChars == "Consonants"){
                                if(isCharVowel($hexcode,$language)){
                                    continue;
                                }
                                $hindi_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $hindi_char . '"');
                                $validChar = true;
                            }
                            elseif($fillerChars == "Vowels"){
                                if(isCharConsonant($hexcode,$language)){
                                    continue;
                                }
                                $hindi_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $hindi_char . '"');
                                $validChar = true;
                            }
                            else {
                                $hindi_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $hindi_char . '"');
                                $validChar = true;
//                            }
                            }
                        }
                    } // end if
                } // end col for loop
            } // end row for loop
            break;

        case "Gujarati":
            for ($row = 0; $row < $boardData["height"]; $row++){
                for ($col = 0; $col < $boardData["width"]; $col++){
                    if ($board[$row][$col] == "."){
                        //Make sure the character is valid
                        $validChar = false;
                        while(!$validChar) {

                            $gujarati_char = "";
                            $startHex = "0x0a81";
                            $endHex = "0x0acc";
                            $num = rand(hexdec($startHex), hexdec($endHex));
                            $hexcode = dechex($num);
                            $number = (20 * $row) + $col;
                            //echo $number;
                            //var_dump($hexcode);
                            if(is_blank_Gujarati($hexcode)){
                                continue;
                            }
                            elseif($fillerChars == "Consonants"){
                                if(isCharVowel($hexcode,$language)){
                                    continue;
                                }
                                $gujarati_char  .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $gujarati_char  . '"');
                                $validChar = true;
                            }
                            elseif($fillerChars == "Vowels"){
                                if(isCharConsonant($hexcode,$language)){
                                    continue;
                                }
                                $gujarati_char  .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $gujarati_char  . '"');
                                $validChar = true;
                            }
                            else{
                                $gujarati_char  .= sprintf("\\u%'04s", dechex($num));
                            $board[$row][$col] = json_decode('"' . $gujarati_char  . '"');
                            $validChar = true;
                            }

                        }
                    } // end if
                } // end col for loop
            } // end row for loop
            break;

        case "Malayalam":
            for ($row = 0; $row < $boardData["height"]; $row++){
                for ($col = 0; $col < $boardData["width"]; $col++){
                    if ($board[$row][$col] == "."){
                        //Make sure the character is valid
                        $validChar = false;
                        while(!$validChar) {

                            $malay_char = "";
                            $startHex = "0x0d01";
                            $endHex = "0x0d3a";
                            $num = rand(hexdec($startHex), hexdec($endHex));

                            $hexcode = dechex($num);
                            //$number = (20 * $row) + $col;
                            //echo $number;
                            //var_dump($hexcode);
                            if(is_blank_Malayalam($hexcode)){
                                continue;
                            }
                            elseif($fillerChars == "Consonants"){
                                if(isCharVowel($hexcode,$language)){
                                    continue;
                                }
                                $malay_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $malay_char. '"');
                                $validChar = true;
                            }
                            elseif($fillerChars == "Vowels"){
                                if(isCharConsonant($hexcode,$language)){
                                    continue;
                                }
                                $malay_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $malay_char. '"');
                                $validChar = true;
                            }
                            else{
                                $malay_char .= sprintf("\\u%'04s", dechex($num));
                                $board[$row][$col] = json_decode('"' . $malay_char. '"');
                                $validChar = true;
                            }

                        }
                    } // end if
                } // end col for loop
            } // end row for loop
            break;
    }





} // end addFoils

function is_blank_Telugu($hexVal){
    $is_blank = false;
    $blankArray = array("c00","c01","c02","c03","c0d","c11","c29","c34");
    if(in_array($hexVal,$blankArray)){
        return true;
    }
    return $is_blank;
}

function is_blank_Gujarati($hexVal){
    {
        $is_blank = false;
        $blankArray = array("a8e","a92","aa9","ab1","ab4","ac6","aca","aba","abb","a84");
        if(in_array($hexVal,$blankArray)){
            return true;
        }
        return $is_blank;
    }
}
// Malayalam chars that do not show up should be excluded
function is_blank_Malayalam($hexVal){
    {
        $is_blank = false;
        $blankArray = array("d0d","d11","d3a","d04","d01","d2c","d29");
        if(in_array($hexVal,$blankArray)){
            return true;
        }
        return $is_blank;
    }
}

function printPuzzle(){
    //print out page to user with puzzle on it
    global $puzzle, $currentWord, $keyPuzzle, $boardData,$answerBoard;
    //print puzzle itself
//    echo "<script type='text/javascript' src='solutionRectangles.js'></script>";

  print "";
  print "<h1 style=\"text-align:center;\">{$_SESSION['puzzlename']}</h1>";
    //print word list
    $wordCounter = 0;
    print "<h3 style='width:40%;margin:auto;border:2px solid black;border-radius:5px;padding-top:10px;padding-bottom:10px;background-color:sandybrown;text-align:center'><u>Word List</u></h3><br><br>";
    print "<table border = 1 align=center>";
    // Print puzzle words in rows of 5
    foreach ($_SESSION['answerKeyList'] as $theWord){
        if($wordCounter % 5 == 0) {
            print "<tr><td><b>". implode($theWord)."</b></td>";
        }
        elseif($wordCounter % 5 == 4){
            print "<td><b>". implode($theWord)."</b></td></tr>";
        }
        else{
            print "<td><b>". implode($theWord)."</b></td>";
        }
        $wordCounter++;
    }
    print "</table>";

    $puzzleName = $_SESSION['puzzlename'];
    echo "<br><br>";
    print "$puzzle";
    echo "<br><br>";
    echo "<hr>";
    echo "<h1><center>Answer Key</center></h1>";

    print "$answerBoard";
    addSolution();
    //print word list
//    foreach ($currentWord as $theWord){
//        print "<tr><td>$theWord</td></tr>\n";
//    } // end foreach
//    print "</table>\n";
//    $puzzleName = $_SESSION['puzzlename'];
//    echo "<br><br>";
    //print form for requesting answer key.
    //send answer key to that form (sneaky!)
    //echo $answerBoard;
//    echo "<br /><br /><br /><br /><br /><br /><br /><br />";
//    echo '<form action = "wordFindKey.php" method = "post">';
//    echo '<input type = "hidden" name = "key" value = "$keyPuzzle">';
//    echo '<input type = "hidden" name = "puzzleName" value = "$puzzleName">';
//    echo '<input type = "submit" value = "Show Answer Key">';
//    echo '</form></center>';
} // end printPuzzle


function addWord($theWord, $dir){
    //attempt to add a word to the board or return false if failed
    global $board, $boardData, $answerBoard, $answerCoordinates;
    //remove trailing characters if necessary
    //$theWord = rtrim($theWord);
    $itWorked = TRUE;
    $coords = array();
    $share = $_SESSION['sharechars'];
    switch ($dir){
        case "E":
            //col from 0 to board width - word width,
            //row from 0 to board height
            $newCol = rand(0, $boardData["width"] - 1 - sizeof($theWord));
            $newRow = rand(0, $boardData["height"]-1);
            for ($i = 0; $i < sizeof($theWord); $i++){
                //new character same row, initial column + $i
                $boardLetter = $board[$newRow][$newCol + $i];
                $wordLetter = $theWord[$i];
                //check for legal values in current space on board
                if($share){
                    if (($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow][$newCol + $i] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }else{
                    if (($boardLetter == ".")){
                        $board[$newRow][$newCol + $i] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }
                // Push the coordinate to local coords array
                $coord = array($newRow ,$newCol +$i);
                array_push($coords,$coord);
            } // end for loop
            break;
        case "W":
            //col from word width to board width
            //row from 0 to board height
            $newCol = rand(sizeof($theWord), $boardData["width"] -1);
            $newRow = rand(0, $boardData["height"]-1);
            //print "west:\tRow: $newRow\tCol: $newCol<br />\n";
            for ($i = 0; $i < sizeof($theWord); $i++){
                //check for a legal move
                $boardLetter = $board[$newRow][$newCol - $i];
                $wordLetter = $theWord[$i];
                if($share){
                    if (($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow][$newCol - $i] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }else{
                    if (($boardLetter == ".")){
                        $board[$newRow][$newCol - $i] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }
                // Push the coordinate to local coords array
                $coord = array($newRow,$newCol -$i);
                array_push($coords,$coord);
            } // end for loop
            break;
        case "S":
            //col from 0 to board width
            //row from 0 to board height - word length
            $newCol = rand(0, $boardData["width"] -1);
            $newRow = rand(0, $boardData["height"]-1 - sizeof($theWord));
            //print "south:\tRow: $newRow\tCol: $newCol<br />\n";
            for ($i = 0; $i < sizeof($theWord); $i++){
                //check for a legal move
                $boardLetter = $board[$newRow + $i][$newCol];
                $wordLetter = $theWord[$i];
                if($share){
                    if (($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow + $i][$newCol] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }else{
                    if (($boardLetter == ".")){
                        $board[$newRow + $i][$newCol] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }
                // Push the coordinate to local coords array
                $coord = array($newRow + $i,$newCol );
                array_push($coords,$coord);

            } // end for loop
            break;
        case "N":
            //col from 0 to board width
            //row from word length to board height
            $newCol = rand(0, $boardData["width"] -1);
            $newRow = rand(sizeof($theWord), $boardData["height"]-1);
            for ($i = 0; $i < sizeof($theWord); $i++){
                //check for a legal move
                $boardLetter = $board[$newRow - $i][$newCol];
                $wordLetter = $theWord[$i];
                if($share){
                    if (($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow - $i][$newCol] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }else{
                    if (($boardLetter == ".")){
                        $board[$newRow - $i][$newCol] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    } // end if
                }
                // Push the coordinate to local coords array
                $coord = array($newRow - $i,$newCol);
                array_push($coords,$coord);

            } // end for loop
            break;
        case "NE":
            //col from 0 to board width - wordlength
            //row from word length to board height
            $newCol = rand(0,$boardData["width"]- 1 - sizeof($theWord));
            $newRow = rand(sizeof($theWord),$boardData["height"]-1);
            for($i = 0; $i < sizeof($theWord);$i++){
                $boardLetter = $board[$newRow-$i][$newCol + $i];
                $wordLetter = $theWord[$i];
                if($share){
                    if(($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow-$i][$newCol + $i] = $wordLetter;
                    } else{
                        $itWorked = FALSE;
                    }//end if
                }else{
                    if(($boardLetter == ".")){
                        $board[$newRow-$i][$newCol + $i] = $wordLetter;
                    } else{
                        $itWorked = FALSE;
                    }//end if
                }//end if
                // Push the coordinate to local coords array
                $coord = array($newRow - $i,$newCol +$i);
                array_push($coords,$coord);
            }
            break;
        case "NW":
            // col from word length to board width
            //height from word length to board height
            $newCol = rand(sizeof($theWord),$boardData["width"]- 1);
            $newRow = rand(sizeof($theWord),$boardData["height"]-1);
            for($i = 0; $i < sizeof($theWord);$i++){
                $boardLetter = $board[$newRow-$i][$newCol - $i];
                $wordLetter = $theWord[$i];
                if($share){
                    if(($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow-$i][$newCol - $i] = $wordLetter;
                    } else{
                        $itWorked = FALSE;
                    }//end if
                }else{
                    if(($boardLetter == ".")){
                        $board[$newRow-$i][$newCol - $i] = $wordLetter;
                    } else{
                        $itWorked = FALSE;
                    }//end if
                }//end if
                // Push the coordinate to local coords array
                $coord = array($newRow - $i,$newCol -$i);
                array_push($coords,$coord);
            }//end case
            break;
        case "SE":
            //col from 0 to board width - length of word
            // row from 0 to board height - length of word
            $newCol = rand(0,$boardData["width"]- 1 -sizeof($theWord));
            $newRow = rand(0,$boardData["height"]- 1 -sizeof($theWord));
            for($i = 0; $i < sizeof($theWord);$i++){
                $boardLetter = $board[$newRow+$i][$newCol + $i];
                $wordLetter = $theWord[$i];

                if($share){
                    if(($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")){
                        $board[$newRow+$i][$newCol + $i] = $wordLetter;
                    } else{
                        $itWorked = FALSE;
                    }//end if
                }else{
                    if(
                        ($boardLetter == ".")){
                        $board[$newRow+$i][$newCol + $i] = $wordLetter;
                    } else{
                        $itWorked = FALSE;
                    }//end if
                }//end if
                // Push the coordinate to local coords array
                $coord = array($newRow + $i,$newCol +$i);
                array_push($coords,$coord);
            }//end case
            break;
        case "SW":
            // col from length of word to board with
            // row from 0 to board height - length of word

            $newCol = rand(sizeof($theWord),$boardData["width"]- 1);
            $newRow = rand(0,$boardData["height"]- sizeof($theWord)-1);
            for($i = 0; $i < sizeof($theWord);$i++) {
                $boardLetter = $board[$newRow + $i][$newCol - $i];
                $wordLetter = $theWord[$i];
                if ($share) {
                    if (($boardLetter == $wordLetter) ||
                        ($boardLetter == ".")
                    ) {
                        $board[$newRow + $i][$newCol - $i] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    }//end if
                } else {
                    if (($boardLetter == ".")) {
                        $board[$newRow + $i][$newCol - $i] = $wordLetter;
                    } else {
                        $itWorked = FALSE;
                    }//end if
                }//end if
                // Push the coordinate to local coords array
                $coord = array($newRow + $i,$newCol -$i);
                array_push($coords,$coord);
            }

            break;
    } // end switch
    // Push the coordinates of the word if it was successful
    if($itWorked){
        array_push($answerCoordinates,$coords);
    }
    return $itWorked;
} // end addWord


//function addRectangle($rectID,$beginCoord,$direction,$length){
//
//    echo "<div class='rectangle' id='" . $rectID . "'></div>";
//    echo "<script type='text/javascript' >changeCSS('" . $rectID ."', '". $beginCoord ."', ". $direction .", ". $length .");";
//    echo "var rect = ['" . $rectID ."', '" . $beginCoord ."', " . $direction .", " . $length . "]';";
//    echo "console.log(rect);";
//    echo "rectangles.push(rect);</script>";
//
//}
function getSolutionLength($beginRow,$beginCol,$endRow,$endCol)
{
    $adjustedLength = 0;
    $oneChar = $_SESSION['one_char_length'];
    $multiplier = $_SESSION['length_multiplier'];

    $length = sqrt(pow($endRow - $beginRow, 2) + pow($endCol - $beginCol, 2));

    if ($beginRow == $endRow && $beginCol == $endCol) {
        $length = $oneChar;
    }
    if ($length > $oneChar && $length < 5) {
        $adjustedLength = round($length * ($multiplier * ((($_SESSION['length_increaser'] / $length) * $_SESSION['length_factor']) + 1)));
    } else {
        $adjustedLength = round($length * $multiplier);
    }
    // var_dump($adjustedLength);
    return $adjustedLength;
}

function getDirection($direction){
    $retVal = 0;
    switch($direction){
        case "N":
            $retVal = 4;
            break;
        case "E":
            $retVal = 1;
            break;
        case "S":
            $retVal = 3;
            break;
        case "W":
            $retVal = 2;
            break;
        case "NW":
            $retVal = 6;
            break;
        case "NE":
            $retVal = 8;
            break;
        case "SE":
            $retVal = 5;
            break;
        case "SW":
            $retVal =7;
    }
    return $retVal;
}

function addSolution(){
    global $answerCoordinates,$solutionDirections;
    $counter = 0;

    foreach($answerCoordinates as $wordCoord){
        //Id for rectangle
            $id = "sol" . $counter;
        //var_dump($wordCoord);
        if($wordCoord == null){
            continue;
        }
        // var_dump($wordCoord);
        // var_dump(sizeof($wordCoord) . " Size of word");
        // var_dump($wordCoord[0][0] . "," . $wordCoord[0][1] . " Beginning Coordinate");
        // var_dump($wordCoord[sizeof($wordCoord)-1][0].",".$wordCoord[sizeof($wordCoord)-1][1]." Ending Coordinate");
//        echo "\n\n\n";
           $begCoord = "".$wordCoord[0][0] ."".$wordCoord[0][1]."";
//            $endCoord = "".$wordCoord[sizeof($wordCoord)-1][0] ."".$wordCoord[sizeof($wordCoord)-1][1]."";
           $length = getSolutionLength($wordCoord[0][0],$wordCoord[0][1],$wordCoord[sizeof($wordCoord)-1][0],$wordCoord[sizeof($wordCoord)-1][1]);
            // var_dump($length . " The Length");
          $direction = getDirection($solutionDirections[$counter]);
        // var_dump($direction . " The Direction");
        // echo "<br>";
          addRectangle($id,$begCoord,$direction,$length);
         $counter++;
    }


}





function fillBoard(){
    //fill board with list by calling addWord() for each word
    //or return false if failed
    global $currentWord,$answerCoordinates,$solutionDirections;
    $puzzleDirection= $_SESSION['direction'];
    $allDirections = array("N", "S", "E", "W","NE","NW","SE","SW");
    $horizontal = array("E","W");
    $vertical = array("N","S");
    $diagonal = array("NE","NW","SE","SW");
    $itWorked = TRUE;
    $counter = 0;
    $keepGoing = TRUE;

    switch($puzzleDirection){

        case "all":
            while($keepGoing) {
                $dir = rand(0, 7);
                $result = addWord($currentWord[$counter], $allDirections[$dir]);
                if ($result == FALSE) {
                    //print "failed to place $word[$counter]";
                    $keepGoing = FALSE;
                    $itWorked = FALSE;
                    $answerCoordinates = array();
                    $solutionDirections = array();
                    break;
                } // end if
                $counter++;
                array_push($solutionDirections,$allDirections[$dir]);
                if ($counter >= count($currentWord)) {
                    $keepGoing = FALSE;
                }
            }// end if
         break;

        case "horizontal":
            while($keepGoing){
                $dir = rand(0, 1);
                $result = addWord($currentWord[$counter], $horizontal[$dir]);
                if ($result == FALSE){
                    //print "failed to place $word[$counter]";
                    $keepGoing = FALSE;
                    $itWorked = FALSE;
                    $answerCoordinates = array();
                    $solutionDirections = array();
                } // end if
                $counter++;
                array_push($solutionDirections,$horizontal[$dir]);
                if ($counter >= count($currentWord)){
                    $keepGoing = FALSE;
                } // end if
            } // end while
        break;

        case "vertical":
            while($keepGoing){
                $dir = rand(0, 1);
                $result = addWord($currentWord[$counter], $vertical[$dir]);
                if ($result == FALSE){
                    //print "failed to place $word[$counter]";
                    $keepGoing = FALSE;
                    $itWorked = FALSE;
                    $answerCoordinates = array();
                    $solutionDirections = array();
                } // end if
                $counter++;
                array_push($solutionDirections,$vertical[$dir]);
                if ($counter >= count($currentWord)){
                    $keepGoing = FALSE;
                } // end if
            } // end while
            break;

        case "diagonal":
            while($keepGoing){
                $dir = rand(0, 3);
                $result = addWord($currentWord[$counter], $diagonal[$dir]);
                if ($result == FALSE){
                    //print "failed to place $word[$counter]";
                    $keepGoing = FALSE;
                    $itWorked = FALSE;
                    $answerCoordinates = array();
                    $solutionDirections = array();
                } // end if
                $counter++;
                array_push($solutionDirections,$diagonal[$dir]);
                if ($counter >= count($currentWord)){
                    $keepGoing = FALSE;
                } // end if
            } // end while
            break;


   }

    return $itWorked;
} // end fillBoard

function clearBoard(){
    //initialize board with a . in each cell
    global $board, $boardData,$answerBoard;
    for ($row = 0; $row < $boardData["height"]; $row++){
        for ($col = 0; $col < $boardData["width"]; $col++){
            $board[$row][$col] = ".";
            //$answerBoard[$row][$col] = ".";
        } // end col for loop
    } // end row for loop
} // end clearBoard

function parseList(){
    //gets word list, creates array of words from it
    //or return false if impossible
    global $currentWord, $boardData;
    $itWorked = TRUE;
    //Check to see if word will fit
    foreach($currentWord as $wordIndexArray) {
        echo "\n";
        $processor = new wordProcessor($wordIndexArray);
        $wordIndex = $processor->parseToLogicalChars($wordIndexArray,$_SESSION['language']);

        //stop if any words are too long to fit in puzzle
        if ((sizeof($wordIndex) > $boardData['width']) &&
            (sizeof($wordIndex) > $boardData['height'])
        ) {
            print "$wordIndex is too long for puzzle";
            print "Please increase the grid size in previous page and try again";
            $itWorked = FALSE;
        } // end if
    }
    //} // end foreach
    return $itWorked;
} // end parseList
