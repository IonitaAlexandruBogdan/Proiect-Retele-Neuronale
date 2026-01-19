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
  <title>Restaurante KFC România</title>
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
      <li><a href="#" class="active">Restaurante</a></li>
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

      <?php if (isset($_SESSION['username'])): ?>
  <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
<?php else: ?>
  <li><a href="login.php" class="active">Login</a></li>
<?php endif; ?>
    </ul>
  </nav>
</header>

<section class="page-banner">
  <h1>Restaurante KFC în România</h1>
</section>

<section class="content-section">
  <h2>Găsește cel mai apropiat KFC</h2>
  <p>
    Aripioare, crispy, sosuri și vibe relaxat. Alege orașul tău și hai să mâncăm:
  </p>

  <div class="restaurant-grid">

    <div class="restaurant-card">
      <h3>București</h3>
      <p>15+ locații în mall-uri și zone centrale</p>
      <a href="#" class="btn-small" onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3383.3118209916333!2d26.050068012300347!3d44.43101467095536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b201d040a36767%3A0x603a973914f8021c!2sKFC!5e1!3m2!1sen!2sro!4v1761570688113!5m2!1sen!2sro')">Vezi restaurante</a>
    </div>

    <div class="restaurant-card">
      <h3>Cluj-Napoca</h3>
      <p>Iulius Mall, Vivo și zone populare</p>
      <a href="#" class="btn-small" onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.1931129361137!2d23.588444801742323!3d46.76914304544589!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47490e9d64c517d9%3A0x78966373e993123a!2sKFC%20Cluj-Napoca%20Centru!5e1!3m2!1sro!2sro!4v1762173166273!5m2!1sro!2sro')">Vezi restaurante</a>
    </div>

    <div class="restaurant-card">
      <h3>Timișoara</h3>
      <p>Shopping City și centrul orașului</p>
      <a href="#" class="btn-small" onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1692628.7112354983!2d18.785821456249998!3d45.752573300000016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47455d7f6db87d8f%3A0xa38e72a8787b4f2f!2sKFC%20Timi%C8%99oara%20Centru!5e1!3m2!1sro!2sro!4v1762173576382!5m2!1sro!2sro')">Vezi restaurante</a>
    </div>

    <div class="restaurant-card">
      <h3>Iași</h3>
      <p>Palas, Iulius Mall și împrejurimi</p>
      <a href="#" class="btn-small" onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1691643.122256052!2d25.47327172726293!3d45.78506158198707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafb9c10dc0695%3A0xd50ef4298d8452dc!2sKFC%20Ia%C8%99i%20Palas%20Drive-Thru!5e1!3m2!1sro!2sro!4v1762173376194!5m2!1sro!2sro')">Vezi restaurante</a>
    </div>

    <div class="restaurant-card">
      <h3>Brașov</h3>
      <p>Coresi și centrul istoric</p>
      <a href="#" class="btn-small" onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52969.25503160469!2d25.57449234123244!3d45.67380053610503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b35befcbdde857%3A0x6a80f9678129ff46!2sKFC%20Bra%C8%99ov%20Coresi!5e1!3m2!1sro!2sro!4v1762173433623!5m2!1sro!2sro')">Vezi restaurante</a>
    </div>

    <div class="restaurant-card">
      <h3>Constanța</h3>
      <p>Mamaia și stațiuni de vară</p>
      <a href="#" class="btn-small" onclick="changeMap('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3396.399120645686!2d28.633895000000003!3d44.20448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40baf009ca3c3b39%3A0xb959233bbd442b8c!2sKFC%20Constan%C8%9Ba%20City%20Park!5e1!3m2!1sro!2sro!4v1762173461354!5m2!1sro!2sro')">Vezi restaurante</a>
    </div>

  </div>

  <h2>Localizează-ne pe hartă</h2>
  <div class="map-box">
    <iframe id="kfcMap"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2849.452987818264!2d26.1031996!3d44.4288023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b1ff35e7efe3eb%3A0x9b5a35e7ede36f7e!2sKFC%20Unirii!5e0!3m2!1sro!2sro!4v1727618913312!5m2!1sro!2sro"
      allowfullscreen=""
      loading="lazy">
    </iframe>
  </div>
</section>

<!-- SCRIPT MAP -->
<script>
  function changeMap(url) {
    document.getElementById("kfcMap").src = url;
    // derulează automat la hartă
    document.getElementById("kfcMap").scrollIntoView({ behavior: "smooth", block: "center" });
  }
</script>

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
    <p>&copy; 2025 KFC România - Pagina demonstrativă</p>
    <p>Urmărește-ne pe 
      <a href="https://www.facebook.com/KFC.Romania/">Facebook</a> |
      <a href="https://www.instagram.com/kfc/?hl=en">Instagram</a> |
      <a href="https://www.youtube.com/user/kfcro">YouTube</a>
    </p>
  </div>
</footer>

</body>
</html>
