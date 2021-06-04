<?php
require_once 'db.php';
require_once 'helpers/sessions.php';

if (!has_puzzle_creation_access()) {
    redirect('index.php');
}