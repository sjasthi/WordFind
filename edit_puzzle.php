<?php 
    // check if user has access to this page
    include 'includes/puzzle_creation_access.php';

    $pageTitle = 'Word Find Puzzle Maker';
    include 'includes/header.php';

    reguser();

    $puzzleId = $_GET['id'];
    $puzzle = getPuzzleById($pdo,$puzzleId);

    // get current board
    foreach($puzzle as $puzzle){
        $data = [
            'puzzle_id'          => $puzzle->puzzle_id,
            'cat_name'           => $puzzle->cat_name,
            'title'              => $puzzle->title,
            'user_id'            => $puzzle->user_id,
            'description'        => $puzzle->description,
            'language'           => $puzzle->language,
            'word_direction'     => $puzzle->word_direction,
            'height'             => $puzzle->height,
            'width'              => $puzzle->width,
            'filler_char_types'  => $puzzle->filler_char_types,
            'share_chars'        => $puzzle->share_chars,
            'char_bank'          => json_decode($puzzle->char_bank),
            'word_bank'          => json_decode($puzzle->word_bank),
            'board'              => json_decode($puzzle->board),
            'answer_coordinates' => json_decode($puzzle->answer_coordinates),
            'solution_directions'=> json_decode($puzzle->solution_directions),
        ];
    }
    
    $letters = getTableHeader($data);
    $_SESSION['data'] = $data;
    $_SESSION['data']['generate_board'] = TRUE;

    // display board to user
    if(isset($_POST['generate_puzzle'])){
        $puzzle = generatePuzzle();
        $_SESSION['data'] = $puzzle;
        $_SESSION['newData'] = $_SESSION['data'];
        $letters = getTableHeader($_SESSION['data']);
    }

    // update board to db
    if(isset($_POST['update_puzzle'])){
        // any inputs that would effect the board
        if(isset($_SESSION['newData'])){
            $_SESSION['newData']['language'] = $_SESSION['newData']['language'];
            $_SESSION['newData']['word_direction'] = $_SESSION['newData']['word_direction'];
            $_SESSION['newData']['height'] = $_SESSION['newData']['height'];
            $_SESSION['newData']['width'] = $_SESSION['newData']['width'];
            $_SESSION['newData']['share_chars'] = $_SESSION['newData']['share_chars'];
            $_SESSION['newData']['filler_char_types'] = $_SESSION['newData']['filler_char_types'];
            $_SESSION['newData']['char_bank'] = $_SESSION['newData']['char_bank'];
            $_SESSION['newData']['word_bank'] = $_SESSION['newData']['word_bank'];
            $_SESSION['newData']['board'] = $_SESSION['newData']['board'];
            $_SESSION['newData']['answer_coordinates'] = $_SESSION['newData']['answer_coordinates'];
            $_SESSION['newData']['solution_directions'] = $_SESSION['newData']['solution_directions'];
        } else {
            $_SESSION['newData']['language'] = $_SESSION['data']['language'];
            $_SESSION['newData']['word_direction'] = $_SESSION['data']['word_direction'];
            $_SESSION['newData']['height'] = $_SESSION['data']['height'];
            $_SESSION['newData']['width'] = $_SESSION['data']['width'];
            $_SESSION['newData']['share_chars'] = $_SESSION['data']['share_chars'];
            $_SESSION['newData']['filler_char_types'] = $_SESSION['data']['filler_char_types'];
            $_SESSION['newData']['char_bank'] = $_SESSION['data']['char_bank'];
            $_SESSION['newData']['word_bank'] = $_SESSION['data']['word_bank'];
            $_SESSION['newData']['board'] = $_SESSION['data']['board'];
            $_SESSION['newData']['answer_coordinates'] = $_SESSION['data']['answer_coordinates'];
            $_SESSION['newData']['solution_directions'] = $_SESSION['data']['solution_directions'];
        }
            updatePuzzle($pdo, $_SESSION['newData'], $puzzleId);
    } else {
        preserveCache();
    }
?>

<div class="card mt-4">
    <h5 class="card-header">Puzzle Configurations</h5>
</div>

