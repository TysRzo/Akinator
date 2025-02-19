<?php
session_start();
require_once('../config/database.php');

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Première question ou redémarrage
if (!isset($_SESSION['current_question']) || isset($_POST['restart'])) {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT id FROM questions WHERE is_first_question = 1");
    $query->execute();
    $first = $query->fetch();
    $_SESSION['current_question'] = $first['id'];
}

// Récupération de la question courante
$pdo = getConnexion();
$query = $pdo->prepare("SELECT Text FROM questions WHERE id = ?");
$query->execute([$_SESSION['current_question']]);
$current_question = $query->fetch();

// Traitement de la réponse
if (isset($_POST['response'])) {
    if ($_POST['response'] !== 'Oui' && $_POST['response'] !== 'Non') {
        $error = "Réponse invalide";
    } else {
        $query = $pdo->prepare("
            SELECT next_question, result_id 
            FROM answers 
            WHERE questions_id = ? AND response = ?
        ");
        $query->execute([$_SESSION['current_question'], $_POST['response']]);
        $next = $query->fetch();
        
        if ($next['result_id']) {
            $_SESSION['result'] = $next['result_id'];
            header('Location: result.php');
            exit;
        } else {
            $_SESSION['current_question'] = $next['next_question'];
        }
    }
}

$template = "game";
include "layout.phtml"; 