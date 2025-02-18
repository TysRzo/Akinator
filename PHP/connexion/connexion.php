<?php


include "../config/database.php";
include "../repository/usersRepository.php";


//démarrage du système de session
session_start();

// Si déjà connecté, redirection vers le jeu
if (isset($_SESSION['user_id'])) {
    header('Location: game.php');
    exit();
}

//si le form a été soumis ($_POST n'est pas vide)
if (!empty($_POST)) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $user = getUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            header('Location: game.php');
            exit();
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    }
}

// Si l'utilisateur est déjà connecté, rediriger vers account.php
if (isset($_SESSION['user']) && isset($_SESSION['user_id'])) {
    header('Location: account.php');
    exit();
}

// if(isset($_SESSION["user"]) && $_SESSION["user"] === "admin"){
//       header("Location:secret.php");
//         exit;
// }


$template = "connexion";
include "../layout.phtml";