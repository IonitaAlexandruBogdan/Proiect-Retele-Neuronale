<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id_utilizator']) || $_SESSION['rol'] !== 'admin') {
    exit('Acces interzis');
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) exit;

$pdo->prepare("DELETE FROM comenzi_produse WHERE id_comanda=?")->execute([$id]);
$pdo->prepare("DELETE FROM comanda WHERE id_comanda=?")->execute([$id]);

header("Location: admin.php");
exit;
