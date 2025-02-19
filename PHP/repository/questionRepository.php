<?php
require_once('../config/database.php');

function getFirstQuestion() {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT id, Text FROM questions WHERE is_first_question = 1 LIMIT 1");
    $query->execute();
    return $query->fetch();
}

function getQuestionById($questionId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT id, Text FROM questions WHERE id = ?");
    $query->execute([$questionId]);
    return $query->fetch();
}

function getNextQuestion($questionId, $response) {
    $pdo = getConnexion();
    $query = $pdo->prepare("
        SELECT a.next_question, a.result_id, q.Text 
        FROM answers a
        LEFT JOIN questions q ON a.next_question = q.id
        WHERE a.questions_id = ? AND a.response = ?
    ");
    $query->execute([$questionId, $response]);
    $next = $query->fetch();

    error_log("Question ID: " . $questionId);
    error_log("Response: " . $response);
    error_log("Next Question: " . ($next['next_question'] ?? 'null'));
    error_log("Result ID: " . ($next['result_id'] ?? 'null'));

    return $next;
} 