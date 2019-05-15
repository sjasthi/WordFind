<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
    <title>Word Find Answer Key</title>
    <style type = "text/css">
        body{
            background: tan;
        }
    </style>
</head>
<body>

<?php
session_start();
//answer key for word find
//called from wordFind.php
$key = $_SESSION['keypuzzle'];
$puzzleName=$_SESSION['puzzlename'];
print <<<HERE
<center>
<h1>$puzzleName Answer Key</h1>
$key
</center>

HERE;
echo "<center><a href='index.html'>Go Make a new Puzzle</a></center>";
?>

</body>
</html>