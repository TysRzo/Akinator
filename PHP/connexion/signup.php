<?php

include "../config/database.php";
include "../repository/usersRepository.php";

if (!empty($_POST)) {
    $email = $_POST["email"] ?? '';
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($email && $password && $username) {
        // Vérification du format du mot de passe
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{12,}$/';
        
        if (preg_match($regex, $password)) {
            $existingUser = getUserByEmail($email);
            
            if ($existingUser) {
                $error = "Cet email est déjà utilisé";
            } else {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                if (createUser($email, $username, $passwordHash)) {
                    header("Location: connexion.php");
                    exit;
                } else {
                    $error = "Erreur lors de la création du compte";
                }
            }
        } else {
            $error = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
    } else {
        $error = "Tous les champs sont requis";
    }
}

$template = "signup";
include "layout.phtml";