<?php
    ob_start();
    session_start();

    // used if user clicks back btn after creating a puzzle
    function preserveCache(){
        header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
        header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
        header( "Cache-Control: no-cache, must-revalidate" );
        header( "Pragma: no-cache" );
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        } else {
            return false;
        }
    }

    function isAdmin(){
        if(isLoggedIn() && $_SESSION['role'] == 'admin'){
            return true;
        } else {
            return false;
        }
    }

    function regUser(){
        if(!isLoggedIn()){
            redirect('index');
        }
    }

    function redirect($page){
        header('location: ' . $page . '.php');
    }

    if(isset($_POST['register'])){
        register($pdo);
    }

    if(isset($_POST['login'])){
        login($pdo);
    }

    if(isset($_GET['logout'])){
        logout();
    }