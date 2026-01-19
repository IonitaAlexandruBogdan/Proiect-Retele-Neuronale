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
  <title>KFC în România</title>
  <link rel="stylesheet" href="style.css">
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
    <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg" height="70" alt="KFC Logo">
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Acasă</a></li>
      <li><a href="produse.php">Produse</a></li>
      <li><a href="oferte.php">Oferte</a></li>
            <li><a href="restaurante.php">Restaurante</a></li>
      <li><a href="#" class="active">KFC România</a></li>
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
  <h1>KFC în România</h1>
</section>

<section class="content-section">
  <h2>Colonelul a ajuns și la noi</h2>
  <p>
    Primul KFC din România s-a deschis în 1997 în București. De atunci, brandul a crescut spectaculos, 
    ajungând în aproape toate orașele mari din țară. Românii iubesc crispy-ul, iar KFC ne răsplătește cu meniuri noi 
    și oferte tentante.
  </p>

  <section class="an-kfc">
  <div class="an-text">
    <h1 class="an-mare">1997</h1>
    <p class="sub-an">KFC a intrat pe piața din România în primăvara anului 1997, odată cu deschiderea primului restaurant în Piața Romană din București, operat în sistem de franciză. Brandul este administrat de compania US Food Network, parte a Sphera Franchise Group cel mai mare grup din industria food service din România.</p>
  </div>

  <img src="small_1997_ecbe405d1d.png" alt="KFC Logo">
</section>

  <section class="an-kfc">
  <img src="kfc-coffee-corner-cover-850.jpg" alt="KFC Logo">
  <div class="an-text">
    <h1 class="an-mare">2017</h1>
    <p class="sub-an">În 2017, KFC România a deschis primul „Coffee Corner” la restaurantul KFC Unirea din București, introducând sortimente de cafea și patiserie.</p>
  </div>
</section>

  <section class="an-kfc">
  <div class="an-text">
    <h1 class="an-mare">2024</h1>
    <p class="sub-an">În prezent, rețeaua KFC a ajuns la peste 100 de restaurante și peste 3,500 de colegi, în peste 40 de orașe la nivel național.</p>
  </div>

  <img src="kfc_sibiu_dt_1.jpg  " alt="KFC Logo">
</section>
<section id="produse-exclusive" class="produse-exclusive section">
  <div class="section-header">
    <h2>Produse (relativ) exclusive în România</h2>
    <p class="lead">O selecție de produse și sosuri care au fost lansate local sau sunt foarte asociate pieței românești.</p>
  </div>

  <div class="produse-exclusive-grid">
    <!-- Card 1 -->
    <article class="produs-card" role="article" aria-labelledby="prod-glenn">
      <img src="sosglenn.jpg"
           alt="Sos Glenn - sticlă" class="produs-img" width="360">
      <div class="produs-body">
        <h3 id="prod-glenn">Sos Glenn</h3>
        <p class="produs-desc">Un sos apreciat în România, cu note de usturoi și muștar — acompaniament popular pentru strips și cartofi.</p>
        <button class="btn-small btn-detalii" data-prod="glenn">Detalii</button>
      </div>
    </article>

    <!-- Card 2 -->
    <article class="produs-card" role="article" aria-labelledby="prod-cheezy">
      <img src="sos_crazy_cheezy120g_8c315f392a.png"
           alt="Sos Cheezy turnat peste cartofi" class="produs-img" width="360">
      <div class="produs-body">
        <h3 id="prod-cheezy">Crazy, Cheezy</h3>
        <p class="produs-desc">Sos cald, cremos, pe bază de brânză — folosit în meniuri Cheezy (Twister / Loaded Fries).</p>
        <button class="btn-small btn-detalii" data-prod="cheezy">Detalii</button>
      </div>
    </article>

    <!-- Card 3 -->
    <article class="produs-card" role="article" aria-labelledby="prod-veggie">
      <img src="veggie twister.png"
           alt="Twister vegetarian" class="produs-img" width="360">
      <div class="produs-body">
        <h3 id="prod-veggie">Gama Veggie (ediție limitată)</h3>
        <p class="produs-desc">Alternative vegetariene — Strips Veggie, Burger Veggie și Twister Veggie lansate în campanii locale.</p>
        <button class="btn-small btn-detalii" data-prod="veggie">Detalii</button>
      </div>
    </article>

    <!-- Card 4 -->
    <article class="produs-card" role="article" aria-labelledby="prod-teriyaki">
      <img src="KFC-Teriyaki.jpg"
           alt="Mâncare cu sos Teriyaki" class="produs-img" width="480">
      <div class="produs-body">
        <h3 id="prod-teriyaki">Linie Teriyaki</h3>
        <p class="produs-desc">Produse promoționale care au inclus Twister / strips cu sos Teriyaki — campanii sezoniere.</p>
        <button class="btn-small btn-detalii" data-prod="teriyaki">Detalii</button>
      </div>
    </article>
  </div>
