<?php 

    $pageTitle = 'Word Find Category';
    include 'includes/header.php';

    $categoryId = $_GET['categoryId'];
    $category = getCategoryById($categoryId, $pdo);

    $categoryName = getCategoryName($categoryId, $pdo);
?>

<div class="card mt-4">
    <h5 class="card-header"><?php echo $categoryName; ?></h5>
</div>

<?php foreach($category as $cat): ?>

    <div class="card mt-3">
        <div class="list-group">
            <h6 class="mb-0"><a href="puzzle.php?puzzleId=<?php echo $cat['puzzle_id']; ?>" class="list-group-item list-group-item-action bg-light text-primary"><?php echo $cat['title']; ?></a></h6>
            <div class="card-body">
                <p class="card-text text-muted">
                    <?php echo $cat['description']; ?>
                    <br>Author: <?php echo $cat['first_name'] . ' ' . $cat['last_name']; ?>
                    <br>Added: <?php echo $cat['created_on']; ?>
                </p>
            </div>
        </div>
    </div>

<?php endforeach; ?>

<?php include('includes/footer.php'); ?>