<?php 
    $page_title = 'Word Find Puzzle Maker';
    include 'includes/header.php';

    if(isset($_POST['generate_puzzle'])){
        $puzzle = generatePuzzle();
    }
    
?>

<div class="card mt-4">
    <h5 class="card-header">Puzzle Configurations<small><small class="text-danger"><?php echo isset($puzzle['error']) ? $puzzle['error'] : ''; ?></small></small></h5>
</div>

    <form action="create_puzzle.php" method="post">
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="category">Category</label>
                        <input type="text" name="cat_name" id="category" class="form-control" value="<?php echo (isset($_POST['cat_name'])) ? $_POST['cat_name'] : '' ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo (isset($_POST['title'])) ? $_POST['title'] : '' ?>">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value="<?php echo (isset($_POST['description'])) ? $_POST['description'] : '' ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="language">Language</label>
                        <select name="language" id="language" class="form-control">

                        <?php
                        
                            $languages = ['English', 'Telugu', 'Hindi', 'Gujarati', 'Malayalam'];
                            foreach($languages as $language):
                        
                        ?>

                        <option value="<?php echo $language; ?>" <?php echo isset($_POST['language']) && $_POST['language'] == $language ? 'selected ="selected"' : '' ?>><?php echo $language; ?></option>

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

                            <option value="<?php echo $key; ?>" <?php echo isset($_POST['word_direction']) && $_POST['word_direction'] == $key ? 'selected ="selected"' : '' ?>><?php echo $direction; ?></option>

                            <?php endforeach; // end directions ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Height</label>
                        <input type="number" name="height" id="height" min="10" max="25" value="<?php echo (isset($_POST['height'])) ? $_POST['height'] : '10' ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="width">Width</label>
                        <input type="number" name="width" id="width" min="10" max="25" value="<?php echo (isset($_POST['width'])) ? $_POST['width'] : '10' ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Share Characters</label>
                        <select name="share_chars" id="sharechars" class="form-control">
                        <?php
                            $shareChars = ['Yes', 'No'];

                            foreach($shareChars as $boolean):
                        ?>

                            <option value="<?php echo $boolean; ?>" <?php echo isset($_POST['share_chars']) && $_POST['share_chars'] == $boolean ? 'selected ="selected"' : '' ?>><?php echo $boolean; ?></option>

                            <?php endforeach; // end shareChars ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="filler_char_types">Filler Character Types</label>

                        <?php
                        
                            $languages = ['English', 'Telugu', 'Hindi', 'Gujarati', 'Malayalam'];
                            foreach($languages as $language):
                        
                        ?>

                        <select name="filler_char_types" id="<?php echo $language; ?>"<?php echo $language != 'English' ? 'style="display:none"' : ''; ?> class="form-control"<?php echo $language != 'English' ? 'disabled' : '' ;?>>

                                <?php
                                
                                if($language != 'English'):

                                    $charTypes = ['Any', 'Constants', 'Vowels', 'Single Consonant Blends', 'Double Consonant Blends', 'Triple Consonant Blends', 'Consonant Blends and Vowels']; 
        
                                    foreach($charTypes as $type):
                                     
                                ?>

                                        <option value="<?php echo $type; ?>" <?php echo isset($_POST['filler_char_types']) && $_POST['filler_char_types'] == $type ? 'selected ="selected"' : '' ?>><?php echo $type; ?></option>

                                <?php
                                
                                    endforeach; // end charTypes

                                else:
                                    $charTypes = ['Any', 'Constants', 'Vowels']; 
                                    
                                    foreach($charTypes as $type):
                                
                                ?>

                                        <option value="<?php echo $type; ?>" <?php echo isset($_POST['filler_char_types']) && $_POST['filler_char_types'] == $type ? 'selected ="selected"' : '' ?>><?php echo $type; ?></option>

                                <?php
                                    endforeach; // end charTypes
                                
                                endif; // end language ?>
                        </select>

                        <?php endforeach; // end languages?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="wordBank">Word Bank</label>
                    <textarea class="form-control" rows="15" name="word_bank" id="wordBank"><?php echo (isset($_POST['word_bank'])) ? $_POST['word_bank'] : '' ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-row">

    <?php if(isset($_POST['generate_puzzle']) && $puzzle['generate_board'] == TRUE): ?>
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary form-control" type="submit" name="generate_puzzle">Generate Puzzle</button>
                    </div>

                    <div class="form-group col-md-6">
                        <button class="btn btn-success form-control" type="submit" name="save_puzzle">Save Puzzle</button>
                    </div>
                </div> <!-- end form-row -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </form>

    <div class="card">
        <h6 class="card-header">Generated Puzzle</h6>
        <div class="card-body">
            <table align="center">
                <?php for($row = 0; $row < $puzzle['height']; $row++): ?>
                    <tr>
                        <?php for($col = 0; $col < $puzzle['width']; $col++): ?>
                        <td>
                            <?php echo $puzzle['board'][$row][$col]; ?>  
                        </td>
                        <?php endfor; // end col ?>
                    </tr>
                    <?php endfor; // end row ?>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <h6 class="card-header">Generated Solution Puzzle</h6>
        <div class="card-body">
            <table align="center">
                <?php for($row = 0; $row < $puzzle['height']; $row++): ?>
                    <tr>
                        <?php for($col = 0; $col < $puzzle['width']; $col++): ?>
                        
                            <?php
                            
                            $answerLetter = FALSE;
                            for($i = 0; $i < sizeof($puzzle['answer_coordinates']); $i++){
                                for($j = 0; $j < sizeof($puzzle['answer_coordinates'][$i]); $j++){
                                    $index = $puzzle['answer_coordinates'][$i][$j];
                                    if($index[0] == $row && $index[1] == $col){
                                        $answerLetter = TRUE;
                                    }
                                }
                            }

                            if($answerLetter):
                            
                            ?>

                                <td class="bg-success" id="<?php echo $row . $col; ?>"><?php echo $puzzle['board'][$row][$col]; ?></td>

                            <?php else: ?>

                                <td id="<?php echo $row . $col; ?>"><?php echo $puzzle['board'][$row][$col]; ?></td>

                            <?php endif; ?>


                       
                        <?php endfor;  // end col ?>
                    </tr>
                    <?php endfor; // end row ?>
            </table>
        </div>
    </div>

    <?php else: ?>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary form-control" type="submit" name="generate_puzzle">Generate Puzzle</button>
                    </div>
                </div> <!-- end form-row -->
            </div> <!-- end column -->
        </div> <!-- end row -->
    </form>

    <?php endif; ?>

<?php include('includes/footer.php'); ?>