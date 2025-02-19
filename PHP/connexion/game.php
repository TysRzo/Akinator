<?php
session_start();
require_once('../repository/questionRepository.php');

// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Première question ou redémarrage
if (!isset($_SESSION['current_question']) || isset($_POST['restart'])) {
    $first = getFirstQuestion();
    $_SESSION['current_question'] = $first['id'];
}

// Récupération de la question courante
$current_question = getQuestionById($_SESSION['current_question']);

// Traitement de la réponse
if (isset($_POST['response'])) {
    if ($_POST['response'] !== 'Oui' && $_POST['response'] !== 'Non') {
        $error = "Réponse invalide";
    } else {
        $next = getNextQuestion($_SESSION['current_question'], $_POST['response']);
        
        if (!$next) {
            $error = "Aucune réponse trouvée";
        } elseif ($next['result_id']) {
            $_SESSION['result'] = $next['result_id'];
            header('Location: result.php');
            exit;
        } elseif ($next['next_question']) {
            $_SESSION['current_question'] = $next['next_question'];
        } else {
            $error = "Erreur dans l'arbre de décision";
        }
    }
}

$template = "game";
include "layout.phtml"; 