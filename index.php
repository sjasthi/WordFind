<?php 

    $page_title = 'Word Find';
    $subtitle = 'Popular Categories';
    include 'includes/header.php';

    $sql = 'SELECT * FROM categories';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();


    $sql2 = 'SELECT * FROM puzzles LEFT JOIN categories ON categories.cat_id = puzzles.cat_id';
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $puzzles = $stmt2->fetchAll();
?>

<div class="card mt-4">
    <h5 class="card-header"><?php echo $subtitle; ?></h5>
</div>

<?php

    $numOfCols = 4;
    $rowCount = 0;

    foreach ($categories as $cat):
        if($rowCount % $numOfCols == 0):
?>
        
        <div class="row mt-3"> 
        
    <?php

        endif; 
        $rowCount++;

    ?>  
            <div class="col-md">
                <div class="card h-100">
                    <h6 class="card-header"><a href="category.php?categoryId=<?php echo $cat->cat_id; ?>" class="card-link">
                        <?php echo $cat->cat_name; ?>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                    </a></h6>
                    
                    <div class="card-body">
                        <?php
                            foreach($puzzles as $puzzle): 
                                if($cat->cat_id == $puzzle->cat_id):
                        ?>
                                    <p class="card-text"><a href="puzzle.php?puzzleId=<?php echo $puzzle->puzzle_id; ?>" class="card-link"><?php echo $puzzle->title; ?></a></p>

                        <?php 

                                endif; 
                            endforeach;
                            
                        ?>
                    </div>
                </div>
            </div>

        <?php
            if($rowCount % $numOfCols == 0): ?>
        </div>
<?php 
            endif;
    endforeach; // end categories
?>

</div>

<?php include('includes/footer.php'); ?>