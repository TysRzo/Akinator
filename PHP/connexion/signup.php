<?php

include "../config/database.php";
include "usersRepository.php";

if (!empty($_POST)) {
    if (isset($_POST['password']) && isset($_POST['email'])) {
        $password = $_POST['password'];
        $email = $_POST['email'];
        
        $regex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{12,}$/';
        
        if (preg_match($regex, $password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                createUser($email, $passwordHash);
                header("Location: connexion.php");
                exit;
            } catch (PDOException $e) {
                $error = "Une erreur est survenue lors de la création du compte.";
            }
        } else {
            $error = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
}

$template = "signup";
include "signup.phtml";