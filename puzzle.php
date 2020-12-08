<?php 

    $pageTitle = 'Word Find Puzzle';
    include 'includes/header.php';

    $puzzleId = $_GET['puzzleId'];
    $puzzle = getPuzzleById($pdo, $puzzleId);
    setControlCookies();

    if(isset($_POST['delete_puzzle'])){
        deletePuzzle($pdo, $puzzleId);
    }

    foreach($puzzle as $puzzle){

        $data = [
            'puzzle'             => $puzzle,
            'title'              => $puzzle->title,
            'user_id'            => $puzzle->user_id,
            'description'        => $puzzle->description,
            'height'             => $puzzle->height,
            'width'              => $puzzle->width,
            'language'           => $puzzle->language,
            'char_bank'          => json_decode($puzzle->char_bank),
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

    <div id="gameInstructions" class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
        <strong>Two Ways to Play</strong>
        <p>1. Click each cell to begin selecting a word. Click shift to finish selecting the word.
        <br>2. Click a cell, keep the mouse pressed down, moved across the word, mouse up to finish selecting the word.</p>


        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form id="controls" action="" method="post">
        <div class="card mt-4">

            <div class="card-header">
                <h6 class="custom-control-inline">Word Bank</h6>

                <div class="custom-control custom-switch custom-control-inline mt-1">
                    <input type="hidden" name="toggle_word_list" value="0">
                    <input type="checkbox" class="custom-control-input" name="toggle_word_list" id="toggleWordList" value="1"<?php echo (isset($_COOKIE['word_list']) && $_COOKIE['word_list'] == 1) ? ' checked ' : ''; ?>>
                    <label class="custom-control-label" for="toggleWordList">show</label>
                </div>
            </div>

            <div id="wordBank" class="card-body d-none word-list">
                <!-- pass charBank to js -->
                <script>
                    var charBank = <?php echo json_encode($data['char_bank']); ?>
                </script>
                <p id="words" class="card-text"><span id="bank" class="bank"><?php echo "<span>".implode('</span> &bull; <span>', $data['word_bank'])."</span>"; ?></span></p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="container card-header">
                <div class="row">
                    <div class="col-sm col-auto mr-auto">
                        <div class="custom-control custom-switch custom-control-inline mt-1">
                            <input type="hidden" name="toggle_borders" value="0">
                            <input type="checkbox" class="custom-control-input" name="toggle_borders" id="toggleBorders" value="1"<?php echo (isset($_COOKIE['borders']) && $_COOKIE['borders'] == 1) ? ' checked ' : ''; ?>>
                            <label class="custom-control-label" for="toggleBorders">Borders</label>
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
                            <?php if(isAdmin() || isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['user_id']): ?> 
                            <label class="custom-control-label" for="toggleSolutionLines">Solution</label>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div id="controlBtns" class="col-auto mt-3 mt-md-0">
                        <button type="button" id="play" class="btn btn-outline-primary btn-sm">Play</button>
                        <?php if(isAdmin() || isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['user_id']): ?>
                            <a href="edit_puzzle.php?id=<?php echo $puzzleId; ?>"><button type="button" id="edit" name = "edit_puzzle" class="btn btn-outline-primary btn-sm">Edit</button></a>
                        <button type="submit" id="delete" name="delete_puzzle" class="btn btn-outline-primary btn-sm">Delete</button>
                        <?php endif; ?>
                        <button type="button" id="copyMe" class="btn btn-outline-primary btn-sm">Copy</button>
                    </div>
                </div>
            </div>

            <div id="puzzleContainer" class="card-body d-flex justify-content-center">
                <div class="col-auto">
                    <table id="puzzle">
                        <tr class="bg-success">
                            <?php foreach($letters as $letter): ?>
                                <td class="row-label d-none"><?php echo $letter ?></td>
                            <?php endforeach; ?>
                        </tr>
                        
                        <?php for($row = 0; $row < $data['height']; $row++): ?>
                            <tr>
                                <td class="row-label bg-success d-none"><?php echo $row + 1; ?></td>
                                <?php for($col = 0; $col < $data['width']; $col++): ?>

                                        <td class="char" id="<?php echo 'r' . $row . 'c' . $col; ?>"><?php echo $data['board'][$row][$col]; ?></td>

                                <?php endfor;  // end col ?>
                            </tr>
                            <?php endfor; // end row ?>
                    </table>
                </div>
            </div>
        </div>
    </form>

<?php

    if(isLoggedIn()){
        addSolution($data);
    }
    
    include('includes/footer.php');
?>