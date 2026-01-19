<?php
session_start();
require_once '../db.php';

/* verificare login si rol admin */
if (!isset($_SESSION['id_utilizator']) || $_SESSION['rol'] !== 'admin') {
    echo "Acces interzis!";
    exit;
}

/* Preluăm comenzile împreună cu numele clientului */
$stmt = $pdo->query("
    SELECT c.id_comanda, u.username, c.total, c.status, c.data_comenzii
    FROM comanda c
    JOIN utilizatori u ON c.id_utilizator = u.id_utilizator
    ORDER BY c.data_comenzii DESC
");
$comenzi = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Admin – Comenzi Detaliate</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        a { color: red; text-decoration: none; }
        .produs-table { margin-left: 20px; width: 95%; }
        .produs-table th { background: #f8f8f8; }
    </style>
</head>
<body>

<h2> Lista Comenzilor Detaliate</h2>

<?php foreach ($comenzi as $c): ?>
    <table>
        <tr>
            <th>ID Comandă</th>
            <th>Client</th>
            <th>Total</th>
            <th>Status</th>
            <th>Data</th>
            <th>Acțiune</th>
        </tr>
        <tr>
            <td><?= $c['id_comanda'] ?></td>
            <td><?= htmlspecialchars($c['username']) ?></td>
            <td><?= number_format($c['total'], 2) ?> RON</td>
            <td><?= htmlspecialchars($c['status']) ?></td>
            <td><?= $c['data_comenzii'] ?></td>
            <td>
                <a href="sterge_comanda.php?id=<?= $c['id_comanda'] ?>"
                   onclick="return confirm('Sigur ștergi comanda?')">
                    Șterge
                </a>
            </td>
        </tr>

        <!-- Produsele comenzii -->
        <tr>
            <td colspan="6">
                <table class="produs-table">
                    <tr>
                        <th>Produs</th>
                        <th>Cantitate</th>
                        <th>Preț Unitar</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php
                    $stmt2 = $pdo->prepare("
                        SELECT p.nume_produs, cp.cantitate, p.pret
                        FROM comenzi_produse cp
                        JOIN produse p ON cp.id_produs = p.id_produs
                        WHERE cp.id_comanda = ?
                    ");
                    $stmt2->execute([$c['id_comanda']]);
                    $produse = $stmt2->fetchAll();
                    foreach ($produse as $produs):
                        $subtotal = $produs['pret'] * $produs['cantitate'];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($produs['nume_produs']) ?></td>
                        <td><?= $produs['cantitate'] ?></td>
                        <td><?= number_format($produs['pret'], 2) ?> RON</td>
                        <td><?= number_format($subtotal, 2) ?> RON</td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    </table>
<?php endforeach; ?>

</body>
</html>
