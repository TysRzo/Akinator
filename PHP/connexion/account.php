<?php
session_start();
require_once('../config/database.php');
require_once('../repository/usersRepository.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Modification du mot de passe
if (isset($_POST['current_password']) && isset($_POST['new_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    
    $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{12,}$/';
    
    if (preg_match($regex, $newPassword)) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        if (updatePassword($_SESSION['user_id'], $currentPassword, $newPasswordHash)) {
            $success = "Mot de passe modifié avec succès";
        } else {
            $error = "Mot de passe actuel incorrect";
        }
    } else {
        $error = "Le nouveau mot de passe ne répond pas aux critères de sécurité";
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