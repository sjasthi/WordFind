<?php 

    $page_title = 'Word Find';
    include('inc/header.php');

?>

<form action="getInfo.php" method="GET" target="_blank">
    <div class="container-fluid">

        <div class="jumbotron" id="jumbos"></div>
        <div class="panel">
            <div class="panel-group">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12">
                                <div align="center"><h2>Please enter your Word Find puzzle details</h2></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="language">Select Language</label>
                                    <select class="form-control" id="language" name="language" onchange="fctCheck(this.value);">
                                        <option value="English">English</option>
                                        <option value="Telugu" selected="selected">Telugu (Default)</option>
                                        <option value="Hindi">Hindi</option>
                                        <option value="Gujarati">Gujarati</option>
                                        <option value="Malayalam">Malayalam</option>
                                    </select>
                                </div>
                            </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label for="height">Enter Height</label>
                                        <input type="number" class="form-control" id="height" min="10" max="50" name="height" value="10" placeholder="10">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <label for="width">Enter Width</label>
                                        <input type="number" class="form-control" id="width" min="10" max="50" name="width" value="10" placeholder="10">
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="sharechars">Share Characters?</label>
                                    <select class="form-control" id="sharechars" name="sharechars">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="word-direction">Direction of Words in Puzzle</label>
                                    <select class="form-control" id="word-direction" name="word-direction">
                                        <option value="all">All Directions</option>
                                        <option value="horizontal">Horizontal</option>
                                        <option value="vertical">Vertical</option>
                                        <option value="diagonal">Diagonal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="title">Enter Puzzle Name</label>
                                    <input type="text" class="form-control" id="title" name="puzzlename" placeholder="Title" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <label for="puzzlewords">Enter Word Bank</label>
                                    <label for="puzzleWords"></label>
                                    <textarea class="form-control" rows="20" id="puzzleWords" name="puzzlewords" ></textarea>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label for="fillerTypes">Filler Character Types</label>

					<select class="form-control" id="Hindi" name="fillerTypes" style="display:none">
                        <option value="Any" selected="selected">Any</option>
                        <option value="Consonants">Consonants</option>
                        <option value="Vowels">Vowels</option>
                        <option value="SCB">SINGLE CONSONANT BLENDS</option>
                        <option value="DCB">DOUBLE CONSONANT BLENDS</option>
                        <option value="TCB">TRIPLE CONSONANT BLENDS</option>
                        <option value="CDV">CONSONANT BLENDS AND VOWELS</option>
                    </select>

					<select class="form-control" id="Gujarati" name="fillerTypes" style="display:none">
                        <option value="Any" selected="selected">Any</option>
                        <option value="Consonants">Consonants</option>
                        <option value="Vowels">Vowels</option>
                        <option value="SCB">SINGLE CONSONANT BLENDS</option>
                        <option value="DCB">DOUBLE CONSONANT BLENDS</option>
                        <option value="TCB">TRIPLE CONSONANT BLENDS</option>
                        <option value="CDV">CONSONANT BLENDS AND VOWELS</option>
                </select>

					<select class="form-control" id="Malayalam" name="fillerTypes" style="display:none">
                            <option value="Any" selected="selected">Any</option>
                            <option value="Consonants">Consonants</option>
                            <option value="Vowels">Vowels</option>
                            <option value="SCB">SINGLE CONSONANT BLENDS</option>
                            <option value="DCB">DOUBLE CONSONANT BLENDS</option>
                            <option value="TCB">TRIPLE CONSONANT BLENDS</option>
                            <option value="CDV">CONSONANT BLENDS AND VOWELS</option>
                    </select>

					<select class="form-control" id="English" name="fillerTypes" style="display:none">
						<option value="Any" selected="selected">Any</option>
						<option value="Consonants">Consonants</option>
						<option value="Vowels">Vowels</option>
					</select>
					<select class="form-control" id="Telugu" name="fillerTypes">
                            <option value="Any" selected="selected">Any</option>
                            <option value="Consonants">Consonants</option>
                            <option value="Vowels">Vowels</option>
                            <option value="SCB">SINGLE CONSONANT BLENDS</option>
                            <option value="DCB">DOUBLE CONSONANT BLENDS</option>
                            <option value="TCB">TRIPLE CONSONANT BLENDS</option>
                            <option value="CDV">CONSONANT BLENDS AND VOWELS</option>
                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"><input type="submit" name="submit" class="btn btn-primary btn-lg" value="Generate"></div>
            </div>
        </div>
    </div>
</form>

<?php include('inc/footer.php'); ?>