<?php 

    $page_title = 'Word Find Puzzle';
    include 'includes/header.php';

    $puzzleId = $_GET['puzzleId'];
    $puzzle = getPuzzleById($puzzleId, $pdo);

    echo '<pre>';
    print_r($puzzle);
    echo '</pre>';

    foreach($puzzle as $puzzle){

        $data = [
            'puzzle' => $puzzle,
        ];
    }

?>

<div class="card mt-4">
    <h5 class="card-header"><?php
    
    echo $data['puzzle']->title; ?>

    <small><small><?php echo $data['puzzle']->description; ?></small></small>
    
    </h5>
</div>

    <div class="accordion mt-4">

        <div class="card">
            <h6 class="card-header">Word List</h6>
            <div class="card-body">
            <p class="card-text"><?php
            
                $wordBank = unserialize($data['puzzle']->word_bank);

                echo '<pre>';
                print_r($wordBank);
                echo '</pre>';

                $count = 0;
                foreach($wordBank as $word){
                    $count++;
                    echo implode("", $word);
                    if($count < sizeof($wordBank)){
                        echo ', ';
                    }
                }
            ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header" id="puzzle">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left pl-1" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    Puzzle
                    </button>
                </h2>
            </div>

            <div id="collapseTwo" class="collapse show" aria-labelledby="puzzle">
                
                <div class="card-body ml-3">
                    <table align="center" border>
                        <?php for($row = 0; $row < $data['puzzle']->height; $row++): ?>
                            
                            <tr>
                                <?php for($col = 0; $col < $data['puzzle']->width; $col++): ?>
                                <td>
                                    .
                                </td>
                                <?php endfor; ?>
                            </tr>
                            <?php endfor; ?>


                    </table>
                </div>
            </div>
        </div>

        <!-- Solution -->
        <div class="card">
            <div class="card-header" id="solutionPuzzle">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Solution
                    </button>
                </h2>
            </div>

            <div id="collapseThree" class="collapse" aria-labelledby="solutionPuzzle">
                <div class="card-body ml-3">
                    <table align="center">
                        <tr>
                            <td>C</td>
                            <td>O</td>
                            <td>V</td>
                            <td>S</td>
                            <td>E</td>
                            <td>V</td>
                            <td>L</td>
                            <td>O</td>
                            <td>W</td>
                            <td>F</td>
                        </tr>

                        <tr>
                            <td>K</td>
                            <td>J</td>
                            <td>Y</td>
                            <td>Q</td>
                            <td>D</td>
                            <td>D</td>
                            <td>I</td>
                            <td>E</td>
                            <td>R</td>
                            <td>T</td>
                        </tr>

                        <tr>
                            <td>G</td>
                            <td>X</td>
                            <td>M</td>
                            <td>A</td>
                            <td>R</td>
                            <td>O</td>
                            <td>N</td>
                            <td>U</td>
                            <td>T</td>
                            <td>S</td>
                        </tr>

                        <tr>
                            <td>A</td>
                            <td>X</td>
                            <td>D</td>
                            <td>F</td>
                            <td>S</td>
                            <td>A</td>
                            <td>S</td>
                            <td>O</td>
                            <td>Y</td>
                            <td>O</td>
                        </tr>

                        <tr>
                            <td>R</td>
                            <td>W</td>
                            <td>L</td>
                            <td>W</td>
                            <td>M</td>
                            <td>S</td>
                            <td>W</td>
                            <td>E</td>
                            <td>K</td>
                            <td>I</td>
                        </tr>

                        <tr>
                            <td>N</td>
                            <td>Z</td>
                            <td>H</td>
                            <td>Y</td>
                            <td>E</td>
                            <td>N</td>
                            <td>L</td>
                            <td>O</td>
                            <td>E</td>
                            <td>P</td>
                        </tr>

                        <tr>
                            <td>E</td>
                            <td>Z</td>
                            <td>A</td>
                            <td>L</td>
                            <td>S</td>
                            <td>S</td>
                            <td>G</td>
                            <td>L</td>
                            <td>J</td>
                            <td>U</td>
                        </tr>

                        <tr>
                            <td>T</td>
                            <td>L</td>
                            <td>L</td>
                            <td>G</td>
                            <td>A</td>
                            <td>I</td>
                            <td>A</td>
                            <td>Y</td>
                            <td>D</td>
                            <td>K</td>
                        </tr>

                        <tr>
                            <td>T</td>
                            <td>H</td>
                            <td>Q</td>
                            <td>E</td>
                            <td>E</td>
                            <td>E</td>
                            <td>W</td>
                            <td>C</td>
                            <td>N</td>
                            <td>J</td>
                        </tr>
                        
                        <tr>
                            <td>P</td>
                            <td>Y</td>
                            <td>B</td>
                            <td>G</td>
                            <td>B</td>
                            <td>R</td>
                            <td>I</td>
                            <td>A</td>
                            <td>N</td>
                            <td>Q</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php include('includes/footer.php'); ?>