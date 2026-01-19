<?php
session_start();
require_once 'db.php';

/* Protecție admin */
if (!isset($_SESSION['id_utilizator']) || $_SESSION['rol'] !== 'admin') {
    exit('Acces interzis');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Schimbare rol sau reset parolă
    if (isset($_POST['id'], $_POST['action'])) {
        $id = (int)$_POST['id'];
        $action = $_POST['action'];

        if ($action === 'toggle_role') {
            $stmt = $pdo->prepare("SELECT rol FROM utilizatori WHERE id_utilizator = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();

            if ($user) {
                $nouRol = ($user['rol'] === 'admin') ? 'client' : 'admin';
                $stmt = $pdo->prepare("UPDATE utilizatori SET rol=? WHERE id_utilizator=?");
                $stmt->execute([$nouRol, $id]);
            }
        }

        if ($action === 'reset_pass') {
            $nouPass = password_hash('parola123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE utilizatori SET parola=? WHERE id_utilizator=?");
            $stmt->execute([$nouPass, $id]);
        }
    }

    // Schimbare status comandă
    if (isset($_POST['id_comanda'], $_POST['status'])) {
        $id_comanda = (int)$_POST['id_comanda'];
        $status = $_POST['status'];

        // Validăm să fie doar una dintre valorile permise
        $statusPermis = ['plasată', 'în pregătire', 'livrată'];
        if (in_array($status, $statusPermis)) {
            $stmt = $pdo->prepare("UPDATE comanda SET status=? WHERE id_comanda=?");
            $stmt->execute([$status, $id_comanda]);
        }
    }

    header("Location: admin.php");
    exit;
}

// Ștergere comandă (GET)
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    if ($id > 0) {
        $pdo->prepare("DELETE FROM comenzi_produse WHERE id_comanda=?")->execute([$id]);
        $pdo->prepare("DELETE FROM comanda WHERE id_comanda=?")->execute([$id]);
    }
    header("Location: admin.php");
    exit;
}
?>
