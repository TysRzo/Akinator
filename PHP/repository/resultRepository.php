<?php
require_once('../config/database.php');

function getResultById($resultId) {
    $pdo = getConnexion();
    $query = $pdo->prepare("SELECT * FROM result WHERE id = ?");
    $query->execute([$resultId]);
    return $query->fetch();
} 