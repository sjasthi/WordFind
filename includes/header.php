<?php
    ob_start();
    require_once 'db.php';
    require_once 'helpers/functions.php';
    require_once 'helpers/sessions.php';
    require_once 'indic-wp/word_processor.php';

    // enable error logging to a custom file
    ini_set("log_errors", 1); 
    ini_set("error_log", "WordFind_errors.log"); 

   
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"> <!-- Must come after bootstrap css - sets circle answers border to 3 -->

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Copy Puzzle Btn -->
    <script src="js/html2canvas.js"></script>
    <!-- Draw circles around answers -->
    <script src="js/highlight_solutions.js"></script>
    <!-- Icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">
    <title><?php echo $pageTitle; ?></title>
</head>

<body class="d-flex flex-column">
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="images/logo.png"style="width:100px;height:40px;" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a href="index.php" class="nav-item nav-link <?php echo ($pageTitle == 'Word Find') ? ' active' : '' ; ?>">Home</a>

                <?php if(isLoggedIn()) : ?>
                    <a href="create_puzzle.php" class="nav-item nav-link <?php echo ($pageTitle == 'Word Find Puzzle Maker') ? ' active' : '' ; ?>">Create Puzzle</a>
                    <a href="?logout" class="nav-item nav-link">Logout</a>
                <?php else: ?>
                    <a href="" class="nav-item nav-link" data-toggle="modal" data-target="#registerModal">Register</a>
                    <a href="" id="loginBtn" class="nav-item nav-link" data-toggle="modal" data-target="#loginModal">Login</a>
                <?php endif; ?>
                </div>

                <form id="search" class="form-inline" action="search.php" method="post">
                    <span class="text-white mr-3"><?php echo (isLoggedIn()) ? 'Welcome, ' . $_SESSION['user_name'] : '' ; ?></span>
                    <input class="form-control mr-sm-2" type="search" name="query" placeholder="category, title, author, date created" onfocus="this.placeholder = ''" onblur="this.placeholder = 'category, title, author, date created'" size="33" aria-label="Search" value="<?php echo isset($_POST['query']) ? $_POST['query'] : ''; ?>">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-fill pb-3 bg-light">

        <div class="container">