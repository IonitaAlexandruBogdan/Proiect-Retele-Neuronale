<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id_utilizator'])) {
    header("Location: login.php?error=Trebuie+sa+te+loghezi");
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: comanda.php?error=Cos+gol");
    exit;
}

$id_utilizator = $_SESSION['id_utilizator'];

// 1. Adaugam comanda
$stmt = $pdo->prepare("INSERT INTO comanda (id_utilizator) VALUES (?)");
$stmt->execute([$id_utilizator]);

$id_comanda = $pdo->lastInsertId();

// 2. Adaugam produsele in comenzi_produse
$stmt2 = $pdo->prepare("INSERT INTO comenzi_produse (id_comanda, id_produs, cantitate) VALUES (?, ?, ?)");

foreach ($_SESSION['cart'] as $produs) {
    $stmt2->execute([$id_comanda, $produs['id_produs'], $produs['cantitate']]);
}

// 3. Golim cosul
$_SESSION['cart'] = [];

header("Location: comanda.php?success=Comanda+trimisa+cu+succes");
exit;
?>
