<?php
session_start();
require_once 'db.php'; // conexiunea ta PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Verificăm dacă parolele coincid
    if ($password !== $confirm_password) {
        header("Location: register.php?error=Parolele+nu+coincid");
        exit;
    }

    // 2. Verificăm dacă username sau email există deja
    $stmt = $pdo->prepare("SELECT id_utilizator FROM utilizatori WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        header("Location: register.php?error=Username+sau+email+existent");
        exit;
    }

    // 3. Hash-uim parola
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Inserăm în baza de date
    $stmt = $pdo->prepare("INSERT INTO utilizatori (username, parola, email, rol) VALUES (?, ?, ?, 'client')");
    if ($stmt->execute([$username, $password_hash, $email])) {
        header("Location: register.php?success=Cont+creat+cu+succes");
        exit;
    } else {
        header("Location: register.php?error=Eroare+la+crearea+contului");
        exit;
    }
}
