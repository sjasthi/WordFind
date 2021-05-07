<?php
/*
NOTE: Do NOT upload this file to the live site when $development_environment is set to true!
The following boolean values exist for developing and testing this application on a stand-alone basis on localhost.
Usage:
- Set $development_environment to true.
- To see what the site looks like when logged in as a regular user, set $logged_in to true and $admin and $super_admin to false.
- To see what the site looks like when logged in as an admin, set $logged_in and $admin to true, and $super_admin to false.
- To see what the site looks like when logged in as a super_admin, set $logged_in and $super_admin to true.
- To see what the site looks like when logged in as an author, set $logged_in and $author to true.
- To see what the site looks like when logged in as a sponsor, set $logged_in and $sponsor to true.
- To see what the site looks like when not logged in, set $logged_in to false.
*/
// set this to true to manually change logged in/admin status
$development_environment = false;
// set this to true to test what the app looks like when logged in, and false to test not logged in
$logged_in = false;
// set this to true to test what the app looks like for admins (note: if super_admin is true, that will take priority)
$admin = false;
// set this to true to test what the app looks like for super_admins
$super_admin = false;
// set this to true to test what the app looks like for authors
$author = false;
// set this to true to test what the app looks like for sponsors
$sponsor = false;

// this sets the role string, do not edit
if ($super_admin) {
    $role = 'SUPER_ADMIN';
} elseif ($admin) {
    $role = 'ADMIN';
} elseif ($sponsor) {
    $role = 'SPONSOR';
} else {
    $role = 'USER';
}

/**
 * A function to check if the user is logged in to the app according to the development environment
 *  variables.
 * 
 * @return boolean if the user is logged in, false otherwise.
 */
function developer_is_logged_in() {
    // localhost development logic
    global $development_environment;
    if ($development_environment) {
        global $logged_in;
        // logged_in test for development purposes
        if ($logged_in) {
            global $role;
            // Session variables for localhost testing
            $_SESSION['user_id'] = 1;
            $_SESSION['email'] = 'test@test.test';
            $_SESSION['first_name'] = 'First_name';
            $_SESSION['last_name'] = 'Last_name';
            $_SESSION['role'] = $role;
            $_SESSION['logged_in'] = true;
        } else {
            // clear session variables for development environment if not logged in
            unset($_SESSION['user_id']);
            unset($_SESSION['email']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            unset($_SESSION['role']);
            unset($_SESSION['logged_in']);
        }
    }
}