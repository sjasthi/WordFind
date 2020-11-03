<?php 

    $pageTitle = 'Word Find';
    include 'includes/header.php';

    $categories = getCategoriesWithTopNResults($pdo);

?>

<div class="card mt-4">
    <h5 class="card-header">Popular Categories</h5>
</div>

<?php

    $numOfCols = 4;
    $rowCount = 0;

    foreach($categories as $category):

        $data = [
            'cat_name' => $category->cat_name,
            'puzzle' => explode(',', $category->puzzle_names),
            'puzzle_id' => explode(',', $category->puzzle_ids)
        ];

        if($rowCount % $numOfCols == 0):
?>
        
        <div class="row"> 
        
    <?php

        endif; 
        $rowCount++;

    ?>  
            <div class="col-md mt-3">
                <div class="card h-100">
                    <h6 class="card-header"><a href="category.php?categoryId=<?php echo $category->cat_id; ?>" class="card-link">
                        <?php echo $data['cat_name']; ?>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                    </a></h6>
                    
                    <div class="card-body">
                        <?php
                            foreach($data['puzzle'] as $index => $puzzle): ?>
                                <p class="card-text"><a href="puzzle.php?puzzleId=<?php echo $data['puzzle_id'][$index]; ?>" class="card-link"><?php echo $puzzle; ?></a></p>
                                
                            <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <?php
            if($rowCount % $numOfCols == 0): ?>
        </div>

<?php 
            endif;

        endforeach;

?>

<?php include('includes/footer.php'); ?>