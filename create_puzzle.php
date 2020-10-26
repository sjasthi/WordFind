<?php 
    $page_title = 'Word Find Puzzle Maker';
    include 'includes/header.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        createPuzzle($pdo);
    }
?>

<div class="card mt-4">
    <h5 class="card-header">Puzzle Configurations <small><small class="text-danger"><?php echo (isset($_SESSION['error'])) ? $_SESSION['error'] : ''; ?></small></small></h5>
</div>

    <form action="create_puzzle.php" method="post">
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="form-row">
                    
                    <div class="form-group col-md-6">
                        <label for="category">Category</label>
                        <input type="text" name="category" id="category" class="form-control" value="<?php echo (isset($_SESSION['cat_name'])) ? $_SESSION['cat_name'] : '' ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo (isset($_SESSION['title'])) ? $_SESSION['title'] : '' ?>">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control" value="<?php echo (isset($_SESSION['description'])) ? $_SESSION['description'] : '' ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="language">Language</label>
                        <select name="language" id="language" class="form-control">

                        <?php
                        
                            $options = [
                                'english'   => 'English',
                                'telugu'    => 'Telugu',
                                'hindi'     => 'Hindi',
                                'gujarati'  => 'Gujarati',
                                'malayalam' => 'Malayalam'
                            ];
                            foreach($options as $key => $option):
                        
                        ?>

                        <option value="<?php echo $key; ?>" <?php echo isset($_SESSION['language']) && $_SESSION['language'] == $option ? 'selected ="selected"' : '' ?>><?php echo $option; ?></option>

                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="wordDirection">Word Direction</label>
                        <select name="word_direction" id="wordDirection" class="form-control">

                        <?php
                            $options = [
                                'all'        => 'All Directions',
                                'horizontal' => 'Horizontal',
                                'vertical'   => 'Vertical',
                                'diagonal'   => 'Diagonal'
                            ];

                            foreach($options as $key => $option):
                        ?>

                            <option value="<?php echo $key; ?>" <?php echo isset($_SESSION['word_direction']) && $_SESSION['word_direction'] == $option ? 'selected ="selected"' : '' ?>><?php echo $option; ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Height</label>
                        <input type="number" name="height" id="height" value="<?php echo (isset($_SESSION['height'])) ? $_SESSION['height'] : '2' ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="width">Width</label>
                        <input type="number" name="width" id="width" value="<?php echo (isset($_SESSION['width'])) ? $_SESSION['width'] : '2' ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Share Characters</label>
                        <select name="share_chars" id="sharechars" class="form-control">
                        <?php
                            $options = [
                                'yes' => 'Yes',
                                'no'  => 'No'
                            ];

                            foreach($options as $key => $option):
                        ?>

                            <option value="<?php echo $key; ?>" <?php echo isset($_SESSION['share_chars']) && $_SESSION['share_chars'] == $option ? 'selected ="selected"' : '' ?>><?php echo $option; ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fillerCharTypes">Filler Character Types</label>
                        <select name="filler_char_types" id="fillerCharTypes" class="form-control">

                        <?php
                            $options = [
                                'any'         => 'Any',
                                'constonants' => 'Constants',
                                'vowels'      => 'Vowels',
                                'SCB'         => 'Single Consonant Blends',
                                'DCB'         => 'Double Consonant Blends',
                                'TCB'         => 'Triple Consonant Blends',
                                'CDV'         => 'Consonant Blends and Vowels'
                            ];

                            foreach($options as $key => $option):
                        ?>

                            <option value="<?php echo $key; ?>" <?php echo isset($_SESSION['filler_char_types']) && $_SESSION['filler_char_types'] == $option ? 'selected ="selected"' : '' ?>><?php echo $option; ?></option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="wordBank">Word Bank</label>
                    <textarea class="form-control" rows="15" name="word_bank" id="wordBank"><?php echo (isset($_SESSION['word_bank'])) ? $_SESSION['word_bank'] : '' ?></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <button class="btn btn-primary w-100" type="submit" name="generate_puzzle">Generate Puzzle</button>
            </div>
        </div>
    </form>
    
</div>

<?php include('includes/footer.php'); ?>