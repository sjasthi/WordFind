<?php 

    $pageTitle = 'Word Find Puzzle';
    include 'includes/header.php';

    $puzzleId = $_GET['puzzleId'];
    $puzzle = getPuzzleById($pdo, $puzzleId);
    setControlCookies();

    foreach($puzzle as $puzzle){

        $data = [
            'puzzle'             => $puzzle,
            'title'              => $puzzle->title,
            'description'        => $puzzle->description,
            'height'             => $puzzle->height,
            'width'              => $puzzle->width,
            'language'           => $puzzle->language,
            'word_bank'          => json_decode($puzzle->word_bank),
            'board'              => json_decode($puzzle->board),
            'answer_coordinates' => json_decode($puzzle->answer_coordinates),
            'solution_directions'=> json_decode($puzzle->solution_directions),
        ];
    }

    $letters = getTableHeader($data);

?>
    <div class="card mt-4">
        <h5 class="card-header"><?php echo $data['title']; ?>
            <small><small><?php echo $data['description']; ?></small></small>
        </h5>
    </div>

    <div class="card mt-4">
    <h6 class="card-header">Word List</h6>
        <div class="card-body">
            <p class="card-text"><?php echo implode(" &bull; ", $data['word_bank']); ?></p>
        </div>
    </div>

    <div class="card mt-4">
    <div class="card-header mt-1 d-flex justify-content-between">
            <form id="controls" class="custom-control-inline" action="" method="post">
           
                <div class="custom-control custom-switch custom-control-inline mt-1">
                    <input type="hidden" name="toggle_borders" value="0">
                    <input type="checkbox" class="custom-control-input" name="toggle_borders" id="toggleBorders" value="1"<?php echo (isset($_COOKIE['borders']) && $_COOKIE['borders'] == 1) ? ' checked ' : ''; ?>>
                    <label class="custom-control-label" for="toggleBorders">borders</label>
                </div>

                <div class="custom-control custom-switch custom-control-inline mt-1">
                    <input type="hidden" name="toggle_labels" value="0">
                    <input type="checkbox" class="custom-control-input" name="toggle_labels" id="toggleLabels" value="1"<?php echo (isset($_COOKIE['labels']) && $_COOKIE['labels'] == 1) ? ' checked ' : ''; ?>>
                    <label class="custom-control-label" for="toggleLabels">Labels</label>
                </div>
                <?php if(isLoggedIn()):?>
                <div class="custom-control custom-switch custom-control-inline mt-1">
                    <input type="hidden" name="toggle_solution_lines" class="toggle-solution-options" value="0">
                    <input type="checkbox" class="custom-control-input toggle-solution-options" name="toggle_solution_lines" id="toggleSolutionLines" value="1"<?php echo (isset($_COOKIE['solution_lines']) && $_COOKIE['solution_lines'] == 1) ? ' checked ' : ''; ?>>
                    <label class="custom-control-label" for="toggleSolutionLines">Solution</label>
                </div>
                <?php endif; ?>
            </form>          

            <button type="button" id="copyMe" class="btn btn-outline-primary btn-sm">Copy Puzzle</button>  
        </div>
        
        <div id="puzzleContainer" class="card-body d-flex justify-content-center">
            <div class="col-auto">
                <table id="puzzle">
                    <tr class="bg-success">
                        <?php foreach($letters as $letter): ?>
                            <td class="rowLabel d-none"><?php echo $letter ?></td>
                        <?php endforeach; ?>
                    </tr>
                    
                    <?php for($row = 0; $row < $data['height']; $row++): ?>
                        <tr>
                            <td class="rowLabel bg-success d-none"><?php echo $row + 1; ?></td>
                            <?php for($col = 0; $col < $data['width']; $col++): ?>

                                <td id="<?php echo 'r' . $row . 'c' . $col; ?>"><?php echo $data['board'][$row][$col]; ?></td>

                            <?php endfor;  // end col ?>
                        </tr>
                        <?php endfor; // end row ?>
                </table>
            </div>
        </div>
    </div>

    <div id="test"></div>
<?php

    if(isLoggedIn()){
        addSolution($data);
    }
    
    include('includes/footer.php');
?>