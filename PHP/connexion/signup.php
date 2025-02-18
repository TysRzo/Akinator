<?php

include "../config/database.php";
include "../repository/usersRepository.php";

if (!empty($_POST)) {
    // Récupération des données du formulaire
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;
    $nickname = isset($_POST["nickname"]) ? $_POST["nickname"] : null;

    if ($email && $password && $nickname) {
        // Vérification du format du mot de passe
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{12,}$/';
        
        if (preg_match($regex, $password)) {
            try {
                // Vérifier si l'email existe déjà
                $existingUser = getUserByEmail($email);
                if ($existingUser) {
                    $error = "Cet email est déjà utilisé";
                } else {
                    // Hash du mot de passe
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    
                    // Création de l'utilisateur
                    createUser($email, $passwordHash);
                    
                    // Message de succès et redirection
                    echo "Compte créé avec succès !";
                    header("Location: connexion.php");
                    exit;
                }
            } catch (Exception $e) {
                $error = "Erreur lors de la création du compte : " . $e->getMessage();
            }
        } else {
            $error = "Le mot de passe ne répond pas aux critères de sécurité.";
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
}

$template = "signup";
include "layout.phtml";