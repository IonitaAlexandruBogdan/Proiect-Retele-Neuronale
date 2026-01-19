<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Înregistrare - KFC România</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg"> 
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
      <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg " height="70" alt="KFC Logo">
    </div>
    <nav>
      <ul>
        <li><a href="index.html">Acasă</a></li>
        <li><a href="produse.html">Produse</a></li>
        <li><a href="oferte.html">Oferte</a></li>
        <li><a href="restaurante.html">Restaurante</a></li>
        <li><a href="kfcinromania.html">KFC România</a></li>
        <li><a href="istorie-kfc.html">Istorie KFC</a></li>
        <li><a href="comanda.html">Comandă Acum</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

  <!-- FORMULAR ÎNREGISTRARE -->
  <section class="login-container">
    <div class="login-box">
      <h2>Creează un cont</h2>

      <!-- AFISARE MESAJ DE EROARE / SUCCES -->
      <?php
      if (isset($_GET['error'])) {
          echo '<p style="color:red; font-weight:bold;">' . htmlspecialchars($_GET['error']) . '</p>';
      }
      if (isset($_GET['success'])) {
          echo '<p style="color:green; font-weight:bold;">' . htmlspecialchars($_GET['success']) . '</p>';
      }
      ?>

      <form action="register_process.php" method="post">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="nume@gmail.com" required>

        <label for="username">Utilizator</label>
        <input type="text" id="username" name="username" placeholder="Alege un username" required>

        <label for="password">Parolă</label>
        <input type="password" id="password" name="password" placeholder="Alege o parolă" required>

        <label for="confirm_password">Confirmă parola</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Reintrodu parola" required>

        <button type="submit" class="btn">Înregistrează-te</button>

        <p class="register-link">Ai deja cont?  
          <a href="login.php">Autentifică-te</a>
        </p>

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
      backToTop.style.display = (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) ? "flex" : "none";
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
