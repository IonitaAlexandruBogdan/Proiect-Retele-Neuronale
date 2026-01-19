<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id_utilizator'])) {
    http_response_code(403);
    exit('Nu ești logat.');
}

$id_utilizator = $_SESSION['id_utilizator'];

// dacă se trimite update pentru popup (get)
if (isset($_GET['update_cart'])) {
    header('Content-Type: application/json');
    echo json_encode($_SESSION['cart'] ?? []);
    exit;
}

// dacă se confirmă comanda (post cu confirm=1)
if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
    if (empty($_SESSION['cart'])) {
        http_response_code(400);
        exit('Coșul este gol.');
    }

    // calcul total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['pret'] * $item['cantitate'];
    }

    // inserare comanda
    $stmt = $pdo->prepare("
        INSERT INTO comanda (id_utilizator, data_comenzii, total, status)
        VALUES (:id_utilizator, NOW(), :total, 'neconfirmată')
    ");
    $stmt->execute([
        ':id_utilizator' => $id_utilizator,
        ':total' => $total
    ]);

    // golim coșul
    $_SESSION['cart'] = [];

    echo 'Comanda a fost plasată cu succes!';
    exit;
}

// Altfel, e adăugare în coș
$id_produs = isset($_POST['id_produs']) ? (int)$_POST['id_produs'] : 0;
$cantitate = isset($_POST['cantitate']) ? (int)$_POST['cantitate'] : 1;

if ($id_produs <= 0 || $cantitate <= 0) {
    http_response_code(400);
    exit('Date invalide.');
}

// Preluare produs din DB
$stmt = $pdo->prepare("SELECT id_produs, nume_produs, pret FROM produse WHERE id_produs = ? LIMIT 1");
$stmt->execute([$id_produs]);
$produs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produs) {
    http_response_code(404);
    exit('Produs inexistent.');
}

// Adaugare in coș
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$gasit = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id_produs'] == $id_produs) {
        $item['cantitate'] += $cantitate;
        $gasit = true;
        break;
    }
}
if (!$gasit) {
    $_SESSION['cart'][] = [
        'id_produs' => $produs['id_produs'],
        'nume' => $produs['nume_produs'],
        'pret' => $produs['pret'],
        'cantitate' => $cantitate
    ];
}

// răspuns simplu
echo 'Produs adăugat în coș.';
