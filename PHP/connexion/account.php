<?php
session_start();
require_once('../config/database.php');
require_once('../repository/usersRepository.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Modification du mot de passe
if (isset($_POST['new_password'])) {
    $password = $_POST['new_password'];
    $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{12,}$/';
    
    if (preg_match($regex, $password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        updatePassword($_SESSION['user_id'], $passwordHash);
        $success = "Mot de passe modifié avec succès";
    } else {
        $error = "Le mot de passe ne répond pas aux critères de sécurité";
    }
}

// Récupérer l'historique des parties
$games = getUserGames($_SESSION['user_id']);

// Suppression du compte
if (isset($_POST['delete_account'])) {
    deleteUser($_SESSION['user_id']);
    session_destroy();
    header('Location: index.php');
    exit;
}

$template = "account";
include "layout.phtml"; 