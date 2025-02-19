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
    $_SESSION['current_text'] = $first['Text'];
}

// Traitement de la réponse
if (isset($_POST['response'])) {
    if ($_POST['response'] !== 'Oui' && $_POST['response'] !== 'Non') {
        $error = "Réponse invalide";
    } else {
        $next = getNextQuestion($_SESSION['current_question'], $_POST['response']);
        
        // Debug
        error_log("Current Question: " . $_SESSION['current_question']);
        error_log("Response: " . $_POST['response']);
        error_log("Next Question: " . print_r($next, true));
        
        if (!$next) {
            $error = "Aucune réponse trouvée";
        } elseif ($next['result_id']) {
            $_SESSION['result'] = $next['result_id'];
            header('Location: result.php');
            exit;
        } elseif ($next['next_question']) {
            // S'assurer que nous changeons de question
            if ($next['next_question'] === $_SESSION['current_question']) {
                $error = "Erreur: Boucle détectée";
            } else {
                $_SESSION['current_question'] = $next['next_question'];
                $_SESSION['current_text'] = $next['Text'];
            }
        } else {
            $error = "Erreur dans l'arbre de décision";
        }
    }
}

// Récupération de la question courante si pas déjà définie
if (!isset($_SESSION['current_text'])) {
    $current = getQuestionById($_SESSION['current_question']);
    $_SESSION['current_text'] = $current['Text'];
}

$template = "game";
include "layout.phtml"; 