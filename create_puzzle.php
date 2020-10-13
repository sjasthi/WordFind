<?php 

    $page_title = 'Word Find Puzzle Maker';
    $subtitle = 'Puzzle Configurations';
    include 'includes/header.php';
?>

<div class="card mt-4">
    <h5 class="card-header"><?php echo $subtitle; ?></h5>
</div>

    <form action="generate_puzzle.php" method="post">
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="form-row">
                    
                    <div class="form-group col-md-6">
                        <label for="category">Category</label>
                        <input type="text" name="category" id="category" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="author">Author</label>
                        <input type="text" name="author" id="author" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="createdOn">Create On</label>
                        <input type="date" name="created_on" id="createdOn" value="<?= date('Y-m-d', time()); ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="language">Language</label>
                        <select name="language" id="language" class="form-control">
                            <option value="English" selected="selected">English</option>
                            <option value="Telugu">Telugu (Default)</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Gujarati">Gujarati</option>
                            <option value="Malayalam">Malayalam</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="wordDirection">Word Direction</label>
                        <select name="word_direction" id="wordDirection" class="form-control">
                            <option value="all">All Directions</option>
                            <option value="horizontal">Horizontal</option>
                            <option value="vertical">Vertical</option>
                            <option value="diagonal">Diagonal</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Height</label>
                        <input type="number" name="height" id="height" value="10" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="width">Width</label>
                        <input type="number" name="width" id="width" value="10" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Share Characters</label>
                        <select name="share_chars" id="sharechars" class="form-control">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fillerCharTypes">Filler Character Types</label>
                        <select name="filler_char_types" id="fillerCharTypes" class="form-control">
                            <option value="Any" selected="selected">Any</option>
                            <option value="Consonants">Consonants</option>
                            <option value="Vowels">Vowels</option>
                            <option value="SCB">Single Consonant Blends</option>
                            <option value="DCB">Double Consonant Blends</option>
                            <option value="TCB">Triple Consonant Blends</option>
                            <option value="CDV">Constant Belnds and Vowels</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="wordBank">Word Bank</label>
                    <textarea class="form-control" rows="19" name="word_bank" id="wordBank"></textarea>
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