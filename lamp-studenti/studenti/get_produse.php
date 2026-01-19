<?php
require_once 'db.php';

header('Content-Type: application/json');

// luăm doar produsele disponibile
$sql = "SELECT id_produs, nume_produs, descriere, pret, categorie, disponibil, imagine
        FROM produse 
        WHERE disponibil = 1";


$stmt = $pdo->prepare($sql);
$stmt->execute();

$produse = $stmt->fetchAll();

// trimitem JSON către produse.html
echo json_encode($produse);
