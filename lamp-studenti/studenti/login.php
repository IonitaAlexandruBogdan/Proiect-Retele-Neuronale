<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Autentificare - KFC România</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg"> 
</head>
<body>

  <!-- HEADER -->
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
        <li><a href="istorie-kfc.php">Istorie KFC</a></li>
        <li><a href="comanda.php">Comandă Acum</a></li>
        <li><a href="login.php" class="active">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- FORMULAR LOGIN -->
  <section class="login-container">
    <div class="login-box">
      <h2>Autentificare</h2>

      <!-- AFISARE MESAJ EROARE -->
      <?php if (isset($_GET['error'])): ?>
        <p style="color:red; font-weight:bold;"><?= htmlspecialchars($_GET['error']) ?></p>
      <?php endif; ?>

      <form action="login_process.php" method="post">

        <label for="username">Utilizator</label>
        <input type="text" id="username" name="username" placeholder="Nume utilizator" required>

        <label for="password">Parolă</label>
        <input type="password" id="password" name="password" placeholder="Parola" required>

        <button type="submit" class="btn">Conectează-te</button>

        <p class="register-link">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
      </form>
    </div>
  </section>

  <!-- BUTON BACK TO TOP -->
  <button id="backToTop" title="Înapoi sus">
    <span class="arrow-up"></span>
  </button>

  <script>
    const backToTop = document.getElementById("backToTop");
    window.onscroll = function () {
      backToTop.style.display = (window.scrollY > 200) ? "flex" : "none";
    };
    backToTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
  </script>

  <!-- FOOTER -->
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
