<?php

function createUser(string $email, string $password) {
    $pdo = getConnexion();
    $query = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $query->execute([$email, $password]);
}

function getUserByEmail(string $email) {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute([$email]);
    return $query->fetch();
}

function deleteUser(int $userId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $query->execute([$userId]);
}

function saveGame(int $userId, int $resultId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("INSERT INTO games (user_id, result_id, date) VALUES (?, ?, NOW())");
    $query->execute([$userId, $resultId]);
}

function getUserGames(int $userId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("
        SELECT g.date, r.name, r.description, r.image_url 
        FROM games g 
        JOIN results r ON g.result_id = r.id 
        WHERE g.user_id = ? 
        ORDER BY g.date DESC
    ");
    $query->execute([$userId]);
    return $query->fetchAll();
}