</section>

<!-- Popup simplu (opțional) -->
<div id="prod-popup" class="popup" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="popup-content">
    <span class="close" id="popup-close" role="button" aria-label="Închide">&times;</span>
    <h2 id="popup-title">Detalii produs</h2>
    <p id="popup-text">Informații despre produs...</p>
    <img id="popup-img" src="" alt="" style="max-width:100%; border-radius:8px; margin-top:12px;">
  </div>
</div>

  <h3>Unde ne găsești?</h3>
  <ul class="lista-personalizata">
    <li>București</li>
    <li>Cluj-Napoca</li>
    <li>Timișoara</li>
    <li>Iași</li>
    <li>Brașov</li>
    <li>Constanța</li>
  </ul>
  

  <a href="restaurante.html" class="btn">Vezi toate restaurantele</a>
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

  
  <script>
  // datele produselor
  const produseInfo = {
    "Sos Glenn": {
      descriere: "Sosul Glenn este unul dintre cele mai apreciate produse locale ale KFC România. Rețeta sa a fost dezvoltată special pentru piața românească și combină aromele de usturoi și muștar într-un gust inconfundabil. De-a lungul timpului, a devenit un acompaniament emblematic pentru Crispy Strips, aripioare și cartofi prăjiți. Popularitatea sa a făcut ca sosul Glenn să fie menținut constant în meniu, fiind considerat de mulți fani un element definitoriu al experienței KFC în România.",
      pret: "17,00 lei",
      imagine: "sosglenn.jpg"
    },
    "Crazy, Cheezy": {
      descriere: "Crazy, e Cheezy este un sos cald, cremos, pe bază de brânză, introdus în România ca parte a unui concept care punea accent pe combinații „îndrăznețe și delicioase”. A fost folosit în special la produsele Cheezy Twister și Cheezy Loaded Fries, două dintre cele mai populare combinații din campaniile locale. Datorită gustului intens de brânză topită, acest sos a fost mereu bine primit în rândul clienților tineri, devenind un element de referință în meniurile promoționale. ",
      pret: "12.00 lei",
      imagine: "sos_crazy_cheezy120g_8c315f392a.png"
    },
    "Gama Veggie (ediție limitată)": {
      descriere: "Gama Veggie a reprezentat o inițiativă specială lansată în ediție limitată pentru a testa interesul consumatorilor români pentru produse fără carne. Au fost introduse Strips Veggie, Burger Veggie și Twister Veggie — toate cu o bază proteică vegetală, menite să reproducă textura și savoarea puiului crocant. Campania s-a adresat consumatorilor flexitarieni și celor curioși să încerce alternative moderne, într-un format KFC familiar.",
      pret: "13.50 lei",
      imagine: "veggie twister.png"
    },
    "Linie Teriyaki": {
      descriere: "Linia Teriyaki a fost introdusă pentru scurt timp ca o ediție limitată, inspirată din gusturile asiatice. Sosul Teriyaki, dulce-sărat, a fost folosit pentru a acoperi Crispy Strips, pentru Twister Teriyaki și chiar în variante de salată sau orez. Această campanie a adus o combinație diferită în meniul obișnuit, fiind apreciată de clienții care preferă o aromă mai delicată, specifică bucătăriei japoneze. Deși nu a rămas permanent în ofertă, a devenit una dintre cele mai memorabile lansări cu influențe internaționale.",
      pret: "37.00 lei",
      imagine: "KFC-Teriyaki.jpg"
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
