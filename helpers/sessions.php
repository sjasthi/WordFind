<?php
    ob_start();
    require_once 'session_start.php';
    require_once 'user_sessions.php';

    // used if user clicks back btn after creating a puzzle
    function preserveCache(){
        header( "Expires: Mon, 20 Dec 1998 01:00:00 GMT" );
        header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
        header( "Cache-Control: no-cache, must-revalidate" );
        header( "Pragma: no-cache" );
    }

    function isLoggedIn(){
        return is_logged_in();
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
            redirect('index.php');
        }
    }

    function redirect($page){
        header('location: ' . $page);
    }

    if(isset($_GET['session_id'])){
        create_session($_GET['session_id']);

        redirect('index.php');
    }

    if(isset($_GET['logout'])){
        logout();
    }