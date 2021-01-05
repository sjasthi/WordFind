<?php
/* Local testing */
// user sessions database information
DEFINE('USER_SESSIONS_DATABASE_HOST', 'localhost');
DEFINE('USER_SESSIONS_DATABASE_NAME', 'puzzleapps_db');
DEFINE('USER_SESSIONS_DATABASE_USERNAME', 'root');
DEFINE('USER_SESSIONS_DATABASE_PASSWORD', '');
// this app's id
$app_id = 6;
// links
DEFINE('LOGIN_LINK', "http://localhost/telugupuzzles/login.php?app_id=" . $app_id);
DEFINE('LOGOUT_LINK', "http://localhost/telugupuzzles/logout.php");
DEFINE('REGISTER_LINK', "http://localhost/telugupuzzles/register.php?app_id==" . $app_id);
/**/

/* live 
// this app's id
$app_id = 6;
// links
DEFINE('LOGIN_LINK', "http://telugupuzzles.com/login.php?app_id=" . $app_id);
DEFINE('LOGOUT_LINK', "http://telugupuzzles.com/logout.php");
DEFINE('REGISTER_LINK', "http://telugupuzzles.com/register.php?app_id==" . $app_id);
/**/

function connect_to_user_sessions_db() {
    // Set DSN - data source name
    $dsn = 'mysql:host=' . USER_SESSIONS_DATABASE_HOST . ';dbname=' . USER_SESSIONS_DATABASE_NAME;

    // Create PDO instance
    $sessions_pdo = new PDO($dsn, USER_SESSIONS_DATABASE_USERNAME, USER_SESSIONS_DATABASE_PASSWORD);
    $sessions_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    return $sessions_pdo;
}

function get_session_info($session_id) {
    try {
        $sessions_pdo = connect_to_user_sessions_db();
        // set the PDO error mode to exception
        $sessions_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepared statement
        $stmt = $sessions_pdo->prepare("SELECT * FROM user_sessions 
            JOIN users ON user_sessions.user_email = users.email 
            WHERE session_id=:session_id");
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();

        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // reset the allow-login boolean
            reset_allow_login($session_id, $sessions_pdo);

            return $result;
        } else {
            return null;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function user_has_access_to_app($user_id) {
    global $app_id;

    try {
        $sessions_pdo = connect_to_user_sessions_db();
        // set the PDO error mode to exception
        $sessions_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepared statement
        $stmt = $sessions_pdo->prepare("SELECT * FROM users_apps WHERE user_id=:user_id AND app_id=:app_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':app_id', $app_id);
        $stmt->execute();

        // if an association between that user and app exists, the user has access
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function create_session($session_id) {
    $session_info = get_session_info($session_id);
    
    if (is_null($session_info)) {
        // no session info available
        return false;
    } else {
        if ($session_info['allow_login']) { // check user is allowed to login
            // user_has_access_to_app($user_id) if app_result -> rows exist, indicate somehow that the user has access to this app
            if (user_has_access_to_app($session_info['id'])) {
                $_SESSION['author'] = true;
            }

            $_SESSION['email'] = $session_info['email'];
            $_SESSION['first_name'] = $session_info['first_name'];
            $_SESSION['last_name'] = $session_info['last_name'];
            $_SESSION['role'] = $session_info['role'];
            $_SESSION['logged_in'] = true;

            return true;
        } else {
            return false;
        }
    }
}

function reset_allow_login($session_id, $sessions_pdo = null) {
    if (is_null($sessions_pdo)) {
        try {
            $sessions_pdo = connect_to_user_sessions_db();
            // set the PDO error mode to exception
            $sessions_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // prepared statement
            $stmt = $sessions_pdo->prepare("UPDATE user_sessions SET allow_login=false WHERE session_id=:session_id");
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // prepared statement
        $stmt = $sessions_pdo->prepare("UPDATE user_sessions SET allow_login=false WHERE session_id=:session_id");
        $stmt->bindParam(':session_id', $session_id);
        $stmt->execute();
    }
}

function logout() {
    reset_allow_login(session_id()); // double check allow login is set to false

    // clear the session variables
    unset($_SESSION['email']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['role']);
    unset($_SESSION['logged_in']);
    unset($_SESSION['author']);
    $_SESSION = array();

    setcookie(session_name(),'',0,'/'); // clear the session cookie
    session_regenerate_id(true); // change the session id
    session_destroy(); // destroy the session

    // redirect to telugupuzzles
    header("location: " . LOGOUT_LINK);
}

function is_logged_in() {
    if (isset($_SESSION['logged_in'])) {
        return true;
    } else {
        return false;
    }
}

function is_author() {
    if (isset($_SESSION['author'])) {
        return true;
    } else {
        return false;
    }
}