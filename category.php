<?php 

    $page_title = 'Word Find Category';
    include 'includes/header.php';

    $categoryId = $_GET['categoryId'];
    $category = getCategoryById($categoryId, $pdo);

    foreach($category as $cat){

        $data = [
            'cat_name' => $cat->cat_name,
            'puzzle' => explode(',', $cat->puzzle_names),
            'puzzle_id' => explode(',', $cat->puzzle_ids),
            'puzzle_description' => explode(',', $cat->puzzle_descriptions)
        ];
    }
?>

<div class="card mt-4">
    <h5 class="card-header"><?php echo $data['cat_name']; ?></h5>
</div>

<?php foreach($data['puzzle'] as $index => $puzzle): ?>

    <div class="card mt-4">
        <h6 class="card-header"><a href="puzzle.php?puzzleId=<?php echo $data['puzzle_id'][$index]; ?>" class="card-link"><?php echo $puzzle; ?></a></h6>
        <div class="card-body">
            <p class="card-text"><?php echo $data['puzzle_description'][$index]; ?></p>
        </div>
    </div>

<?php endforeach; ?>
    
</div>

<?php include('includes/footer.php'); ?>