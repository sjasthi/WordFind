<?php

    function getPuzzleById($pdo, $puzzleId){
        $sql = 'SELECT * FROM puzzles
                INNER JOIN categories
                ON categories.cat_id = puzzles.cat_id
                WHERE puzzle_id = :puzzle_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['puzzle_id' => $puzzleId]);
        return $stmt->fetchAll();
    }

    function getCategoriesWithTopNResults($pdo){
        $sql = "SELECT cat_name, categories.cat_id,
                SUBSTRING_INDEX(GROUP_CONCAT(puzzles.title ORDER BY puzzles.puzzle_id DESC), ',', 5) AS puzzle_names, -- show top 5 results --
                SUBSTRING_INDEX(GROUP_CONCAT(puzzles.puzzle_id ORDER BY puzzles.puzzle_id DESC), ',', 5) AS puzzle_ids -- id top 5 results --
                FROM puzzles
                INNER JOIN categories
                ON categories.cat_id = puzzles.cat_id
                GROUP BY categories.cat_name
                ORDER BY categories.cat_id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getCategoryById($categoryId, $pdo){
        $sql = "SELECT cat_name, puzzle_id, title, description, first_name, last_name, created_on
                FROM puzzles
                LEFT JOIN categories
                ON categories.cat_id = puzzles.cat_id
                INNER JOIN users
                ON users.user_id = puzzles.user_id
                WHERE puzzles.cat_id = :category_id
        ";
            
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll();
    }

    function getTableHeader($data){
        $letters = [];
        for($x = 'A'; $x <= 'ZZ'; $x++){
            array_push($letters, $x);
        }
        $letters = array_slice($letters, 0, $data['width']);
        // add 0 to the corner of the table
        array_unshift($letters, 0);
        
        return $letters;
        
    }

    function setControlCookies(){
        
        $expire = time() + (86400 * 7); // 7 days

        if(isset($_POST['toggle_borders'])){
            setcookie('borders', $_POST['toggle_borders'], $expire);
            $_COOKIE['borders'] = $_POST['toggle_borders'];
        }

        if(isset($_POST['toggle_labels'])){
            setcookie('labels', $_POST['toggle_labels'], $expire);
            $_COOKIE['labels'] = $_POST['toggle_labels'];
        }

        if(isset($_POST['toggle_solution_lines'])){
            setcookie('solution_lines', $_POST['toggle_solution_lines'], $expire);
            $_COOKIE['solution_lines'] = $_POST['toggle_solution_lines'];
        }

        if(isset($_POST['toggle_word_list'])){
            setcookie('word_list', $_POST['toggle_word_list'], $expire);
            $_COOKIE['word_list'] = $_POST['toggle_word_list'];
        }
    }

    function updatePuzzle($pdo, $data, $puzzleId){

         // Sanitize POST data
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $sql = 'INSERT INTO categories(cat_name)
        SELECT * FROM (SELECT :cat_name) AS temp
        WHERE NOT EXISTS (SELECT cat_name FROM categories WHERE cat_name = :cat_name);
        SELECT *, @cat_exists:=cat_id FROM categories WHERE cat_name = :cat_name;
                        SET @cat_id = CASE
                        WHEN @cat_exists THEN @cat_exists
                        ELSE LAST_INSERT_ID()
                        END;

        UPDATE puzzles
        SET cat_id = @cat_id, title = :title, description = :description, language = :language, word_direction = :word_direction, height = :height, width = :width, share_chars = :share_chars, filler_char_types = :filler_char_types, char_bank = :char_bank, word_bank = :word_bank, board = :board, solution_directions = :solution_directions, answer_coordinates = :answer_coordinates
        WHERE puzzle_id = :puzzle_id;
        DELETE categories
        FROM categories
        LEFT JOIN puzzles
        ON categories.cat_id = puzzles.cat_id
        WHERE puzzles.cat_id IS NULL; -- del category if category contains no other puzzles
        ';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'puzzle_id'           => $puzzleId,
            'cat_name'            => trim($_POST['cat_name']),
            'title'               => trim($_POST['title']),
            'description'         => trim($_POST['description']),
            'language'            => $data['language'],
            'word_direction'      => $data['word_direction'],
            'height'              => $data['height'],
            'width'               => $data['width'],
            'share_chars'         => $data['share_chars'],
            'filler_char_types'   => $data['filler_char_types'],
            'char_bank'           => json_encode($data['char_bank'], JSON_UNESCAPED_UNICODE),
            'word_bank'           => json_encode($data['word_bank'], JSON_UNESCAPED_UNICODE),
            'board'               => json_encode($data['board'], JSON_UNESCAPED_UNICODE),
            'solution_directions' => json_encode($data['solution_directions']),
            'answer_coordinates'  => json_encode($data['answer_coordinates'])
        ]);

        unset($_SESSION['newData']);
        header("location:puzzle.php?puzzleId={$puzzleId}");

    }

    function deletePuzzle($pdo, $puzzleId){
        $sql = 'DELETE FROM puzzles WHERE puzzle_id = :puzzle_id; -- del puzzle

                DELETE categories
                FROM categories
                LEFT JOIN puzzles
                ON categories.cat_id = puzzles.cat_id
                WHERE puzzles.cat_id IS NULL; -- del category if category contains no other puzzles
        ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['puzzle_id' => $puzzleId]);
        redirect('index.php');
    }

    function search($pdo){

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'query' => trim($_POST['query']),
        ];

        $sql = "SELECT categories.cat_id, puzzle_id, cat_name, title, description, created_on, users.first_name, users.last_name
                FROM puzzles
                INNER JOIN categories
                ON puzzles.cat_id = categories.cat_id
                INNER JOIN users
                ON users.user_id = puzzles.user_id
                WHERE cat_name LIKE '%' :query '%'
                OR title LIKE '%' :query '%'
                OR users.first_name LIKE '%' :query '%'
                OR users.last_name LIKE '%' :query '%'
                OR CONCAT(users.first_name, ' ', users.last_name) LIKE '%' :query '%'
                OR created_on LIKE '%' :query '%'
                ORDER BY categories.cat_id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':query' => $data['query']]);
        return $stmt->fetchAll();
    }

    function generatePuzzle(){
        
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'cat_name'          => trim($_POST['cat_name']),
            'title'             => trim($_POST['title']),
            'description'       => trim($_POST['description']),
            'user_id'           => $_SESSION['user_id'],
            'language'          => $_POST['language'],
            'word_direction'    => $_POST['word_direction'],
            'height'            => trim($_POST['height']),
            'width'             => trim($_POST['width']),
            'share_chars'       => $_POST['share_chars'],
            'filler_char_types' => $_POST['filler_char_types'],
            'word_bank'         => trim($_POST['word_bank']),
            'generate_board'    => TRUE
        ];

        // replace commas with newline char
        $data['word_bank'] = str_replace(",","\n",$data['word_bank']);
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

        unset($data['word_bank']);
        $data['word_bank'] = [];
        
        $charBank = [];
        foreach($rawWordBank as $word){

            array_push($data['word_bank'], $word);
            $wordProcessor = new wordProcessor($word);

            // get logical chars of word
            $logChars = $wordProcessor->parseToLogicalChars($word, $data['language']);
            
            // remove spaces
           if($data['language'] == 'Hindi'){
                $logChars = stripSpacesHindi($logChars);
            } else if($data['language'] == 'Gujarati'){
                $logChars = stripSpacesGujarati($logChars);
            } else if($data['language'] == 'Malayalam'){
                $logChars = stripSpacesMalayalam($logChars);
            } else {
                $logChars = stripSpacesTelugu($logChars);
            }

            array_push($charBank, $logChars);
            

            if(sizeof($logChars) == 0){
                $data['error'] = 'Might want to check the word bank!';
                $data['generate_board'] = FALSE;
            } 
            
            if(sizeof($logChars) + 1 > $data['height'] || sizeof($logChars) + 1 > $data['width']){
                $data['error'] = 'You need to make your grid dimensions bigger!';
                $data['generate_board'] = FALSE;
            }
            

        } // end foreach

        if($data['generate_board']){
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
            }
        }

        return $data;
        
    }

