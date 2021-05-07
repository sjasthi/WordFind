<?php
if (session_status() == PHP_SESSION_NONE) {
    // adjust the session path to the main domain's location
    //ini_set('session.save_path', '/var/cpanel/php/sessions/ea-php73'); // does not work on localhost, uncomment for live site
    // set the cookie params in order to find the main domain's session
    //session_set_cookie_params(0, '/', '.telugupuzzles.com'); // does not work on localhost, uncomment for live site
    session_start();
}