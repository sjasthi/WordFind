<?php 

    $page_title = 'Word Puzzle Maker';
    include('inc/header.php');

?>

<div class="container">

    <div class="card mt-4">
        <div class="card-header">Puzzle Configurations</div>
    </div>

    <form action="getInfo.php" method="get">
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
                        <label for="height">Created By</label>
                        <input type="text" name="created_by" id="createdBy" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Create On</label>
                        <input type="date" name="date" value="<?= date('Y-m-d', time()); ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="language">Language</label>
                        <select name="language" id="language" class="form-control">
                            <option value="English">English</option>
                            <option value="Telugu" selected="selected">Telugu (Default)</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Gujarati">Gujarati</option>
                            <option value="Malayalam">Malayalam</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Word Direction</label>
                        <select name="word-direction" id="word-direction" class="form-control">
                            <option value="all">All Directions</option>
                            <option value="horizontal">Horizontal</option>
                            <option value="vertical">Vertical</option>
                            <option value="diagonal">Diagonal</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Height</label>
                        <input type="number" name="width" id="width" value="10" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="height">Width</label>
                        <input type="number" name="width" id="width" value="10" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Share Characters</label>
                        <select name="sharechars" id="sharechars" class="form-control">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sharechars">Filler Character Types</label>
                        <select name="word-direction" id="word-direction" class="form-control">
                            <option value="Any" selected="selected">Any</option>
                            <option value="Consonants">Consonants</option>
                            <option value="Vowels">Vowels</option>
                            <option value="SCB">Single Consonant Blends</option>
                            <option value="DCB">Double Consonant Blends</option>
                            <option value="TCB">Triple Consonant Blends</option>
                            <option value="CDV">Constant Belnds and Vowels</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <button class="btn btn-primary w-100" type="submit">Generate Puzzle</button>
                    </div>
                    
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="puzzlewords">Word Bank</label>
                    <textarea class="form-control" rows="19" id="puzzleWords" name="puzzlewords" ></textarea>
                </div>
            </div>
        </div>
    </form>
    

</div>

<?php include('inc/footer.php'); ?>