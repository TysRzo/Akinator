<?php

function getConnexion():object
{
    $pdo = new PDO('mysql:host=db.3wa.io;port=3306;dbname=mathisroseau_akinator;charset=utf8', 'mathisroseau', 'cfca45573cedaf33e3ae46a92f2639f8');
    
    return $pdo;
}