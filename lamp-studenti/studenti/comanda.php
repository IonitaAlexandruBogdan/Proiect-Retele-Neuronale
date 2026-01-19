<?php
session_start();
require_once 'db.php';

$esteLogat = isset($_SESSION['username']);
$esteAdmin = $esteLogat && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

/* protecție login */
if (!isset($_SESSION['id_utilizator'])) {
    header("Location: login.php?error=Trebuie+sa+te+loghezi");
    exit;
}

/* produse din DB */
$produse = $pdo->query("
    SELECT id_produs, nume_produs, pret, imagine, descriere 
    FROM produse 
    WHERE disponibil = 1
")->fetchAll();

/* coș */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comandă Acum - KFC România</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/sco/b/bf/KFC_logo.svg">
  <style>
    .prod-popup {
      position: absolute;
      background: white;
      border: 1px solid #ccc;
      padding: 12px;
      width: 250px;
      z-index: 9999;
      display: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      border-radius: 8px;
    }
    .prod-popup img {
      width: 100%;
      border-radius: 4px;
      margin-bottom: 8px;
    }
    .prod-popup h4 { margin: 4px 0; font-size: 1.1em; }
    .prod-popup p { margin: 4px 0; }
    .prod-popup input[type=number] { width: 50px; margin-right: 8px; }
    .prod-popup .pp-actions { margin-top: 8px; text-align: right; }
    .prod-popup .pp-actions .btn-small { margin-right: 6px; }

    .cart-container { position: relative; }
    .cart-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      background: white;
      border: 1px solid #ccc;
      padding: 10px;
      min-width: 250px;
      z-index: 100;
      display: none;
    }
    .cart-container:hover .cart-dropdown { display: block; }
    #cart-message { margin-top: 5px; font-weight: bold; }
  </style>
</head>
<body>

<header>
  <div class="logo">
    <img src="https://blog.logomyway.com/wp-content/uploads/2020/09/KFC-logo.jpg" height="70">
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Acasă</a></li>
      <li><a href="produse.php">Produse</a></li>
      <li><a href="oferte.php">Oferte</a></li>
      <li><a href="restaurante.php">Restaurante</a></li>
      <li><a href="kfcinromania.php">KFC România</a></li>
      <li><a href="istorie-kfc.php">Istorie KFC</a></li>

      <li class="cart-container">
        <a href="#!" class="cart-btn">Coșul meu</a>
        <div class="cart-dropdown">
          <ul id="cart-items"></ul>
          <p id="cart-total">Total: 0 lei</p>
          <!-- Buton AJAX pentru confirmare -->
          <button id="cart-confirm-btn" class="btn">Confirmă comanda</button>
          <div id="cart-message"></div>
        </div>
      </li>

            <?php if ($esteAdmin): ?>
      <li><a href="admin.php" style="color:#ffcc00;font-weight:bold;">Admin Panel</a></li>
      <?php endif; ?>

      <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
    </ul>
  </nav>
</header>

<section class="banner">
  <div class="banner-text">
    <h1>Comandă Acum!</h1>
    <p>Gustul original KFC, direct la tine acasă.</p>
    <a href="#meniu" class="btn">Vezi Meniu</a>
  </div>
</section>

<section class="produse" id="meniu">
  <h2>Meniurile Disponibile</h2>
  <div class="produse-grid">

    <?php foreach ($produse as $p): ?>
      <div class="produs">
        <img src="<?= $p['imagine'] ?? 'https://via.placeholder.com/300x200' ?>">
        <h3><?= htmlspecialchars($p['nume_produs']) ?></h3>
        <p><?= htmlspecialchars($p['descriere']) ?></p>
        <p>Preț: <?= number_format($p['pret'],2) ?> lei</p>

        <button class="btn-small add-btn"
                data-id="<?= $p['id_produs'] ?>"
                data-nume="<?= htmlspecialchars($p['nume_produs']) ?>"
                data-pret="<?= $p['pret'] ?>"
                data-desc="<?= htmlspecialchars($p['descriere']) ?>"
                data-img="<?= $p['imagine'] ?? 'https://via.placeholder.com/300x200' ?>">
          Comandă
        </button>
      </div>
    <?php endforeach; ?>

  </div>
