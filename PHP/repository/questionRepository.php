<?php
require_once('../config/database.php');

function getFirstQuestion() {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT id FROM questions WHERE is_first_question = 1 LIMIT 1");
    $query->execute();
    return $query->fetch();
}

function getQuestionById($questionId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT Text FROM questions WHERE id = ?");
    $query->execute([$questionId]);
    return $query->fetch();
}

function getNextQuestion($questionId, $response) {
    $pdo = getConnexion();
    $query = $pdo->prepare("
        SELECT next_question, result_id 
        FROM answers 
        WHERE questions_id = ? AND response = ?
    ");
    $query->execute([$questionId, $response]);
    return $query->fetch();
} 