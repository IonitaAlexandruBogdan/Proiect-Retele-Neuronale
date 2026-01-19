<?php
session_start();

$esteLogat = isset($_SESSION['username']);
$esteAdmin = $esteLogat && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Oferte - KFC România</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg"> 
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
    <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg " height="70" alt="KFC Logo">
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Acasă</a></li>
      <li><a href="produse.php">Produse</a></li>
      <li><a href="oferte.php" class="active">Oferte</a></li>
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

      <?php if (isset($_SESSION['username'])): ?>
  <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
<?php else: ?>
  <li><a href="login.php" class="active">Login</a></li>
<?php endif; ?>
    </ul>
  </nav>
</header>

<section class="produse">
  <h2>Oferte Speciale</h2>
  <div class="produse-grid">

    <div class="produs">
      <img src="https://api.kfc.ro/uploads/meniu_kentucky_d77c30cedf.jpg" alt="Oferta">
      <h3>Meniu Kentucky</h3>
      <p><span class="pret-vechi">32,40 lei</span> <span class="pret-redus">25,00 lei</span></p>
      <a href="#" class="btn-small">Detalii</a>
    </div>

    <div class="produs">
      <img src="https://api.kfc.ro/uploads/non_spicy_bucket_e613b4ef59.jpg" alt="Bucket Oferta">
      <h3>Non-Spicy Bucket</h3>
      <p><span class="pret-vechi">56,00 lei</span> <span class="pret-redus">47,90 lei</span></p>
      <a href="#" class="btn-small">Detalii</a>
    </div>

    <div class="produs">
      <img src="FREESTRIPS.jpg" alt="Strips">
      <h3>Strips Deal</h3>
      <p><span class="pret-vechi">19,90 lei</span> <span class="pret-redus">14,90 lei</span></p>
      <a href="#" class="btn-small">Detalii</a>
    </div>

  </div>
</section>
  <!-- BUTON BACK TO TOP -->
  <button id="backToTop" title="Înapoi sus">
    <span class="arrow-up"></span>
  </button>

  <script>
    // Afișează butonul când utilizatorul derulează
    const backToTop = document.getElementById("backToTop");
    window.onscroll = function () {
      if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        backToTop.style.display = "flex";
      } else {
        backToTop.style.display = "none";
      }
    };

    // Când se apasă, duce pagina înapoi sus
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
  <script>
  // datele produselor
  const produseInfo = {
    "Marți Bucket": {
      descriere: "Marți Bucket conține bucăți suculente de pui crocant, perfecte de împărțit cu prietenii.",
      pret: "32,90 lei",
      imagine: "https://api.kfc.ro/uploads/Imagine_Card_664x496_a0f1c4bd8e.png"
    },
    "Meniu Kentucky": {
      descriere: "Bucăți de pui nepicante, condimentate cu cele 11 ingrediente secrete ale Colonelului. Un meniu #pebune: 2 bucăți de pui Kentucky® nepicante, porție medie de cartofi prăjiți cu o răcoritoare Coca-Cola/Coca-Cola Zero/Fanta/ Sprite 0,4L.",
      pret: "25,00 lei (redus de la 32,40 lei)",
      imagine: "https://api.kfc.ro/uploads/meniu_kentucky_d77c30cedf.jpg"
    },
    "Non-Spicy Bucket": {
      descriere: "Un bucket ideal pentru cei care preferă gustul original fără pic de iuțeală.",
      pret: "47,90 lei (redus de la 56,00 lei)",
      imagine: "https://api.kfc.ro/uploads/non_spicy_bucket_e613b4ef59.jpg"
    },
    "Twister": {
      descriere: "Același pui KFC, dar cu un twist! Crispy Strips sau Strips Nepicanți înveliți în tortilla alături de roșii, salată Iceberg și sos burger.",
      pret: "19,90 lei",
      imagine: "Twister-KFC-Chicken-Wrap-DH-TOH-Courtesy-KFC.jpg"
    },
    "Strips Deal": {
      descriere: "Piept de pui preparat după rețeta Hot & Spicy, crocant la exterior și fraged la interior. All time favorites: Crispy Strips.Alege între 3, 5 sau 8 Crispy Strips. În varianta cu 5 sau 8 Crispy Strips ai alături sosul tău preferat, iar varianta cu 3 Crispy Strips nu conţine sos.",
      pret: "14,90 lei",
      imagine: "FREESTRIPS.jpg"
    },
    "Zinger": {
      descriere: "Clasic, simplu și delicios! 100% piept de pui crocant și picant, salată Iceberg și sos burger, plus chiflă proaspătă! Zinger Burger, corect!",
      pret: "15,00 lei",
      imagine: "zinger_1024x1024@2x.jpg"
    }
  };

  // selectăm elementele popup-ului
  const popup = document.getElementById("popup");
  const popupTitle = document.getElementById("popup-title");
  const popupDesc = document.getElementById("popup-desc");
  const popupPrice = document.getElementById("popup-price");
  const popupImg = document.getElementById("popup-img");
  const closeBtn = document.querySelector(".close");

  // funcție pentru deschiderea popup-ului  
  function deschidePopup(numeProdus) {
    const produs = produseInfo[numeProdus];
    popupTitle.textContent = numeProdus;
    popupDesc.textContent = produs.descriere;
    popupPrice.textContent = "Preț: " + produs.pret;
    popupImg.src = produs.imagine;
    popup.style.display = "flex";
  }

  // închidere popup
  closeBtn.onclick = () => popup.style.display = "none";
  window.onclick = (e) => { if (e.target === popup) popup.style.display = "none"; };

  // atașăm evenimente la butoanele „Detalii”
  document.querySelectorAll(".btn-small").forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const numeProdus = btn.parentElement.querySelector("h3").textContent;
      deschidePopup(numeProdus);
    });
  });
</script>
</body>
</html>
