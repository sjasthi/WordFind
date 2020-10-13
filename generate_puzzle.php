<?php 

    include 'includes/header.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $catName         = $_POST['category'];
        $title           = $_POST['title'];
        $description     = $_POST['description'];
        $author          = $_POST['author'];
        $createdOn       = $_POST['created_on'];
        $language        = $_POST['language'];
        $wordDirection   = $_POST['word_direction'];
        $height          = $_POST['height'];
        $width           = $_POST['width'];
        $shareChars      = $_POST['share_chars'];
        $fillerCharTypes = $_POST['filler_char_types'];
        $wordBank        = $_POST['word_bank'];

        // break string into array
        $wordBank = explode("\n", $wordBank);

        $rawWordBank = [];

        foreach($wordBank as $word){
          // remove trailing newline chars
          $word = rtrim($word);
          if($language === 'English'){
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
          $logChars = $wordProcessor->parseToLogicalChars($word, $language);

          foreach($logChars as $singleChar){
            if($singleChar === " "){
                $singleChar = "";
            }
          }
            array_push($charBank, $logChars);
        }

        $sql = 'INSERT INTO categories(cat_name)
                SELECT * FROM (SELECT :cat_name) AS temp
                WHERE NOT EXISTS (SELECT cat_name FROM categories WHERE cat_name = :cat_name);

                SELECT *, @cat_exists:=cat_id FROM categories WHERE cat_name = :cat_name;
                              SET @cat_id = CASE
                                WHEN @cat_exists THEN @cat_exists
                                ELSE LAST_INSERT_ID()
                              END;
                INSERT INTO puzzles(cat_id, title, description, author, created_on, language, word_direction, height, width, share_chars, filler_char_types, word_bank)
                VALUES (@cat_id, :title, :description, :author, :created_on, :language, :word_direction, :height, :width, :share_chars, :filler_char_types, :word_bank);';

                $stmt = $pdo->prepare($sql);
                $stmt->execute(['cat_name' => $catName,
                                   'title' => $title,
                             'description' => $description,
                                  'author' => $author,
                              'created_on' => $createdOn,
                                'language' => $language,
                          'word_direction' => $wordDirection,
                                  'height' => $height,
                                    'width'=> $width,
                              'share_chars'=> $shareChars,
                        'filler_char_types'=> $fillerCharTypes,
                                'word_bank'=> serialize($charBank)]);
    }

?>

</div>

<?php header('location:index.php');  ?>