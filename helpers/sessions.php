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

    function register($pdo){

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name'  => trim($_POST['last_name']),
            'email'      => trim($_POST['email']),
            'password'   => trim($_POST['password'])
        ];

        // HASH Password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = 'SELECT email FROM users WHERE email = :email;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $data['email']]);
        $row = $stmt->fetch();
            if(!$row){
                $sql = 'INSERT INTO users(first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password);';

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'],
                    'email'      => $data['email'],
                     'password'  => $data['password']
                ]);
                exit('You are registered and can log in');
            } else {
                exit('Email already exists');
            }
    }

    function login($pdo){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'email'    => trim($_POST['email']),
            'password' => trim($_POST['password'])
        ];

        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $data['email']]);
        $user = $stmt->fetch();

        if($user){
            $hashedPassword = $user->password;
            if(password_verify($data['password'], $hashedPassword)){
                createUserSession($user);
                exit('success');
            } else {
                exit('Wrong username or password');
            }
        } else {
            exit('Wrong username or password');
        }
    }

    function createUserSession($user){
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->first_name;
        $_SESSION['role'] = $user->role;
    }

    function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['role']);
        session_destroy();
        redirect('index');
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