<?php if(isset($_POST['generate_puzzle']) && isset($puzzle['error'])): ?>

    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <strong>Oops!</strong> <?php echo $puzzle['error']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>
    <form action="" method="post">
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="category">Category</label>
                        <input type="text" name="cat_name" id="category" class="form-control" value="<?php echo (isset($_POST['cat_name'])) ? $_POST['cat_name'] : $data['cat_name']; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : $data['title'] ?>">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value="<?php echo (isset($_POST['description'])) ? $_POST['description'] : $data['description'] ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="language">Language</label>
                        <select name="language" id="language" class="form-control">

                        <?php
                        
                            $languages = ['Telugu', 'English', 'Hindi', 'Gujarati', 'Malayalam'];
                            foreach($languages as $language):
                        
                        ?>

                        <option value="<?php echo $language; ?>" <?php
                        
                            if($data['language'] == $language && (!isset($_POST['language']))){
                                echo 'selected';
                            }

                            if(isset($_POST['language']) && $_POST['language'] == $language){
                                echo 'selected';
                            }
                        
                        ?>><?php echo $language; ?></option>

                        <?php endforeach; // end languages ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="wordDirection">Word Direction</label>
                        <select name="word_direction" id="wordDirection" class="form-control">

                        <?php
                            $directions = [
                                'all'        => 'All Directions',
                                'horizontal' => 'Horizontal',
                                'vertical'   => 'Vertical',
                                'diagonal'   => 'Diagonal'
                            ];

                            foreach($directions as $key => $direction):
                        ?>

                            <option value="<?php echo $key; ?>" <?php
                            
                                if($data['word_direction'] == $key && (!isset($_POST['word_direction']))){
                                    echo 'selected';
                                }

                                if(isset($_POST['word_direction']) && $_POST['word_direction'] == $key){
                                    echo 'selected';
                                }
                                
                            ?>><?php echo $direction; ?></option>
                            <?php endforeach; // end directions ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Height</label>
                        <input type="number" name="height" id="height" min="5" max="702" value="<?php echo (isset($_POST['height'])) ? $_POST['height'] : $data['height'] ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="width">Width</label>
                        <input type="number" name="width" id="width" min="5" max="702" value="<?php echo (isset($_POST['width'])) ? $_POST['width'] : $data['width'] ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Share Characters</label>
                        <select name="share_chars" id="sharechars" class="form-control">
                        <?php
                            $shareChars = [
                                        '1' => 'Yes',
                                        '0' => 'No'
                            ];

                            foreach($shareChars as $key => $boolean):
                        ?>

                            <option value="<?php echo $key; ?>" <?php
                            
                                if($data['share_chars'] == $key && (!isset($_POST['share_chars']))){
                                    echo 'selected';
                                }

                                if(isset($_POST['share_chars']) && $_POST['share_chars'] == $key){
                                    echo 'selected';
                                }
                            
                            ?>><?php echo $boolean; ?></option>

                            <?php endforeach; // end shareChars ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="filler_char_types">Filler Character Types</label>
                        <select name="filler_char_types" id="fillerCharTypes" class="form-control">

                        <?php
                            $charTypes = [
                                'Any'        => 'Any',
                                'Consonants' => 'Consonants',
                                'Vowels'     => 'Vowels',
                                'VM'         => 'Vowel Mixers',
                                'SCB'        => 'Consonant Blends',
                                'DCB'        => 'Double Consonant Blends',
                                'TCB'        => 'Triple Consonant Blends',
                                'CBV'        => 'Consonant Blends with Vowels',
                                'LFIW'       => 'Letters From Input Words'
                            ];

                            foreach($charTypes as $key => $type):
                        ?>

                            <option value="<?php echo $key; ?>" <?php
                            
                                if($data['filler_char_types'] == $key && (!isset($_POST['filler_char_types']))){
                                    echo 'selected';
                                }

                                if(isset($_POST['filler_char_types']) && $_POST['filler_char_types'] == $key){
                                    echo 'selected';
                                }
                            
                            ?>><?php echo $type; ?></option>

                        <?php endforeach; // end charTypes ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="wordBank">Word Bank</label>
                    <textarea class="form-control" rows="15" name="word_bank" id="wordBank"><?php
                    
                            if(isset($_POST['word_bank'])){
                                echo $_POST['word_bank'];
                            } else {
                                foreach($data['word_bank'] as $word){
                                    if($data['language'] == 'English'){
                                        echo strtolower($word) . "\n";
                                    } else {
                                        echo $word . "\n";
                                    }
                                    
                                }
                            }
                            
                    ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-row">
                    <?php if($_SESSION['data']['generate_board']): ?>




                    <?php // if(isset($_POST['generate_puzzle']) && $_SESSION['data']['generate_board']): ?>
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary form-control" type="submit" name="generate_puzzle">Generate Puzzle</button>
                    </div>

                    <div class="form-group col-md-6">
                        <button class="btn btn-success form-control" type="submit" name="update_puzzle">Update Puzzle</button>
                    </div>
                </div> <!-- end form-row -->
            </div> <!-- end col -->
        </div> <!-- end row -->

        <div class="card mt-4">
            <div class="card-header mt-1">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="toggle_borders" id="toggleBorders" checked>
                    <label class="custom-control-label" for="toggleBorders">borders</label>
                </div>

                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="toggle_labels" id="toggleLabels" checked>
                    <label class="custom-control-label" for="toggleLabels">Labels</label>
                </div>

                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="toggle_answers" id="toggleSolutionLines" checked>
                    <label class="custom-control-label" for="toggleSolutionLines">Answers</label>
                </div>
            </div>

    <div class="card-body d-flex justify-content-center">
        <div class="col-auto">
            <table>
                <tr>
                    <?php foreach($letters as $letter): ?>
                        <td class="rowLabel bg-success d-none"><?php echo $letter ?></td>
                    <?php endforeach; ?>
                </tr>
                
                <?php for($row = 0; $row < $_SESSION['data']['height']; $row++): ?>
                    <tr>
                        <td class="rowLabel bg-success d-none"><?php echo $row + 1; ?></td>
                    <?php for($col = 0; $col < $_SESSION['data']['width']; $col++): ?>
                        <td id="<?php echo 'r' . $row . 'c' . $col; ?>"><?php echo $_SESSION['data']['board'][$row][$col]; ?></td>       
                    <?php endfor;  // end col ?>
                    </tr>
                <?php endfor; // end row ?>
            </table>
        </div>
    </div>
</div>

    <?php else: // puzzle generated ?>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary form-control" type="submit" name="generate_puzzle">Generate Puzzle</button>
                    </div>
                </div> <!-- end form-row -->
            </div> <!-- end column -->
        </div> <!-- end row -->
    </form>

    <?php
        endif;
        if($_SESSION['data']['generate_board']){
            addSolution($_SESSION['data']);
        }

        include('includes/footer.php');
    ?>