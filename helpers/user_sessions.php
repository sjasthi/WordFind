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
// links
DEFINE('LOGIN_LINK', "http://telugupuzzles.com/login.php?app_id=" . $app_id);
DEFINE('LOGOUT_LINK', "http://telugupuzzles.com/logout.php");
DEFINE('REGISTER_LINK', "http://telugupuzzles.com/register.php?app_id==" . $app_id);
/**/

/**
 * A function which connects to the user sessions database using PDO.
 * 
 * @return The pdo database connection.
 */
function connect_to_user_sessions_db() {
    // Set DSN - data source name
    $dsn = 'mysql:host=' . USER_SESSIONS_DATABASE_HOST . ';dbname=' . USER_SESSIONS_DATABASE_NAME;

    // Create PDO instance
    $sessions_pdo = new PDO($dsn, USER_SESSIONS_DATABASE_USERNAME, USER_SESSIONS_DATABASE_PASSWORD);
    $sessions_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    return $sessions_pdo;
}

/**
 * A function which takes a session id and returns the information about the user who is logged in
 *  to that session on telugupuzzles.
 * 
 * @param $session_id The session id on telugupuzzles
 * @return The relevant information for that session, or null if the session does not exist or there was
 *  an error connecting to the database
 */
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
    return null;
}

/**
 * A function to indicate whether the user with the given user id has author access to this app, according 
 *  to a table in the database.
 * 
 * @param $user_id The user to check the access of.
 * @return True if the user has author access, false otherwise.
 */
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

/**
 * A function to create a session (log in) for this application.
 * 
 * @param $session_id The session id on telugupuzzles
 * @return True if the session was created successfully, false otherwise
 */
function create_session($session_id) {
    $session_info = get_session_info($session_id);
    
    if (is_null($session_info)) {
        // no session info available
        return false;
    } else {
        if ($session_info['allow_login']) { // check user is allowed to login
            // indicate that the user has access to this app
            if (user_has_access_to_app($session_info['id'])) {
                $_SESSION['author'] = true;
            }

            $_SESSION['user_id'] = $session_info['id'];
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

/**
 * A function to set 'allow_login' to false in the database. This prevents someone using the session id
 *  to log in to someone's account after they have logged in.
 * 
 * @param $session_id The session id to set 'allow_login' for
 * @param $session_pdo The pdo connectiont to the database
 */
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

/**
 * A function to log a user out of the app, then redirect to log out of telugupuzzles.
 */
function logout() {
    reset_allow_login(session_id()); // double check allow login is set to false

    // clear the session variables
    unset($_SESSION['user_id']);
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

/**
 * A function to check if the user is logged in to the app.
 * 
 * @return True if the user is logged in, false otherwise.
 */
function is_logged_in() {
    if (isset($_SESSION['logged_in'])) {
        return true;
    } else {
        return false;
    }
}

/**
 * A function to check if the user has author access to the app.
 * 
 * @return True if the user has author access, false otherwise.
 */
function is_author() {
    if (isset($_SESSION['author'])) {
        return true;
    } else {
        return false;
    }
}