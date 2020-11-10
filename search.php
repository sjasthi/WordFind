<?php 

    $pageTitle = 'Word Find Puzzle';
    include 'includes/header.php';
    $query = search($pdo);

?>

    <div class="card mt-4">

            <?php if(sizeof($query) == 0):?>
                <h5 class="card-header">I Found Nothing</h5>
    </div>

    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <strong>Nope!</strong> This is where I would normally display what you're looking for, but I don't have what you're looking for.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
            <?php else: ?>

            <?php

            $result = 'results';
            if(sizeof($query) == 1){
                $result = 'result';
            }

            echo '<h5 class="card-header">' . sizeof($query) . ' ' . $result . ' found for ' . $_POST['query'] . '</h5></div>';

        endif;
            
            ?>


    <?php foreach($query as $puzzle): ?>

    <div class="card mt-3">
        <h6 class="card-header"><a href="puzzle.php?puzzleId=<?php echo $puzzle->puzzle_id; ?>" class="card-link"><?php echo $puzzle->title; ?></a></h6>
        <div class="card-body">
            <p class="card-text">
                <?php echo $puzzle->description; ?>
                <br>Found in: <a href="category.php?categoryId=<?php echo $puzzle->cat_id; ?>" class="card-link"><?php echo $puzzle->cat_name; ?></a>
                <br>Author: <?php echo $puzzle->first_name . ' ' . $puzzle->last_name; ?>
                <br>Added: <?php echo $puzzle->created_on; ?>
            </p>
        </div>
    </div>

    <?php endforeach; ?>

    <?php if(sizeof($query) != 0): ?>

    <?php endif; // sizeof query ?>

<?php include('includes/footer.php'); ?>