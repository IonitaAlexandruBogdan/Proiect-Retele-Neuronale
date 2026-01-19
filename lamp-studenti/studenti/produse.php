<?php
session_start();
require_once 'db.php';

/* verificăm login + rol */
$esteLogat = isset($_SESSION['username']);
$esteAdmin = $esteLogat && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

/* extragem doar produsele disponibile */
$stmt = $pdo->query("
    SELECT id_produs, nume_produs, descriere, pret, categorie, imagine
    FROM produse
    WHERE disponibil = 1
");
$produse = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produse - KFC România</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png"
        href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg">
</head>

<!-- POPUP PRODUSE -->
<div id="popup" class="popup">
  <div class="popup-content">
    <span class="close">&times;</span>
    <h2 id="popup-title"></h2>
    <img id="popup-img" src="" alt="Produs" />
    <p id="popup-desc"></p>
    <p id="popup-price"></p>
  </div>
</div>

<body>

<header>
  <div class="logo">
    <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg"
         height="70" alt="KFC Logo">
  </div>

  <nav>
    <ul>
      <li><a href="index.php">Acasă</a></li>
      <li><a href="produse.php" class="active">Produse</a></li>
      <li><a href="oferte.php">Oferte</a></li>
      <li><a href="restaurante.php">Restaurante</a></li>
      <li><a href="kfcinromania.php">KFC România</a></li>
      <li><a href="istorie-kfc.php">Istorie KFC</a></li>
      <li><a href="comanda.php">Comandă Acum</a></li>

      <?php if ($esteAdmin): ?>
        <li>
          <a href="admin.php" style="color:#ffcc00;font-weight:bold;">
            Admin Panel
          </a>
        </li>
      <?php endif; ?>

      <?php if ($esteLogat): ?>
        <li>
          <a href="logout.php">
            Logout (<?= htmlspecialchars($_SESSION['username']) ?>)
          </a>
        </li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<section class="produse">
  <h2>Toate Produsele</h2>

  <div class="produse-grid">
    <?php foreach ($produse as $p): ?>
      <div class="produs">
        <img
          src="<?= htmlspecialchars($p['imagine'] ?? 'default.jpg') ?>"
          alt="<?= htmlspecialchars($p['nume_produs']) ?>">

        <h3><?= htmlspecialchars($p['nume_produs']) ?></h3>

        <p>Preț: <?= number_format($p['pret'], 2) ?> lei</p>

        <a href="#"
           class="btn-small"
           data-nume="<?= htmlspecialchars($p['nume_produs']) ?>"
           data-desc="<?= htmlspecialchars($p['descriere']) ?>"
           data-pret="<?= number_format($p['pret'], 2) ?> lei"
           data-img="<?= htmlspecialchars($p['imagine'] ?? 'default.jpg') ?>">
          Detalii
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- BUTON BACK TO TOP -->
<button id="backToTop" title="Înapoi sus">
  <span class="arrow-up"></span>
</button>

<footer>
  <div class="footer-content">
    <p>&copy; 2025 KFC România - Pagina demonstrativă</p>
    <p>
      Urmărește-ne pe
      <a href="https://www.facebook.com/KFC.Romania/">Facebook</a> |
      <a href="https://www.instagram.com/kfc/?hl=en">Instagram</a> |
      <a href="https://www.youtube.com/user/kfcro">YouTube</a>
    </p>
  </div>
</footer>

<script>
/* ================= POPUP ================= */
const popup = document.getElementById("popup");
const popupTitle = document.getElementById("popup-title");
const popupDesc = document.getElementById("popup-desc");
const popupPrice = document.getElementById("popup-price");
const popupImg = document.getElementById("popup-img");
const closeBtn = document.querySelector(".close");

document.querySelectorAll(".btn-small").forEach(btn => {
  btn.addEventListener("click", e => {
    e.preventDefault();
    popupTitle.textContent = btn.dataset.nume;
    popupDesc.textContent = btn.dataset.desc;
    popupPrice.textContent = "Preț: " + btn.dataset.pret;
    popupImg.src = btn.dataset.img;
    popup.style.display = "flex";
  });
});

closeBtn.onclick = () => popup.style.display = "none";
window.onclick = e => {
  if (e.target === popup) popup.style.display = "none";
};

/* ================= BACK TO TOP ================= */
const backToTop = document.getElementById("backToTop");
window.onscroll = () => {
  backToTop.style.display = window.scrollY > 200 ? "flex" : "none";
};
backToTop.onclick = () =>
  window.scrollTo({ top: 0, behavior: "smooth" });
</script>

</body>
</html>
