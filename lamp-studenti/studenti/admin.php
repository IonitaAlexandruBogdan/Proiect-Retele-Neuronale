<?php
session_start();
require_once 'db.php';

$esteLogat = isset($_SESSION['username']);
$esteAdmin = $esteLogat && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

/* protecție admin */
if (!isset($_SESSION['id_utilizator']) || $_SESSION['rol'] !== 'admin') {
    exit('Acces interzis');
}

/* COMENZI */
$comenzi = $pdo->query("
    SELECT c.id_comanda, u.username, c.total, c.status, c.data_comanda
    FROM comanda c
    JOIN utilizatori u ON c.id_utilizator = u.id_utilizator
    ORDER BY c.data_comanda DESC
")->fetchAll();

/* UTILIZATORI */
$utilizatori = $pdo->query("
    SELECT id_utilizator, username, rol
    FROM utilizatori
    ORDER BY id_utilizator DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg"> 
<style>
.admin-section { width: 90%; max-width: 1200px; margin: 40px auto; }
h2 { color: #c8102e; margin-bottom: 20px; text-align: center; }
.card { background: #fff4f4; border: 2px solid #c8102e; border-radius: 12px; padding: 20px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.2s, box-shadow 0.2s; }
.card:hover { transform: translateY(-5px); box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
.card h3 { color: #c8102e; margin-bottom: 15px; }
.card ul { list-style: none; padding-left: 0; }
.card ul li { margin-bottom: 8px; }
.card .btn { padding: 6px 12px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.3s; }
.btn-delete { background: #d62300; color: white; }
.btn-delete:hover { background: #a00; }
.btn-gray { background: #555; color: white; }
.btn-gray:hover { background: #333; }
.btn-small { padding: 5px 10px; border-radius: 6px; border: none; cursor: pointer; background: #c8102e; color: white; font-weight: bold; }
.btn-small:hover { background: #a50f26; }

.table-users { width: 100%; border-collapse: collapse; }
.table-users th, .table-users td { padding: 10px; text-align: left; }
.table-users th { background: #c8102e; color: white; }
.table-users tr:nth-child(even) { background: #fff0f0; }
.table-users tr:hover { background: #ffe5e5; }
select.status-select { padding:4px; border-radius:5px; }
</style>
</head>
<body>

<div class="page-grid">
  
  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg" height="70" alt="KFC Logo">
    </div>
    <nav>
      <ul>
        <li><a href="index.php" class="active">Acasă</a></li>
        <li><a href="produse.php">Produse</a></li>
        <li><a href="oferte.php">Oferte</a></li>
        <li><a href="restaurante.php">Restaurante</a></li>
        <li><a href="kfcinromania.php">KFC România</a></li>
        <li><a href="istorie-kfc.php">Istorie KFC</a></li>
        <li><a href="comanda.php">Comandă Acum</a></li>
        <?php if ($esteAdmin): ?>
        <li><a href="admin.php" style="color:#ffcc00;font-weight:bold;">Admin Panel</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['username'])): ?>
          <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
        <?php else: ?>
          <li><a href="login.php" class="active">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

<div class="admin-section">

    <h2>Comenzi</h2>

    <?php foreach ($comenzi as $c): ?>
    <div class="card">
        <h3>Comanda #<?= $c['id_comanda'] ?> - <?= htmlspecialchars($c['username']) ?></h3>
        <p><strong>Total:</strong> <?= number_format($c['total'],2) ?> lei | 
           <strong>Status:</strong> 
           <form method="post" action="user_admin.php" style="display:inline-block; margin-left:5px;">
               <input type="hidden" name="id_comanda" value="<?= $c['id_comanda'] ?>">
               <select name="status" class="status-select">
                   <option value="plasată" <?= $c['status']=='plasată'?'selected':'' ?>>Plasată</option>
                   <option value="în pregătire" <?= $c['status']=='în pregătire'?'selected':'' ?>>În pregătire</option>
                   <option value="livrată" <?= $c['status']=='livrată'?'selected':'' ?>>Livrată</option>
               </select>
               <button type="submit" class="btn-small">Actualizează</button>
           </form>
           | <strong>Data:</strong> <?= $c['data_comanda'] ?>
        </p>

        <?php
        $stmt = $pdo->prepare("
            SELECT p.nume_produs, cp.cantitate, p.pret, p.imagine
            FROM comenzi_produse cp
            JOIN produse p ON cp.id_produs = p.id_produs
            WHERE cp.id_comanda = ?
        ");
        $stmt->execute([$c['id_comanda']]);
        $produse = $stmt->fetchAll();
        ?>
        <ul>
        <?php foreach ($produse as $p): ?>
            <li>
                <?php if (!empty($p['imagine'])): ?>
                    <img src="<?= $p['imagine'] ?>" alt="<?= htmlspecialchars($p['nume_produs']) ?>" style="width:50px;height:50px;object-fit:cover;border-radius:5px;vertical-align:middle;margin-right:10px;">
                <?php endif; ?>
                <?= htmlspecialchars($p['nume_produs']) ?> x <?= $p['cantitate'] ?> (<?= number_format($p['pret'],2) ?> lei)
            </li>
        <?php endforeach; ?>
        </ul>

        <a href="user_admin.php?delete_id=<?= $c['id_comanda'] ?>" class="btn btn-delete" onclick="return confirm('Ștergi comanda?')">🗑 Șterge comanda</a>
    </div>
    <?php endforeach; ?>

    <h2>Utilizatori</h2>
    <table class="table-users">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Rol</th>
            <th>Acțiuni</th>
        </tr>
        <?php foreach ($utilizatori as $u): ?>
        <tr>
            <td><?= $u['id_utilizator'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= $u['rol'] ?></td>
            <td>
                <form method="post" action="user_admin.php" style="display:inline">
                    <input type="hidden" name="id" value="<?= $u['id_utilizator'] ?>">
                    <input type="hidden" name="action" value="toggle_role">
                    <button class="btn btn-gray">Schimbă rol</button>
                </form>

                <form method="post" action="user_admin.php" style="display:inline">
                    <input type="hidden" name="id" value="<?= $u['id_utilizator'] ?>">
                    <input type="hidden" name="action" value="reset_pass">
                    <button class="btn btn-delete">Reset parolă</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

  <!-- SCRIPT BUTON SUS -->
  <button id="backToTop" title="Înapoi sus"><span class="arrow-up"></span></button>

  <script>
    const backToTop = document.getElementById("backToTop");
    window.onscroll = function () {
      backToTop.style.display = (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) ? "flex" : "none";
    };
    backToTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
  </script>

</body>
</html>
