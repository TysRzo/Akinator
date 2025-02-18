<?php
session_start();
include "config/database.php";
include "repository/usersRepository.php";

if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    try {
        $pdo = getConnexion();
        $pdo->beginTransaction();
        
        // Supprime d'abord les parties de l'utilisateur
        $query = $pdo->prepare("DELETE FROM games WHERE user_id = ?");
        $query->execute([$userId]);
        
        // Puis supprime l'utilisateur
        deleteUser($userId);
        
        $pdo->commit();
        session_destroy();
        
        header('Location: index.php');
        exit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Erreur lors de la suppression du compte : " . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit();
} 