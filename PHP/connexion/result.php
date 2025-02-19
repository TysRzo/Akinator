<?php
session_start();
require_once('../repository/resultRepository.php');
require_once('../repository/usersRepository.php');

if (!isset($_SESSION['result'])) {
    header('Location: game.php');
    exit;
}

$character = getResultById($_SESSION['result']);

// Sauvegarde de la partie
if (isset($_SESSION['user_id'])) {
    saveGame($_SESSION['user_id'], $_SESSION['result']);
}

$template = "result";
include "layout.phtml"; 