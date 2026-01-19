<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id_utilizator, username, parola, rol FROM utilizatori WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch();

    if ($row) {
        if (password_verify($pass, $row['parola'])) {
            $_SESSION['id_utilizator'] = $row['id_utilizator'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['rol'] = $row['rol'];

            header("Location: index.php");
            exit;
        } else {
            // parola greșită
            header("Location: login.php?error=Parola+greșită");
            exit;
        }
    } else {
        // utilizatorul nu există
        header("Location: login.php?error=Utilizator+inexistent");
        exit;
    }

} 
