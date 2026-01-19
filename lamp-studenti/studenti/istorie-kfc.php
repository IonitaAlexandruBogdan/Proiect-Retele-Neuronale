<?php
session_start();

$esteLogat = isset($_SESSION['username']);
$esteAdmin = $esteLogat && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Istoria KFC</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg"> 
</head>
<body>

<header>
  <div class="logo">
    <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg" height="70" alt="KFC Logo">
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Acasă</a></li>
      <li><a href="produse.php">Produse</a></li>
      <li><a href="oferte.php">Oferte</a></li>
      <li><a href="restaurante.php">Restaurante</a></li>
      <li><a href="kfcinromania.php">KFC România</a></li>
      <li><a href="istorie-kfc.php" class="active">Istorie KFC</a></li>
      <li><a href="comanda.php">Comandă Acum</a></li>

            <?php if ($esteAdmin): ?>
        <li>
          <a href="admin.php" style="color:#ffcc00;font-weight:bold;">
            Admin Panel
          </a>
        </li>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['username'])): ?>
  <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
<?php else: ?>
  <li><a href="login.php" class="active">Login</a></li>
<?php endif; ?>
    </ul>
  </nav>
</header>

<section class="info-section">
  <h2>Istoria KFC în lume</h2>
  <p class="info-text">
    KFC (Kentucky Fried Chicken) este unul dintre cele mai cunoscute lanțuri de restaurante fast-food din lume, specializat în pui prăjit. Fondatorul său, Colonelul Harland Sanders, a dezvoltat rețeta originală cu 11 ierburi și condimente secrete în anii 1930, în Kentucky, SUA.
  </p>

  <div class="timeline">
    <div class="timeline-item">
      <span class="year">1930</span>
      <p>Harland Sanders începe să prepare pui prăjit și sosuri speciale într-o benzinărie din Corbin, Kentucky.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1952</span>
      <p>Se deschide primul restaurant KFC în Salt Lake City, Utah, punând bazele rețelei internaționale.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1964</span>
      <p>KFC devine unul dintre primele lanțuri fast-food americane cu peste 600 de restaurante.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1965</span>
      <p>Lanțul este achiziționat de Heublein Inc., facilitând expansiunea internațională.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1967</span>
      <p>Se deschid primele restaurante KFC în Canada, primul pas major în expansiunea globală.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1970</span>
      <p>KFC intră pe piețele europene și asiatice, extinzându-se rapid la nivel mondial.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1987</span>
      <p>KFC devine primul lanț american de fast-food care deschide restaurante în China, marcând succesul internațional.</p>
    </div>
    <div class="timeline-item">
      <span class="year">1997</span>
      <p>Se lansează în România, intrând pe piața europeană de est.</p>
    </div>
    <div class="timeline-item">
      <span class="year">2025</span>
      <p>Brandul KFC are peste 25.000 de restaurante în întreaga lume, continuând să fie sinonim cu puiul prăjit și inovația în meniuri.</p>
    </div>
  </div>

  <p class="info-text">
    De-a lungul anilor, KFC a devenit un simbol global al puiului prăjit, adaptându-și meniurile în funcție de culturile locale și lansând produse exclusive pentru anumite piețe, cum ar fi meniurile picante din Asia sau Twister și Cheesy Wedges în Europa.
  </p>

  <img src="harta.png" alt="Restaurant KFC" class="istorie">

</section>

<!-- BUTON BACK TO TOP -->
<button id="backToTop" title="Înapoi sus">
  <span class="arrow-up"></span>
</button>

<script>
  const backToTop = document.getElementById("backToTop");
  window.onscroll = function () {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
      backToTop.style.display = "flex";
    } else {
      backToTop.style.display = "none";
    }
  };
  backToTop.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
</script>

<footer>
  <div class="footer-content">
    <p>&copy; 2025 KFC - Pagina demonstrativă</p>
    <p>Urmărește-ne pe 
      <a href="https://www.facebook.com/KFC.Romania/">Facebook</a> |
      <a href="https://www.instagram.com/kfc/?hl=en">Instagram</a> |
      <a href="https://www.youtube.com/user/kfcro">YouTube</a>
    </p>
  </div>
</footer>

</body>
</html>
