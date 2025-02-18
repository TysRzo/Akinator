<?php
session_start();
require_once('../config/database.php');

if (!isset($_SESSION['result'])) {
    header('Location: game.php');
    exit;
}

$pdo = getConnexion();
$query = $pdo->prepare("SELECT * FROM results WHERE id = ?");
$query->execute([$_SESSION['result']]);
$character = $query->fetch();

// Sauvegarde de la partie
if (isset($_SESSION['user_id'])) {
    saveGame($_SESSION['user_id'], $_SESSION['result']);
}

$template = "result";
include "layout.phtml"; 