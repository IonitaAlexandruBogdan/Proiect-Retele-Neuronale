<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id_utilizator'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Nu ești logat.']);
    exit;
}

/* Confirmare comandă */
if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
    if (empty($_SESSION['cart'])) {
        echo json_encode(['success' => false, 'message' => 'Coșul este gol.']);
        exit;
    }

    // Calcul total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['pret'] * $item['cantitate'];
    }

    // Inserare în tabelul comanda
    $stmt = $pdo->prepare("INSERT INTO comanda (id_utilizator, total, status, data_comanda) VALUES (?, ?, 'plasată', NOW())");
    $stmt->execute([$_SESSION['id_utilizator'], $total]);
    $id_comanda = $pdo->lastInsertId();

    // Inserare produse comandate în tabelul comenzi_produse
    foreach ($_SESSION['cart'] as $item) {
        $stmt2 = $pdo->prepare("INSERT INTO comenzi_produse (id_comanda, id_produs, cantitate) VALUES (?, ?, ?)");
        $stmt2->execute([$id_comanda, $item['id_produs'], $item['cantitate']]);
    }

    // Golește coșul
    $_SESSION['cart'] = [];

    echo json_encode(['success' => true, 'message' => 'Comanda a fost plasată.', 'id_comanda' => $id_comanda]);
    exit;
}

/* Actualizare coș (pentru fetch) */
if (isset($_GET['update_cart'])) {
    $cart = $_SESSION['cart'] ?? [];
    header('Content-Type: application/json');
    echo json_encode($cart);
    exit;
}

/* Adaugă produs în coș */
$id_produs = isset($_POST['id_produs']) ? (int)$_POST['id_produs'] : 0;
$cantitate = isset($_POST['cantitate']) ? (int)$_POST['cantitate'] : 1;

if ($id_produs <= 0 || $cantitate <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Date invalide.']);
    exit;
}

// Preluare produs din DB
$stmt = $pdo->prepare("SELECT id_produs, nume_produs, pret FROM produse WHERE id_produs = ? LIMIT 1");
$stmt->execute([$id_produs]);
$produs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produs) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Produs inexistent.']);
    exit;
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

echo json_encode(['success' => true, 'message' => 'Produs adăugat în coș.']);
