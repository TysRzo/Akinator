<?php

include "../config/database.php";
include "../repository/usersRepository.php";

if (!empty($_POST)) {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Vérification du format du mot de passe
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{12,}$/';
        
        if (preg_match($regex, $password)) {
            try {
                // Vérifier si l'email existe déjà
                $existingUser = getUserByEmail($email);
                if ($existingUser) {
                    $error = "Cet email est déjà utilisé";
                } else {
                    // Hash du mot de passe avant stockage
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    createUser($email, $passwordHash);
                    
                    // Redirection vers la connexion
                    header("Location: connexion.php?success=1");
                    exit;
                }
            } catch (PDOException $e) {
                $error = "Erreur lors de la création du compte";
            }
        } else {
            $error = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
}

$template = "signup";
include "layout.phtml";