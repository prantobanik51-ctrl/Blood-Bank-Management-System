<?php
session_start();

function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function require_login() {
    if (!is_logged_in()) {
        $redirect = urlencode($_SERVER['REQUEST_URI']);
        header("Location: login.php?redirect=$redirect");
        exit();
    }
}

function has_role($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function get_current_user_id() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

function get_current_username() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

function get_current_full_name() {
    return isset($_SESSION['full_name']) ? $_SESSION['full_name'] : null;
}
?>