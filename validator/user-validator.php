<?php

include_once 'config/db-config.php';
include_once 'config/class-user.php';   

function getCart() {
    if (!isset($_SESSION['auth']) || !isset($_SESSION['auth_user']['id_user'])) {
        return [];
    }
    $user = new User();
    return $user->getCart($_SESSION['auth_user']['id_user']);
}

function getCartTotal() {
    if (!isset($_SESSION['auth']) || !isset($_SESSION['auth_user']['id_user'])) {
        return 0;
    }
    $user = new User();
    return $user->getCartTotal($_SESSION['auth_user']['id_user']);
}

function getCartCount() {
    if (!isset($_SESSION['auth']) || !isset($_SESSION['auth_user']['id_user'])) {
        return 0;
    }
    $user = new User();
    return $user->getCartCount($_SESSION['auth_user']['id_user']);
}

function getProfile() {
    if (!isset($_SESSION['auth'])) return false;
    $user = new User();
    return $user->getProfile($_SESSION['auth_user']['id_user']);
}

function getOrders() {
    if (!isset($_SESSION['auth'])) return [];
    $user = new User();
    return $user->getOrders($_SESSION['auth_user']['id_user']);
}