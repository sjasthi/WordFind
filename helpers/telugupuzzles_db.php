<?php
/* NOTE: Do NOT upload this file to the live website unless you've replaced the local database information
with the database name, host, username, and password. */
// /* Local testing 
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
//*/