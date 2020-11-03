<?php 

    $pageTitle = 'Word Find Puzzle';
    include 'includes/header.php';

    $puzzleId = $_GET['puzzleId'];
    $puzzle = getPuzzleById($pdo, $puzzleId);

    foreach($puzzle as $puzzle){

        $data = [
            'puzzle'             => $puzzle,
            'title'              => $puzzle->title,
            'description'        => $puzzle->description,
            'height'             => $puzzle->height,
            'width'              => $puzzle->width,
            'word_bank'          => json_decode($puzzle->word_bank),
            'board'              => json_decode($puzzle->board),
            'answer_coordinates' => json_decode($puzzle->answer_coordinates),
            'solution_directions'=> json_decode($puzzle->solution_directions),
        ];
    }

    $letters = setControlCookies($data);
?>

<div class="card mt-4">
    <h5 class="card-header"><?php echo $data['title']; ?>
        <small><small><?php echo $data['description']; ?></small></small>
    </h5>
</div>

<div class="card mt-4">
<h6 class="card-header">Word List</h6>
    <div class="card-body">
        <p class="card-text"><?php echo implode(", ", $data['word_bank']); ?></p>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header mt-1"><h6 class="custom-control-inline">Puzzle</h6>
        <form id="controls" class="custom-control-inline" action="" method="post">
            <div class="custom-control custom-switch custom-control-inline">
                <input type="hidden" name="toggle_borders" value="0">
                <input type="checkbox" class="custom-control-input" name="toggle_borders" id="toggleBorders" value="1"<?php echo (isset($_COOKIE['borders']) && $_COOKIE['borders'] == 1) ? ' checked' : ''; ?>>
                <label class="custom-control-label" for="toggleBorders">borders</label>
            </div>

            <div class="custom-control custom-switch custom-control-inline">
                <input type="hidden" name="toggle_labels" value="0">
                <input type="checkbox" class="custom-control-input" name="toggle_labels" id="toggleLabels" value="1"<?php echo (isset($_COOKIE['labels']) && $_COOKIE['labels'] == 1) ? ' checked' : ''; ?>>
                <label class="custom-control-label" for="toggleLabels">Label Columns and Rows</label>
            </div>

            <div class="custom-control custom-switch custom-control-inline">
                <input type="hidden" name="toggle_answers" value="0">
                <input type="checkbox" class="custom-control-input" name="toggle_answers" id="toggleAnswers" value="1"<?php echo (isset($_COOKIE['answers']) && $_COOKIE['answers'] == 1) ? ' checked' : ''; ?>>
                <label class="custom-control-label" for="toggleAnswers">Show Answers</label>
            </div>
        </form>
    </div>

    <div class="card-body d-flex justify-content-center">
        <table id="puzzle">
            <tr>
                <?php foreach($letters as $letter): ?>
                    <td class="rowLabel bg-success d-none"><?php echo $letter ?></td>
                <?php endforeach; ?>
            </tr>
            
            <?php for($row = 0; $row < $data['height']; $row++): ?>
                <tr>
                    <td class="rowLabel bg-success d-none"><?php echo $row + 1; ?></td>
                    <?php for($col = 0; $col < $data['width']; $col++): ?>
                    
                        <?php
                        
                        $answerLetter = FALSE;
                        for($i = 0; $i < sizeof($data['answer_coordinates']); $i++){
                            for($j = 0; $j < sizeof($data['answer_coordinates'][$i]); $j++){
                                $index = $data['answer_coordinates'][$i][$j];
                                if($index[0] == $row && $index[1] == $col){
                                    $answerLetter = TRUE;
                                }
                            }
                        }

                        if($answerLetter):
                        
                        ?>

                            <td class="" id="<?php echo $row . $col; ?>"><?php echo $data['board'][$row][$col]; ?></td>

                        <?php else: // answerLetter ?>

                            <td id="<?php echo $row . $col; ?>"><?php echo $data['board'][$row][$col]; ?></td>

                        <?php endif; // answerLetter ?>
                    <?php endfor;  // end col ?>
                </tr>
                <?php endfor; // end row ?>
        </table>
    </div>
</div>

<?php
    addSolution($data);
    include('includes/footer.php');
    
    // addSolution($data);
?>