<?php 

    $page_title = 'Word Find Category';
    $subtitle = 'NBA Teams';
    include 'includes/header.php';

    $categoryId = $_GET['categoryId'];

    $sql = 'SELECT * FROM categories WHERE cat_id = :category_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['category_id' => $categoryId]);
    $category = $stmt->fetchAll();

    $sql2 = 'SELECT * FROM puzzles LEFT JOIN categories ON categories.cat_id = puzzles.cat_id';
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $puzzles = $stmt2->fetchAll();

    $data = [];

    foreach($category as $cat){

        $data = [
            'category' => $cat
        ];
    }

?>

<div class="card mt-4">
    <h5 class="card-header"><?php echo $data['category']->cat_name; ?></h5>
</div>


<?php

    foreach($puzzles as $puzzle):
        if($data['category']->cat_id == $puzzle->cat_id):
    
?>

    <div class="card mt-4">
        <h6 class="card-header"><a href="puzzle.php?puzzleId=<?php echo $puzzle->puzzle_id; ?>" class="card-link"><?php echo $puzzle->title; ?></a></h6>
        <div class="card-body">
            <p class="card-text"><?php echo $puzzle->description; ?></p>
        </div>
    </div>

<?php
        endif;
    endforeach;

?>
    
</div>

<?php include('includes/footer.php'); ?>