// save generated puzzle to db
function savePuzzle($pdo, $data){

     // Sanitize POST data
     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $sql = 'INSERT INTO categories(cat_name)
    SELECT * FROM (SELECT :cat_name) AS temp
    WHERE NOT EXISTS (SELECT cat_name FROM categories WHERE cat_name = :cat_name); -- cat !exist
    SELECT *, @cat_exists:=cat_id FROM categories WHERE cat_name = :cat_name; -- cat exists
                    SET @cat_id = CASE
                    WHEN @cat_exists THEN @cat_exists -- set id to existing cat
                    ELSE LAST_INSERT_ID() -- new cat created, use last inserted id
                    END;
    INSERT INTO puzzles(cat_id, title, description, user_id, language, word_direction, height, width, share_chars, filler_char_types, char_bank, word_bank, board, solution_directions, answer_coordinates)
    VALUES (@cat_id, :title, :description, :user_id, :language, :word_direction, :height, :width, :share_chars, :filler_char_types, :char_bank, :word_bank, :board, :solution_directions, :answer_coordinates);';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'cat_name'            => trim($_POST['cat_name']),
        'title'               => trim($_POST['title']),
        'description'         => trim($_POST['description']),
        'user_id'             => $data['user_id'],
        'language'            => $data['language'],
        'word_direction'      => $data['word_direction'],
        'height'              => $data['height'],
        'width'               => $data['width'],
        'share_chars'         => $data['share_chars'],
        'filler_char_types'   => $data['filler_char_types'],
        'char_bank'           => json_encode($data['char_bank'], JSON_UNESCAPED_UNICODE),
        'word_bank'           => json_encode($data['word_bank'], JSON_UNESCAPED_UNICODE),
        'board'               => json_encode($data['board'], JSON_UNESCAPED_UNICODE),
        'solution_directions' => json_encode($data['solution_directions']),
        'answer_coordinates'  => json_encode($data['answer_coordinates'])
    ]);

    unset($_SESSION['data']);

    $sql = 'SELECT max(puzzle_id) AS id FROM puzzles';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $id = $stmt->fetchAll();

    foreach($id as $id){

        $data = [
            'id' => $id->id
        ];
    }
    
    header("location:puzzle.php?puzzleId={$data['id']}");
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
                    if ($result == FALSE){
                        $keepGoing = FALSE;
                        $itWorked = FALSE;
                        $answerCoordinates = array();
                        $solutionDirections = array();
                    }
                    $counter++;
                    array_push($solutionDirections, $allDirections[$dir]);
                    if ($counter >= count($data['char_bank'])){
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
                }
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
                // echo $newRow;
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
                    } else {
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

    function addSolution($data){
        $counter = 0;
        foreach($data['answer_coordinates'] as $wordCoord){

            $begCoord = "r". $wordCoord[0][0] . "c". $wordCoord[0][1] . "";

            $direction = getDirection($data['solution_directions'][$counter]);
            $language = $data['language'];
            $length = getSolutionLength($wordCoord[0][0], $wordCoord[0][1], $wordCoord[sizeof($wordCoord) - 1][0], $wordCoord[sizeof($wordCoord) - 1][1], $direction, $language);

            highlightSolution($begCoord, $direction, $length, $language);

            $counter++;
        }
    }

    function getSolutionLength($beginRow, $beginCol, $endRow, $endCol, $direction, $language){
        
        $tdWidth = 50;
        if($language != 'English'){
            $tdWidth = 60;
        }

        if($direction == 1){ // E
            $length = ($endCol-$beginCol + 1) * $tdWidth;
        } elseif($direction == 2){ // W
            $length = ($beginCol-$endCol + 1) * $tdWidth;
        } elseif($direction == 3){ // S
            $length = ($endRow-$beginRow + 1) * $tdWidth;
        } elseif($direction == 4){ // N
            $length = ($beginRow-$endRow + 1) * $tdWidth;
        } else { // SE NW SW NE
            $length = (sqrt(pow($endRow - $beginRow, 2) + pow($endCol - $beginCol, 2)) + 1) * $tdWidth;
        }

        return $length;
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
                $retVal = 7;
        }
        return $retVal;
    }

    function highlightSolution($beginCoord, $direction, $length, $language){
        echo "<script type='text/javascript'>";
        echo "highlightSolution('" . $beginCoord ."', ". $direction .", ". $length . ",'" . $language ."');";
        echo "</script>";
    }