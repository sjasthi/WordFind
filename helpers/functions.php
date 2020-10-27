<?php

    function getPuzzleById($puzzleId, $pdo){
        $sql = 'SELECT * from puzzles WHERE puzzle_id = :puzzle_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['puzzle_id' => $puzzleId]);
        return $puzzles = $stmt->fetchAll();
    }

    function getCategoriesWithTopNResults($pdo){
        $sql = "SELECT cat_name, categories.cat_id,
            SUBSTRING_INDEX(GROUP_CONCAT(puzzles.title), ',', 5) AS puzzle_names, -- show top 5 results --
            SUBSTRING_INDEX(GROUP_CONCAT(puzzles.puzzle_id), ',', 5) AS puzzle_ids -- id top 5 results --
            FROM puzzles
            LEFT JOIN categories
            ON categories.cat_id = puzzles.cat_id
            GROUP BY categories.cat_name";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $categories = $stmt->fetchAll();
    }

    function getCategoryById($categoryId, $pdo){
        $sql = "SELECT cat_name,
            GROUP_CONCAT(puzzles.title) AS puzzle_names,
            GROUP_CONCAT(puzzles.puzzle_id) AS puzzle_ids,
            GROUP_CONCAT(puzzles.description) AS puzzle_descriptions
            FROM puzzles
            LEFT JOIN categories
            ON categories.cat_id = puzzles.cat_id
            WHERE puzzles.cat_id = :category_id
            GROUP BY categories.cat_name";
            
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $category = $stmt->fetchAll();
    }




















    function generatePuzzle(){
        
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'cat_name'          => $_POST['cat_name'],
            'title'             => $_POST['title'],
            'description'       => $_POST['description'],
            'author_id'         => 1, // will utilize logged in user in future iterations
            'language'          => $_POST['language'],
            'word_direction'    => $_POST['word_direction'],
            'height'            => $_POST['height'],
            'width'             => $_POST['width'],
            'share_chars'       => $_POST['share_chars'],
            'filler_char_types' => $_POST['filler_char_types'],
            'word_bank'         => $_POST['word_bank'],
            'generate_board'    => TRUE
        ];

        // break string into array
        $wordBank = explode("\n", $data['word_bank']);

        $rawWordBank = [];

        foreach($wordBank as $word){
            // remove trailing newline chars
            $word = rtrim($word);
            if($data['language'] === 'English'){
                $word = strtoupper($word);
            }

            // remove double instances of words
            if(!in_array($word, $rawWordBank)){
                array_push($rawWordBank, $word);
            }
        }

        $charBank = [];
        foreach($rawWordBank as $word){
            $wordProcessor = new wordProcessor($word);

            // get logical chars of word
            $logChars = $wordProcessor->parseToLogicalChars($word, $data['language']);

            // check grid dimensions are not too small for logChars
            if(sizeof($logChars) > $data['height'] && sizeof($logChars) > $data['width']){
                $data['error'] = 'At least one of the words in your word bank is too large for the specified dimensions. Please adjust grid dimensions.';
                $data['generate_board'] = FALSE;
            } else {
                foreach($logChars as $singleChar){
                    if($singleChar === " "){
                        $singleChar = "";
                    }
                }
                array_push($charBank, $logChars);
            }
        } // end foreach

        // push to data
        $data['char_bank'] = $charBank;

        // build board
        if(parseList($data) == TRUE){
            $legalBoard = FALSE;

            while($legalBoard == FALSE){
                clearBoard($data);
                $legalBoard = fillBoard($data);
            }

            addFoils($data);
            

            // set legalBoard to data
            global $board, $solutionDirections, $answerCoords;
            $data['board'] = $board;
            $data['solution_directions'] = $solutionDirections;
            $data['answer_coordinates'] = $answerCoords;

            addSolution($data);
        }
        return $data;
    }

    // init board w/ . . .
    function clearBoard($data){
        global $board;
        for($row = 0; $row < $data['height']; $row++){
            for($col = 0; $col < $data['width']; $col++){
                $board[$row][$col] = '.';
            }
        }
    }

    function fillBoard($data){
        global $solutionDirections, $coords, $answerCoords;
        $solutionDirections = array();
        $answerCoords = array();
        $allDirections = array("N", "S", "E", "W","NE","NW","SE","SW");
        $horizontal = array("E","W");
        $vertical = array("N","S");
        $diagonal = array("NE","NW","SE","SW");
        $itWorked = TRUE;
        $keepGoing = TRUE;
        $counter = 0;

        switch($data['word_direction']){
            case "all":
                while($keepGoing){
                    $dir = rand(0, 7);
                    $result = addWord($data['char_bank'][$counter], $allDirections[$dir], $data);
                    if($result == FALSE){
                        $keepGoing == FALSE;
                        $itWorked == FALSE;
                        $answerCoordinates = array();
                        $solutionDirections = array();
                        break;
                    }
                    $counter++;
                    array_push($solutionDirections, $allDirections[$dir]);
                    if($counter >= count($data['char_bank'])){
                        $keepGoing = FALSE;
                    }
                    array_push($answerCoords, $coords);
                }
            break;

            case "horizontal":
                while($keepGoing){
                    $dir = rand(0, 1);
                    $result = addWord($data['char_bank'][$counter], $horizontal[$dir], $data);
                    if ($result == FALSE){
                        $keepGoing = FALSE;
                        $itWorked = FALSE;
                        $answerCoordinates = array();
                        $solutionDirections = array();
                    }
                    $counter++;
                    array_push($solutionDirections, $horizontal[$dir]);
                    if ($counter >= count($data['char_bank'])){
                        $keepGoing = FALSE;
                    }
                    array_push($answerCoords, $coords);
                } // end while
            break;           

            case "vertical":
                while($keepGoing){
                    $dir = rand(0, 1);
                    $result = addWord($data['char_bank'][$counter], $vertical[$dir], $data);
                    if ($result == FALSE){
                        $keepGoing = FALSE;
                        $itWorked = FALSE;
                        $answerCoordinates = array();
                        $solutionDirections = array();
                    }
                    $counter++;
                    array_push($solutionDirections, $vertical[$dir]);
                    if ($counter >= count($data['char_bank'])){
                        $keepGoing = FALSE;
                    }
                    array_push($answerCoords, $coords);
                }
                break;
    
            case "diagonal":
                while($keepGoing){
                    $dir = rand(0, 3);
                    $result = addWord($data['char_bank'][$counter], $diagonal[$dir], $data);
                    if ($result == FALSE){
                        $keepGoing = FALSE;
                        $itWorked = FALSE;
                        $answerCoordinates = array();
                        $solutionDirections = array();
                    }
                    $counter++;
                    array_push($solutionDirections, $diagonal[$dir]);
                    if ($counter >= count($data['char_bank'])){
                        $keepGoing = FALSE;
                    }
                    array_push($answerCoords, $coords);
                }
                break;    
       }
    return $itWorked;
    } // end fillBoard

    function addWord($theWord, $dir, $data){
        global $board, $answerCoordinates, $coords;
        $answerCoordinates = array();
        $coords = array();
        $itWorked = TRUE;

        //attempt to add a word to the board or return false if failed
        switch ($dir){
            case "E":
                //col from 0 to board width - word width
                //row from 0 to board height
                $newCol = rand(0, $data['width'] - 1 - sizeof($theWord));
                $newRow = rand(0, $data['height'] - 1);
                for($i = 0; $i < sizeof($theWord); $i++){
                    //new character same row, initial column + $i
                    $boardLetter = $board[$newRow][$newCol + $i];
                    $wordLetter = $theWord[$i];
                    //check for legal values in current space on board
                    if($data['share_chars']){
                        if(($boardLetter == $wordLetter) || ($boardLetter == ".")){
                            $board[$newRow][$newCol + $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    } else {
                        if(($boardLetter == ".")){
                            $board[$newRow][$newCol + $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    // Push the coordinate to local coords array
                    $coord = array($newRow, $newCol + $i);
                    array_push($coords, $coord);
                } // end for loop
                break;

            case "W":
                $newCol = rand(sizeof($theWord), $data['width'] - 1);
                $newRow = rand(0, $data['height'] - 1);
                for($i = 0; $i < sizeof($theWord); $i++){
                    $boardLetter = $board[$newRow][$newCol - $i];
                    $wordLetter = $theWord[$i];
                    if($data['share_chars']){
                        if (($boardLetter == $wordLetter) || ($boardLetter == ".")){
                            $board[$newRow][$newCol - $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    } else {
                        if (($boardLetter == ".")){
                            $board[$newRow][$newCol - $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow,$newCol -$i);
                    array_push($coords, $coord);
                }
                break;

            case "S":
                $newCol = rand(0, $data['width'] -1);
                $newRow = rand(0, $data['height'] -1 - sizeof($theWord));
                for($i = 0; $i < sizeof($theWord); $i++){
                    $boardLetter = $board[$newRow + $i][$newCol];
                    $wordLetter = $theWord[$i];
                    if($data['share_chars']){
                        if (($boardLetter == $wordLetter) || ($boardLetter == ".")){
                            $board[$newRow + $i][$newCol] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    } else {
                        if (($boardLetter == ".")){
                            $board[$newRow + $i][$newCol] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow + $i, $newCol );
                    array_push($coords, $coord);
                }
                break;

            case "N":
                $newCol = rand(0, $data['width'] - 1);
                $newRow = rand(sizeof($theWord), $data['height']-1);
                for ($i = 0; $i < sizeof($theWord); $i++){
                    $boardLetter = $board[$newRow - $i][$newCol];
                    $wordLetter = $theWord[$i];
                    if($data['share_chars']){
                        if (($boardLetter == $wordLetter) || ($boardLetter == ".")){
                            $board[$newRow - $i][$newCol] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    } else {
                        if (($boardLetter == ".")){
                            $board[$newRow - $i][$newCol] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow - $i, $newCol);
                    array_push($coords, $coord);
                }
                break;

            case "NE":
                $newCol = rand(0,$data['width']- 1 - sizeof($theWord));
                $newRow = rand(sizeof($theWord), $data['height'] - 1);
                for($i = 0; $i < sizeof($theWord) ; $i++){
                    $boardLetter = $board[$newRow-$i][$newCol + $i];
                    $wordLetter = $theWord[$i];
                    if($data['share_chars']){
                        if(($boardLetter == $wordLetter) ||
                            ($boardLetter == ".")){
                            $board[$newRow-$i][$newCol + $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }else{
                        if(($boardLetter == ".")){
                            $board[$newRow-$i][$newCol + $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow - $i, $newCol + $i);
                    array_push($coords, $coord);
                }
                break;

            case "NW":
                $newCol = rand(sizeof($theWord), $data['width'] - 1);
                $newRow = rand(sizeof($theWord), $data['height'] - 1);
                for($i = 0; $i < sizeof($theWord); $i++){
                    $boardLetter = $board[$newRow-$i][$newCol - $i];
                    $wordLetter = $theWord[$i];
                    if($data['share_chars']){
                        if(($boardLetter == $wordLetter) || ($boardLetter == ".")){
                            $board[$newRow-$i][$newCol - $i] = $wordLetter;
                        } else{
                            $itWorked = FALSE;
                        }
                    }else{
                        if(($boardLetter == ".")){
                            $board[$newRow-$i][$newCol - $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow - $i, $newCol - $i);
                    array_push($coords, $coord);
                }
                break;

            case "SE":
                $newCol = rand(0,$data['width'] - 1 - sizeof($theWord));
                $newRow = rand(0,$data['height'] - 1 - sizeof($theWord));
                for($i = 0; $i < sizeof($theWord) ; $i++){
                    $boardLetter = $board[$newRow+$i][$newCol + $i];
                    $wordLetter = $theWord[$i];
    
                    if($data['share_chars']){
                        if(($boardLetter == $wordLetter) || ($boardLetter == ".")){
                                $board[$newRow+$i][$newCol + $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    } else {
                        if(
                            ($boardLetter == ".")){
                            $board[$newRow+$i][$newCol + $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow + $i,$newCol +$i);
                    array_push($coords,$coord);
                }
                break;

            case "SW":
                $newCol = rand(sizeof($theWord),$data['width']- 1);
                $newRow = rand(0,$data['height']- sizeof($theWord)-1);
                for($i = 0; $i < sizeof($theWord);$i++) {
                    $boardLetter = $board[$newRow + $i][$newCol - $i];
                    $wordLetter = $theWord[$i];
                    if ($data['share_chars']) {
                        if (($boardLetter == $wordLetter) || ($boardLetter == ".")) {
                            $board[$newRow + $i][$newCol - $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    } else {
                        if(($boardLetter == ".")){
                            $board[$newRow + $i][$newCol - $i] = $wordLetter;
                        } else {
                            $itWorked = FALSE;
                        }
                    }
                    $coord = array($newRow + $i, $newCol - $i);
                    array_push($coords, $coord);
                }
                break;
        }
        // Push the coordinates of the word if it was successful
        if($itWorked){
            // push from local to globa
            $coords = $coords;
        }
        return $itWorked;

    } // end addWord


    function parseList($data){
        //gets word list, creates array of words from it
        //or return false if impossible
        $data['generate_board'] = TRUE;
        //Check to see if word will fit
        foreach($data['char_bank'] as $wordIndexArray) {
            echo "\n";
            $processor = new wordProcessor($wordIndexArray);
            $wordIndex = $processor->parseToLogicalChars($wordIndexArray,$data['language']);
    
            //stop if any words are too long to fit in puzzle
            if(sizeof($wordIndex) > $data['height'] && sizeof($wordIndex) > $data['width']){
                $data['error'] = 'At least one of the words in your word bank is too large for the specified dimensions. Please adjust grid dimensions.';
                $data['generate_board'] = FALSE;
            
            
                // if ((sizeof($wordIndex) > $data['width']) && (sizeof($wordIndex) > $data['height'])) {
                // print "$wordIndex is too long for puzzle";
                // print "Please increase the grid size in previous page and try again";
                // $data['generate_board'] = FALSE;
            } // end if
        }
        
        return $data;
    } // end parseList

    // add extra letters //
    function addFoils($data){
        $fillerChars = $data['filler_char_types'];
        // $fillerChars1 = $_GET['fillerTypes'];;
        //add random dummy characters to board
        $language = $data['language'];
        global $board;
        $myfile = fopen("indic-wp/telugu_seed.txt", "r") or die("Unable to open file!");
        // echo fread($myfile,filesize("indic-wp/telugu_seed.txt"));
        $lines = array();
        $word = array();
        $Vowels = array();
        $constants = array();
        $vowelMixers = array();
        $singleConstantBlends = array();
        $doubleConstantBlends = array();
        $tripleConstantBlends = array();
        $constantBlendsAndVowels = array();
        $any = array();

        while (!feof($myfile)){
            $line = fgets($myfile);
            //$lines = explode("\n", $line);
            $lines[] = $line;
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
            if(in_array("Vowels", $word)){
                $Vowels[]=$word[1];
            } elseif(in_array("Consonants", $word)){
                $constants[]=$word[1];
            } elseif(in_array("VOWELMIXERS", $word)){
                $vowelMixers[]=$word[1];
            } elseif(in_array("SINGLECONSONANTBLENDS", $word)){
                $singleConstantBlends[]=$word[1];
            } elseif(in_array("DOUBLECONSONANTBLENDS", $word)){
                $doubleConstantBlends[]=$word[1];
            } elseif(in_array("TRIPLECONSONANTBLENDS", $word)){
                $tripleConstantBlends[]=$word[1];
            } elseif(in_array("CONSONANTBLENDSANDVowels", $word)){
                $constantBlendsAndVowels[]=$word[1];
            }
            //echo " second word " . $word[1] . "<br>";
        }

        // foreach($any as $v){
        //     echo "the vowel is " .  $v . "<br>";
        // }
        // foreach($constants as $v){
        //     echo "the constant is " .  $v . "<br>";
        // }

        $any = array_merge($Vowels, $constants, $vowelMixers, $singleConstantBlends, $doubleConstantBlends, $tripleConstantBlends, $constantBlendsAndVowels);
        //foreach($any as $v){
        //        echo "the constant is " .  $v . "<br>";
        //}
        //echo "I like " . $Vowels[0] . ", " . $Vowels[1] . " and " . $Vowels[2] . ".";
        //echo $fillerChars;
        //echo $fillerChars1;
        fclose($myfile);

        switch($language){
            case "English":
                for($row = 0; $row < $data["height"]; $row++){
                    for($col = 0; $col < $data["width"]; $col++){
                        if($board[$row][$col] == "."){
                            $validChar = false;
                            while(!$validChar){
                                $english_char = "";
                                $startHex = "0x0041";
                                $endHex = "0x005A";
                                $num = rand(hexdec($startHex), hexdec($endHex));
                                $hexcode = dechex($num);
                                if($hexcode == 0x004F){
                                    continue;
                                }

                                if($fillerChars == "Consonants"){
                                    if(isCharVowel($hexcode, $language)){
                                        continue;
                                    }
                                    $english_char .= sprintf("\\u%'04s", dechex($num));
                                    if(json_decode('"' . $english_char . '"') == "O"){
                                        continue;
                                    }
                                    $board[$row][$col] = json_decode('"' . $english_char . '"');
                                    $validChar = true;
                                } elseif($fillerChars == "Vowels"){
                                    if(isCharConsonant($hexcode,$language)){
                                        continue;
                                    }
                                    $english_char .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $english_char . '"');
                                    $validChar = true;
                                } else {
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
                for($row = 0; $row < $data["height"]; $row++){
                    for($col = 0; $col < $data["width"]; $col++){
                        if($board[$row][$col] == "."){
                            //Make sure the character is valid
                            $validChar = false;
                            while(!$validChar){
                                $telugu_char = "";
                                $startHex = "0x0c05";
                                $endHex = "0x0c39";
                                $num = rand(hexdec($startHex), hexdec($endHex));
                                $hexcode = dechex($num);
                                // var_dump($hexcode);

                                if(is_blank_Telugu($hexcode)){
                                    continue;
                                } elseif($fillerChars == "Consonants"){
                                    // if(isCharVowel($hexcode,$language)){
                                    //    continue;
                                    // }
                                    $k = array_rand($constants);
                                    $telugu_char .= $constants[$k];
                                    $board[$row][$col] = $telugu_char;
                                    $validChar = true;
                                } elseif($fillerChars == "Vowels"){
                                    // if(isCharConsonant($hexcode,$language)){
                                    //     continue;
                                    // }
                                    $k = array_rand($Vowels);
                                    $telugu_char .= $Vowels[$k];
                                    $board[$row][$col] = $telugu_char;
                                    $validChar = true;
                                } elseif($fillerChars == "SCB"){
                                    // $telugu_char .= sprintf("\\u%'04s", dechex($num));
                                    // $board[$row][$col] = json_decode('"' . $telugu_char . '"');
                                    // $validChar = true;
                                    $k = array_rand($singleConstantBlends);
                                    $telugu_char .= $singleConstantBlends[$k];
                                    $board[$row][$col] = "  " . $telugu_char . "  ";
                                    $validChar = true;
                                } elseif($fillerChars == "DCB"){
                                    // $telugu_char .= sprintf("\\u%'04s", dechex($num));
                                    // $board[$row][$col] = json_decode('"' . $telugu_char . '"');
                                    // $validChar = true;
                                    $k = array_rand($doubleConstantBlends);
                                    $telugu_char .= $doubleConstantBlends[$k];
                                    $board[$row][$col] = "  " . $telugu_char . "  ";
                                    $validChar = true;
                                } elseif($fillerChars == "TCB"){
                                    // $telugu_char .= sprintf("\\u%'04s", dechex($num));
                                    // $board[$row][$col] = json_decode('"' . $telugu_char . '"');
                                    // $validChar = true;
                                    $k = array_rand($tripleConstantBlends);
                                    $telugu_char .= $tripleConstantBlends[$k];
                                    $board[$row][$col] = "  " . $telugu_char . "  ";
                                    $validChar = true;
                                } elseif($fillerChars == "CDV"){
                                    // $telugu_char .= sprintf("\\u%'04s", dechex($num));
                                    // $board[$row][$col] = json_decode('"' . $telugu_char . '"');
                                    // $validChar = true;
                                    $k = array_rand($constantBlendsAndVowels);
                                    $telugu_char .= $constantBlendsAndVowels[$k];
                                    $board[$row][$col] = "  " . $telugu_char . "  ";
                                    $validChar = true;
                                } else{
                                    // $telugu_char .= sprintf("\\u%'04s", dechex($num));
                                    // $board[$row][$col] = json_decode('"' . $telugu_char . '"');
                                    // $validChar = true;
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
                for ($row = 0; $row < $data["height"]; $row++){
                    for ($col = 0; $col < $data["width"]; $col++){
                        if ($board[$row][$col] == "."){
                            //Make sure the character is valid
                            $validChar = false;
                            while(!$validChar){
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
                                } elseif($fillerChars == "Vowels"){
                                    if(isCharConsonant($hexcode,$language)){
                                        continue;
                                    }
                                    $hindi_char .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $hindi_char . '"');
                                    $validChar = true;
                                } else {
                                    $hindi_char .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $hindi_char . '"');
                                    $validChar = true;
                                }
                            }
                        } // end if
                    } // end col for loop
                } // end row for loop
                break;

            case "Gujarati":
                for ($row = 0; $row < $data["height"]; $row++){
                    for ($col = 0; $col < $data["width"]; $col++){
                        if ($board[$row][$col] == "."){
                            //Make sure the character is valid
                            $validChar = false;
                            while(!$validChar){
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
                                }elseif($fillerChars == "Consonants"){
                                    if(isCharVowel($hexcode,$language)){
                                        continue;
                                    }
                                    $gujarati_char  .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $gujarati_char  . '"');
                                    $validChar = true;
                                } elseif($fillerChars == "Vowels"){
                                    if(isCharConsonant($hexcode,$language)){
                                        continue;
                                    }
                                    $gujarati_char  .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $gujarati_char  . '"');
                                    $validChar = true;
                                }else{
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
                for ($row = 0; $row < $data["height"]; $row++){
                    for ($col = 0; $col < $data["width"]; $col++){
                        if ($board[$row][$col] == "."){
                            //Make sure the character is valid
                            $validChar = false;
                            while(!$validChar){
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
                                } elseif($fillerChars == "Consonants"){
                                    if(isCharVowel($hexcode,$language)){
                                        continue;
                                    }
                                    $malay_char .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $malay_char. '"');
                                    $validChar = true;
                                }elseif($fillerChars == "Vowels"){
                                    if(isCharConsonant($hexcode,$language)){
                                        continue;
                                    }
                                    $malay_char .= sprintf("\\u%'04s", dechex($num));
                                    $board[$row][$col] = json_decode('"' . $malay_char. '"');
                                    $validChar = true;
                                }else{
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

    function is_blank_Telugu($hexVal){
        $is_blank = false;
        $blankArray = array("c00","c01","c02","c03","c0d","c11","c29","c34");
        if(in_array($hexVal, $blankArray)){
            return true;
        }
        return $is_blank;
    }

    function is_blank_Gujarati($hexVal){
        {
            $is_blank = false;
            $blankArray = array("a8e","a92","aa9","ab1","ab4","ac6","aca","aba","abb","a84");
            if(in_array($hexVal, $blankArray)){
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
            if(in_array($hexVal, $blankArray)){
                return true;
            }
            return $is_blank;
        }
    }

    function addSolution($data){
        $counter = 0;
    
        foreach($data['answer_coordinates'] as $wordCoord){
                $id = "sol" . $counter;
        
            if($wordCoord == null){
                continue;
            }

            $begCoord = "".$wordCoord[0][0] ."".$wordCoord[0][1]."";
            $length = getSolutionLength($wordCoord[0][0], $wordCoord[0][1], $wordCoord[sizeof($wordCoord) - 1][0], $wordCoord[sizeof($wordCoord) - 1][1]);

            $direction = getDirection($data['solution_directions'][$counter]);
            addRectangle($id, $begCoord, $direction, $length);
            $counter++;
        }
    }

    function getSolutionLength($beginRow, $beginCol, $endRow, $endCol){

        $adjustedLength = 0;
        $oneChar = 0.5;
        $multiplier = 55;
        $lengthIncreaser = 1.4;
        $lengthFactor = 0.35;

        $length = sqrt(pow($endRow - $beginRow, 2) + pow($endCol - $beginCol, 2));
    
        if($beginRow == $endRow && $beginCol == $endCol){
            $length = $oneChar;
        }

        if($length > $oneChar && $length < 5){
            $adjustedLength = round($length * ($multiplier * ((($lengthIncreaser / $length) * $lengthFactor) + 1)));
        } else {
            $adjustedLength = round($length * $multiplier);
        }
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

    function addRectangle($rectID, $beginCoord, $direction, $length){

        echo "<div class='rectangle' id='" . $rectID . "'></div>";
        echo "<script type='text/javascript' >changeCSS('" . $rectID ."', '". $beginCoord ."', ". $direction .", ". $length .");";
        echo "var rect = ['" . $rectID ."', '" . $beginCoord ."', " . $direction .", " . $length . "];";
        echo "console.log(rect);";
        echo "rectangles.push(rect);</script>";
    
    }

    // save generated puzzle to db
    function savePuzzle($pdo, $data, $wordBank){
        $sql = 'INSERT INTO categories(cat_name)
        SELECT * FROM (SELECT :cat_name) AS temp
        WHERE NOT EXISTS (SELECT cat_name FROM categories WHERE cat_name = :cat_name);
        SELECT *, @cat_exists:=cat_id FROM categories WHERE cat_name = :cat_name;
                        SET @cat_id = CASE
                        WHEN @cat_exists THEN @cat_exists
                        ELSE LAST_INSERT_ID()
                        END;
        INSERT INTO puzzles(cat_id, title, description, author_id, language, word_direction, height, width, share_chars, filler_char_types, word_bank)
        VALUES (@cat_id, :title, :description, :author_id, :language, :word_direction, :height, :width, :share_chars, :filler_char_types, :word_bank);';

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cat_name' => $data['cat_name'],
                           'title' => $data['title'],
                     'description' => $data['description'],
                       'author_id' => $data['author_id'],
                        'language' => $data['language'],
                  'word_direction' => $data['word_direction'],
                          'height' => $data['height'],
                           'width' => $data['width'],
                     'share_chars' => $data['share_chars'],
               'filler_char_types' => $data['filler_char_types'],
                       'word_bank' => serialize($wordBank)]);
        header('location:index.php');
    }