<?php
require_once 'authentication.php';

///* Local testing 
// user sessions database information
DEFINE('USER_SESSIONS_DATABASE_HOST', 'localhost');
DEFINE('USER_SESSIONS_DATABASE_NAME', 'puzzleapps_db');
DEFINE('USER_SESSIONS_DATABASE_USERNAME', 'root');
DEFINE('USER_SESSIONS_DATABASE_PASSWORD', '');
// this app's id
$app_id = 6; // note: this may be different for your local database
// links
DEFINE('LOGIN_LINK', "http://localhost/telugupuzzles/login.php?app_id=" . $app_id);
DEFINE('LOGOUT_LINK', "http://localhost/telugupuzzles/logout.php");
DEFINE('REGISTER_LINK', "http://localhost/telugupuzzles/register.php?app_id==" . $app_id);
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
 * A function to log a user out of the app, then redirect to log out of telugupuzzles.
 */
function logout() {
    // clear the session variable for this app
    unset($_SESSION['wordfind_author']);

    // redirect to telugupuzzles
    header("location: " . LOGOUT_LINK);
}

/**
 * A function to check if the user is logged in to the app.
 * 
 * @return True if the user is logged in, false otherwise.
 */
function is_logged_in() {
    developer_is_logged_in();

    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in']) {
            return true;
        }
    }
    return false;
}

/**
 * A function to check if the user is an admin.
 * 
 * @return True if the user has admin priviledges, false otherwise.
 */
function is_admin() {
    if (isset($_SESSION['role']) && is_logged_in()) {
        if ($_SESSION['role'] == 'ADMIN' || $_SESSION['role'] == 'SUPER_ADMIN'){
            return true;
        }
    }
    return false;
}

/**
 * A function to check if the user is a super-admin.
 * 
 * @return True if the user has super-admin priviledges, false otherwise.
 */
function is_super_admin() {
    if (!isset($_SESSION['logged_in'])) {return false;}
    if (!isset($_SESSION['role'])) {return false;}
    return ($_SESSION['logged_in'] and $_SESSION['role'] == 'SUPER_ADMIN');
} 

/**
 * A function to check if the user has sponsor access.
 * 
 * @return True if the user has sponsor access, false otherwise.
 */
function is_sponsor() {
    if (isset($_SESSION['role']) && is_logged_in()) {
        if ($_SESSION['role'] == 'SPONSOR'){
            return true;
        }
    }
    return false;
}

/**
 * A function to check if the user has author access to the app. If the author acces session
 *  variable is not set, this will set it.
 * 
 * @param $user_id The id of the user
 * @return True if the user has author access, false otherwise.
 */
function is_author($user_id) {
    if (!isset($_SESSION['wordfind_author'])) {
        if (user_has_access_to_app($user_id)) {
            $_SESSION['wordfind_author'] = true;
        } else {
            $_SESSION['wordfind_author'] = false;
        }
    }
    return $_SESSION['wordfind_author'];
}