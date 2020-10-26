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

    function createPuzzle($pdo){
        
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'cat_name'          => $_POST['category'],
            'title'             => $_POST['title'],
            'description'       => $_POST['description'],
            'author_id'         => 1, // will utilize logged in user in future iterations
            'language'          => $_POST['language'],
            'word_direction'    => $_POST['word_direction'],
            'height'            => $_POST['height'],
            'width'             => $_POST['width'],
            'share_chars'       => $_POST['share_chars'],
            'filler_char_types' => $_POST['filler_char_types'],
            'word_bank'         => $_POST['word_bank']
        ];

        // used to keep form input on create_puzzle.php if errors are found
        $_SESSION['cat_name'] = $data['cat_name'];
        $_SESSION['title'] = $data['title'];
        $_SESSION['description'] = $data['description'];
        $_SESSION['language'] = $data['language'];
        $_SESSION['word_direction'] = $data['word_direction'];
        $_SESSION['height'] = $data['height'];
        $_SESSION['width'] = $data['width'];
        $_SESSION['share_chars'] = $data['share_chars'];
        $_SESSION['filler_char_types'] = $data['filler_char_types'];
        $_SESSION['word_bank'] = $data['word_bank'];

        // break string into array
        $wordBank = explode("\n", $data['word_bank']);

        $rawWordBank = [];

        foreach($wordBank as $word){
            // remove trailing newline chars
            $word = rtrim($word);
            if($data['language'] === 'english'){
                $word = strtoupper($word);
            }

            // remove double instances of words
            if(!in_array($word, $rawWordBank)){
                array_push($rawWordBank, $word);
            }
            
        }

        $wordBank = [];
        foreach($rawWordBank as $word){
            $wordProcessor = new wordProcessor($word);

            // get logical chars of word
            $logChars = $wordProcessor->parseToLogicalChars($word, $data['language']);

            if(sizeof($logChars) > $data['height'] && sizeof($logChars) > $data['width']){

                $_SESSION['error'] = 'At least one of the words in your word bank is too large for the specified dimensions. Please adjust grid dimensions.';

                header('location:create_puzzle.php');
            } else {
                foreach($logChars as $singleChar){
                    if($singleChar === " "){
                        $singleChar = "";
                    }
                }
                array_push($wordBank, $logChars);
                
            }
        }
        
        // STILL NOT WORKING CORRECTLY - ADDING TO DB EVEN IF GRID SIZE IS SMALLER THAN LARGEST WORD BANK WORD
        insertPuzzleIntoDb($pdo, $data, $wordBank);

        $board = clearBoard($data);
       
    }
    
    
    function clearBoard($data){
        // init board w/ . . .
        $board = [];
        for($row = 0; $row < $data['height']; $row++){
            for($col = 0; $col < $data['width']; $col++){
                $board[$row][$col] = '.';
            }
        }

        return $board;
    }

    function insertPuzzleIntoDb($pdo, $data, $wordBank){
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