</section>

<div id="prodPopup" class="prod-popup">
  <img id="pp-img" src="" alt="Produs" />
  <h4 id="pp-title"></h4>
  <p id="pp-desc"></p>
  <p id="pp-price"></p>
  <label>Cantitate:</label>
  <input type="number" id="pp-qty" min="1" value="1">
  <div class="pp-actions">
    <button id="pp-cancel" class="btn-small">Anulează</button>
    <button id="pp-confirm" class="btn">Adaugă în coș</button>
  </div>
</div>

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
// coș popup
function updateCartPopup() {
    fetch("comanda_add.php?update_cart=1")
    .then(res => res.json())
    .then(cart => {
        const itemsUl = document.getElementById('cart-items');
        const totalP = document.getElementById('cart-total');
        itemsUl.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            let sub = item.pret * item.cantitate;
            total += sub;
            let li = document.createElement('li');
            li.textContent = item.nume + " x " + item.cantitate + " = " + sub.toFixed(2) + " lei";
            itemsUl.appendChild(li);
        });

        totalP.textContent = "Total: " + total.toFixed(2) + " lei";
    });
}

updateCartPopup();

// popup produs
let selectedId = null;

const popup = document.getElementById("prodPopup");
const imgEl = document.getElementById("pp-img");
const titleEl = document.getElementById("pp-title");
const descEl = document.getElementById("pp-desc");
const priceEl = document.getElementById("pp-price");
const qtyEl = document.getElementById("pp-qty");

const btnConfirm = document.getElementById("pp-confirm");
const btnCancel = document.getElementById("pp-cancel");

document.querySelectorAll(".add-btn").forEach(btn => {
  btn.addEventListener("click", e => {
    e.stopPropagation();
    selectedId = btn.dataset.id;

    titleEl.textContent = btn.dataset.nume;
    descEl.textContent = btn.dataset.desc;
    priceEl.textContent = "Preț: " + btn.dataset.pret + " lei";
    imgEl.src = btn.dataset.img;
    qtyEl.value = 1;

    const rect = btn.getBoundingClientRect();
    popup.style.top = (window.scrollY + rect.bottom + 8) + "px";
    popup.style.left = (window.scrollX + rect.left) + "px";
    popup.style.display = "block";
  });
});

btnCancel.onclick = () => popup.style.display = "none";
window.addEventListener("click", e => { 
  if (!popup.contains(e.target) && !e.target.classList.contains("add-btn")) popup.style.display = "none"; 
});

btnConfirm.onclick = () => {
  const qty = parseInt(qtyEl.value);
  if (!qty || qty < 1) return;

  fetch("comanda_add.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_produs=${selectedId}&cantitate=${qty}`
  })
  .then(res => res.json())
  .then(data => {
    updateCartPopup(); 
    popup.style.display = "none"; 
  })
  .catch(err => console.error(err));
};

// AJAX confirmare comandă
document.getElementById('cart-confirm-btn').addEventListener('click', function() {
    fetch('comanda_add.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'confirm=1'
    })
    .then(res => res.json())
    .then(data => {
        const msgDiv = document.getElementById('cart-message');
        if(data.success) {
            msgDiv.style.color = 'green';
            msgDiv.textContent = `Comanda a fost plasată cu succes! ID comanda: ${data.id_comanda}`;
            updateCartPopup(); // golește coșul vizual
        } else {
            msgDiv.style.color = 'red';
            msgDiv.textContent = `Eroare: ${data.message}`;
        }
    })
    .catch(err => {
        const msgDiv = document.getElementById('cart-message');
        msgDiv.style.color = 'red';
        msgDiv.textContent = 'Eroare server.';
        console.error(err);
    });
});
</script>
</body>
</html>
