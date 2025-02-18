<?php
session_start();
require_once('../config/database.php');
require_once('../repository/usersRepository.php');

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Initialisation du jeu
if (!isset($_SESSION['game_started']) || isset($_POST['restart'])) {
    // Récupérer la première question
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT id FROM questions WHERE is_first_question = 1 LIMIT 1");
    $query->execute();
    $first_question = $query->fetch();
    
    $_SESSION['current_question'] = $first_question['id'];
    $_SESSION['game_started'] = true;
}

// Récupération de la question courante
$pdo = getConnexion();
$query = $pdo->prepare("SELECT Text FROM questions WHERE id = ?");
$query->execute([$_SESSION['current_question']]);
$current_question = $query->fetch();

// Traitement de la réponse
if (isset($_POST['response'])) {
    $query = $pdo->prepare("
        SELECT next_question, result_id 
        FROM answers 
        WHERE questions_id = ? AND response = ?
    ");
    $query->execute([$_SESSION['current_question'], $_POST['response']]);
    $next = $query->fetch();
    
    if ($next['result_id']) {
        // On a trouvé un résultat
        $_SESSION['result'] = $next['result_id'];
        header('Location: result.php');
        exit;
    } else {
        // On passe à la question suivante
        $_SESSION['current_question'] = $next['next_question'];
    }
}

$template = "game";
include "layout.phtml"; 