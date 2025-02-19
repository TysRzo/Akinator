<?php

function createUser(string $email, string $username, string $password) {
    $pdo = getConnexion();
    $query = $pdo->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    return $query->execute([$email, $username, $password]);
}

function getUserByEmail(string $email) {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);
    return $query->fetch();
}

function deleteUser(int $userId) {
    $pdo = getConnexion();
    
    // D'abord supprimer les parties de l'utilisateur
    $query = $pdo->prepare("DELETE FROM game WHERE users_id = ?");
    $query->execute([$userId]);
    
    // Ensuite supprimer l'utilisateur
    $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $query->execute([$userId]);
}

function saveGame(int $userId, int $resultId) {
    $pdo = getConnexion();
    
    // Récupérer le nom du résultat
    $query = $pdo->prepare("SELECT name FROM result WHERE id = ?");
    $query->execute([$resultId]);
    $result = $query->fetch();
    
    if (!$result) {
        throw new Exception("Résultat non trouvé");
    }
    
    // Insérer dans la table game
    $query = $pdo->prepare("
        INSERT INTO game 
        (users_id, result_id, result, date) 
        VALUES 
        (?, ?, ?, NOW())
    ");
    
    return $query->execute([
        $userId,
        $resultId,
        $result['name']
    ]);
}

function getUserGames(int $userId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("
        SELECT g.date, r.name, r.description, r.picture 
        FROM game g 
        JOIN result r ON g.result_id = r.id 
        WHERE g.users_id = ? 
        ORDER BY g.date DESC
    ");
    $query->execute([$userId]);
    return $query->fetchAll();
}

function updatePassword(int $userId, string $currentPassword, string $newPassword) {
    $pdo = getConnexion();
    
    // 1. Vérifier le mot de passe actuel
    $query = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $query->execute([$userId]);
    $user = $query->fetch();
    
    if (!$user || !password_verify($currentPassword, $user['password'])) {
        return false; // Mot de passe actuel incorrect
    }
    
    // 2. Mettre à jour avec le nouveau mot de passe
    $query = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    return $query->execute([$newPassword, $userId]);
}