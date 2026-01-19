-- Tabel utilizatori
CREATE TABLE utilizatori (
    id_utilizator INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    parola VARCHAR(256) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    rol ENUM('client', 'admin') NOT NULL
);

-- Tabel produse
CREATE TABLE produse (
    id_produs INT AUTO_INCREMENT PRIMARY KEY,
    nume_produs VARCHAR(100) NOT NULL,
    descriere VARCHAR(255) NOT NULL,
    pret DECIMAL(10,2),
    categorie VARCHAR(50),
    disponibil BOOLEAN NOT NULL
);

-- Tabel comanda
CREATE TABLE comanda (
    id_comanda INT AUTO_INCREMENT PRIMARY KEY,
    id_utilizator INT,
    data_comenzii DATETIME,
    total DECIMAL(10,2),
    status ENUM('plasată', 'în pregătire', 'livrată'),
    FOREIGN KEY (id_utilizator) REFERENCES utilizatori(id_utilizator)
);

-- Tabel comenzi_produse (relație N:N)
CREATE TABLE comenzi_produse (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_comanda INT,
    id_produs INT,
    cantitate INT,
    FOREIGN KEY (id_comanda) REFERENCES comanda(id_comanda),
    FOREIGN KEY (id_produs) REFERENCES produse(id_produs)
);


INSERT INTO produse (nume_produs, descriere, pret, categorie, disponibil) VALUES
('Zinger Sandwich', 'Piept de pui picant, salată, maioneză, chiflă pufoasă.', 22.99, 'sandvișuri', TRUE),
('Colonel Burger', 'Burger cu piept de pui, brânză cheddar și sos special.', 24.50, 'sandvișuri', TRUE),
('Fillet Burger', 'File de pui fraged, salată și sos maioneză.', 23.99, 'sandvișuri', TRUE),
('Double Krunch', 'Două bucăți pui crocant, brânză și sos picant.', 27.00, 'sandvișuri', TRUE),
('Cheesy Twister', 'Twister cu brânză topită și pui crispy.', 25.50, 'sandvișuri', TRUE),
('Twister', 'Lipie cu pui crispy, roșii și sos maioneză.', 21.99, 'sandvișuri', TRUE),
('Crispy Strips (3 bucăți)', 'Bucăți de piept de pui în crustă aurie.', 18.99, 'sandvișuri', TRUE),
('Crispy Strips (5 bucăți)', 'Bucăți de piept de pui crocante și suculente.', 24.99, 'sandvișuri', TRUE),
('Hot Wings (4 bucăți)', 'Aripioare picante cu crustă crocantă.', 19.50, 'sandvișuri', TRUE),
('Hot Wings (6 bucăți)', 'Aripioare picante, rețetă originală KFC.', 25.00, 'sandvișuri', TRUE),
('Hot Bucket', 'Bucket cu 12 aripioare picante pentru partajat.', 44.99, 'sandvișuri', TRUE),
('Mega Bucket', 'Mix de Crispy Strips și Hot Wings pentru 2-3 persoane.', 59.99, 'sandvișuri', TRUE),
('Snack Box', 'Cutie cu pui crispy, cartofi și sos.', 19.00, 'sandvișuri', TRUE),
('Crispy Box', 'Meniu cu pui crispy, cartofi și băutură.', 27.99, 'sandvișuri', TRUE),
('Smart Menu', 'Meniu economic cu pui, cartofi și băutură.', 21.00, 'sandvișuri', TRUE),
('BBQ Wrap', 'Wrap cu pui, brânză, ceapă crocantă și sos BBQ.', 26.50, 'sandvișuri', TRUE),
('Zinger Box', 'Meniu cu Zinger, cartofi, băutură și desert.', 32.50, 'sandvișuri', TRUE),
('Popcorn Chicken', 'Bucăți mici de pui crocant.', 17.99, 'sandvișuri', TRUE),
('Chicken Nuggets', 'Nuggets de pui fraged cu sos la alegere.', 16.50, 'sandvișuri', TRUE),
('Burger Vegetarian', 'Chiflă cu chiftea vegetală, salată și sos.', 19.99, 'sandvișuri', FALSE),
('Cartofi prăjiți', 'Cartofi aurii, crocanți, serviți fierbinți.', 8.99, 'garnituri', TRUE),
('Cartofi Wedges', 'Cartofi condimentați, tăiați în sferturi.', 9.50, 'garnituri', TRUE),
('Salată Coleslaw', 'Salată proaspătă de varză și morcov.', 7.99, 'garnituri', TRUE),
('Sos usturoi', 'Sos cremos de usturoi.', 3.50, 'garnituri', TRUE),
('Sos BBQ', 'Sos dulce-picant BBQ.', 3.50, 'garnituri', TRUE),
('Sos dulce-acrișor', 'Sos ușor picant, dulce și aromat.', 3.50, 'garnituri', TRUE),
('Brownie', 'Prăjitură cu ciocolată densă.', 8.50, 'deserturi', TRUE),
('Cheesecake', 'Desert cu cremă de brânză și topping de fructe.', 9.99, 'deserturi', TRUE),
('Tiramisu', 'Desert italian cu mascarpone și cacao.', 10.50, 'deserturi', TRUE),
('Mini Pancakes', 'Clătite mici cu topping de caramel.', 9.00, 'deserturi', TRUE),
('Donut cu glazură', 'Gogoașă pufoasă cu glazură de ciocolată.', 8.00, 'deserturi', TRUE),
('Tartă de mere', 'Desert cald cu mere caramelizate.', 9.99, 'deserturi', TRUE),
('Înghețată caramel', 'Înghețată moale cu sos caramel.', 7.50, 'deserturi', TRUE),
('Înghețată ciocolată', 'Înghețată moale cu topping de ciocolată.', 7.50, 'deserturi', TRUE),
('Milkshake vanilie', 'Băutură cremoasă cu aromă de vanilie.', 12.50, 'băuturi', TRUE),
('Milkshake ciocolată', 'Milkshake răcoritor cu ciocolată.', 12.50, 'băuturi', TRUE),
('Milkshake căpșuni', 'Milkshake dulce cu aromă de căpșuni.', 12.50, 'băuturi', TRUE),
('Pepsi', 'Băutură răcoritoare carbogazoasă.', 9.00, 'băuturi', TRUE),
('Pepsi Max', 'Băutură fără zahăr.', 9.00, 'băuturi', TRUE),
('Mirinda', 'Suc portocaliu dulce și aromat.', 9.00, 'băuturi', TRUE),
('7UP', 'Băutură răcoritoare cu lămâie.', 9.00, 'băuturi', TRUE),
('Lipton Ice Tea', 'Ceai rece cu piersică sau lămâie.', 10.00, 'băuturi', TRUE),
('Apă plată', 'Apă minerală naturală 500ml.', 6.00, 'băuturi', TRUE),
('Apă minerală', 'Apă carbogazoasă 500ml.', 6.00, 'băuturi', TRUE),
('Cafea espresso', 'Cafea tare cu aromă intensă.', 7.50, 'băuturi', TRUE),
('Cafea latte', 'Cafea cu lapte cald și spumă fină.', 8.50, 'băuturi', TRUE),
('Cafea frappe', 'Cafea rece cu gheață și frișcă.', 9.50, 'băuturi', TRUE),
('Limonadă', 'Băutură proaspătă din lămâi naturale.', 10.00, 'băuturi', TRUE),
('Sprite', 'Băutură carbogazoasă cu lămâie-lime.', 9.00, 'băuturi', TRUE),
('Fanta', 'Suc de portocale dulce și acidulat.', 9.00, 'băuturi', TRUE),
('Hot Shot', 'Gustare rapidă cu bucăți de pui picant.', 15.50, 'sandvișuri', TRUE);

INSERT INTO utilizatori (username, parola, email, rol) VALUES
('daniela.eftimie', SHA2('parola123', 256), 'daniela.eftimie@email.com', 'client'),
('teodora.eftimie', SHA2('parola123', 256), 'teodora.eftimie@email.com', 'client'),
('iurie.dima', SHA2('parola123', 256), 'iurie.dima@email.com', 'client'),
('lucretiu.stancu', SHA2('parola123', 256), 'lucretiu.stancu@email.com', 'client'),
('eremia.ene', SHA2('parola123', 256), 'eremia.ene@email.com', 'client'),
('flaviu.dochioiu', SHA2('parola123', 256), 'flaviu.dochioiu@email.com', 'client'),
('vanesa.tomescu', SHA2('parola123', 256), 'vanesa.tomescu@email.com', 'client'),
('zaraza.stanescu', SHA2('parola123', 256), 'zaraza.stanescu@email.com', 'client'),
('alexandrina.toma', SHA2('parola123', 256), 'alexandrina.toma@email.com', 'client'),
('victoria.ionescu', SHA2('parola123', 256), 'victoria.ionescu@email.com', 'admin'),
('iustina.nemes', SHA2('parola123', 256), 'iustina.nemes@email.com', 'client'),
('loredana.mazilescu', SHA2('parola123', 256), 'loredana.mazilescu@email.com', 'client'),
('sandu.voinea', SHA2('parola123', 256), 'sandu.voinea@email.com', 'client'),
('aurora.florea', SHA2('parola123', 256), 'aurora.florea@email.com', 'client'),
('iulia.stan', SHA2('parola123', 256), 'iulia.stan@email.com', 'client'),
('emanuil.tomescu', SHA2('parola123', 256), 'emanuil.tomescu@email.com', 'client'),
('marin.gheorghiu', SHA2('parola123', 256), 'marin.gheorghiu@email.com', 'client'),
('coralia.popa', SHA2('parola123', 256), 'coralia.popa@email.com', 'client'),
('lacramioara.nistor', SHA2('parola123', 256), 'lacramioara.nistor@email.com', 'client'),
('rada.georgescu', SHA2('parola123', 256), 'rada.georgescu@email.com', 'admin'),
('dumitru.nemes', SHA2('parola123', 256), 'dumitru.nemes@email.com', 'client'),
('aglaia.toma', SHA2('parola123', 256), 'aglaia.toma@email.com', 'client'),
('artemisa.marin', SHA2('parola123', 256), 'artemisa.marin@email.com', 'client'),
('iuliu.toma', SHA2('parola123', 256), 'iuliu.toma@email.com', 'client'),
('lacramioara.popescu', SHA2('parola123', 256), 'lacramioara.popescu@email.com', 'client'),
('nae.albu', SHA2('parola123', 256), 'nae.albu@email.com', 'client'),
('sandu.ababei', SHA2('parola123', 256), 'sandu.ababei@email.com', 'client'),
('amelia.cristea', SHA2('parola123', 256), 'amelia.cristea@email.com', 'client'),
('dorel.popescu', SHA2('parola123', 256), 'dorel.popescu@email.com', 'client'),
('iulia.dochioiu', SHA2('parola123', 256), 'iulia.dochioiu@email.com', 'admin'),
('anisoara.dinu', SHA2('parola123', 256), 'anisoara.dinu@email.com', 'client'),
('decebal.puscasu', SHA2('parola123', 256), 'decebal.puscasu@email.com', 'client'),
('panait.marin', SHA2('parola123', 256), 'panait.marin@email.com', 'client'),
('augustin.stan', SHA2('parola123', 256), 'augustin.stan@email.com', 'client'),
('amanda.mazilescu', SHA2('parola123', 256), 'amanda.mazilescu@email.com', 'client'),
('narcisa.manole', SHA2('parola123', 256), 'narcisa.manole@email.com', 'client'),
('frusina.eftimie', SHA2('parola123', 256), 'frusina.eftimie@email.com', 'client'),
('gabriel.manole', SHA2('parola123', 256), 'gabriel.manole@email.com', 'client'),
('tania.florea', SHA2('parola123', 256), 'tania.florea@email.com', 'client'),
('fiodor.tomescu', SHA2('parola123', 256), 'fiodor.tomescu@email.com', 'admin'),
('dorina.barbu', SHA2('parola123', 256), 'dorina.barbu@email.com', 'client'),
('anamaria.tomescu', SHA2('parola123', 256), 'anamaria.tomescu@email.com', 'client'),
('zoe.voinea', SHA2('parola123', 256), 'zoe.voinea@email.com', 'client'),
('cristina.mazilescu', SHA2('parola123', 256), 'cristina.mazilescu@email.com', 'client'),
('cristea.puscasu', SHA2('parola123', 256), 'cristea.puscasu@email.com', 'client'),
('octav.stanescu', SHA2('parola123', 256), 'octav.stanescu@email.com', 'client'),
('giorgiana.dinu', SHA2('parola123', 256), 'giorgiana.dinu@email.com', 'client'),
('teodora.stanescu', SHA2('parola123', 256), 'teodora.stanescu@email.com', 'client'),
('lazar.cristea', SHA2('parola123', 256), 'lazar.cristea@email.com', 'client'),
('doina.toma', SHA2('parola123', 256), 'doina.toma@email.com', 'admin');


INSERT INTO comanda (id_utilizator, data_comenzii, total, status) VALUES
(1, '2025-04-01 12:15:00', 54.90, 'plasată'),
(2, '2025-04-02 13:45:00', 72.50, 'livrată'),
(3, '2025-04-03 14:10:00', 48.20, 'în pregătire'),
(4, '2025-04-04 16:30:00', 36.90, 'plasată'),
(5, '2025-04-05 18:25:00', 99.40, 'livrată'),
(6, '2025-04-06 10:15:00', 42.60, 'plasată'),
(7, '2025-04-07 20:30:00', 81.70, 'în pregătire'),
(8, '2025-04-08 11:45:00', 65.90, 'livrată'),
(9, '2025-04-09 19:00:00', 57.50, 'plasată'),
(10, '2025-04-10 13:20:00', 88.90, 'livrată'),
(11, '2025-04-11 12:40:00', 72.10, 'în pregătire'),
(12, '2025-04-12 18:15:00', 49.20, 'plasată'),
(13, '2025-04-13 21:05:00', 110.50, 'livrată'),
(14, '2025-04-14 17:25:00', 32.90, 'în pregătire'),
(15, '2025-04-15 13:55:00', 64.70, 'livrată'),
(16, '2025-04-16 11:10:00', 51.30, 'plasată'),
(17, '2025-04-17 22:00:00', 93.80, 'livrată'),
(18, '2025-04-18 10:05:00', 29.99, 'în pregătire'),
(19, '2025-04-19 12:45:00', 84.20, 'livrată'),
(20, '2025-04-20 20:10:00', 46.50, 'plasată'),
(21, '2025-04-21 19:30:00', 75.40, 'livrată'),
(22, '2025-04-22 13:25:00', 33.70, 'în pregătire'),
(23, '2025-04-23 18:55:00', 56.60, 'livrată'),
(24, '2025-04-24 15:05:00', 40.99, 'plasată'),
(25, '2025-04-25 14:30:00', 72.40, 'livrată'),
(26, '2025-04-26 16:15:00', 59.30, 'plasată'),
(27, '2025-04-27 18:25:00', 48.70, 'în pregătire'),
(28, '2025-04-28 12:10:00', 61.90, 'livrată'),
(29, '2025-04-29 13:55:00', 44.60, 'plasată'),
(30, '2025-04-30 19:05:00', 78.20, 'livrată'),
(31, '2025-05-01 20:45:00', 55.10, 'livrată'),
(32, '2025-05-02 11:40:00', 36.70, 'în pregătire'),
(33, '2025-05-03 17:50:00', 92.80, 'livrată'),
(34, '2025-05-04 10:30:00', 29.50, 'plasată'),
(35, '2025-05-05 21:05:00', 65.70, 'în pregătire'),
(36, '2025-05-06 13:20:00', 78.30, 'livrată'),
(37, '2025-05-07 12:00:00', 47.60, 'plasată'),
(38, '2025-05-08 19:15:00', 82.50, 'livrată'),
(39, '2025-05-09 11:25:00', 95.60, 'livrată'),
(40, '2025-05-10 18:50:00', 63.10, 'plasată'),
(41, '2025-05-11 12:40:00', 58.70, 'în pregătire'),
(42, '2025-05-12 17:35:00', 72.90, 'livrată'),
(43, '2025-05-13 20:10:00', 49.20, 'livrată'),
(44, '2025-05-14 11:05:00', 67.80, 'plasată'),
(45, '2025-05-15 22:30:00', 54.10, 'livrată'),
(46, '2025-05-16 13:45:00', 59.90, 'în pregătire'),
(47, '2025-05-17 15:30:00', 91.20, 'livrată'),
(48, '2025-05-18 19:50:00', 48.00, 'plasată'),
(49, '2025-05-19 12:25:00', 83.70, 'livrată'),
(50, '2025-05-20 20:00:00', 97.40, 'în pregătire');

INSERT INTO comanda (id_utilizator, data_comenzii, total, status) VALUES
(1, '2025-04-01 12:15:00', 54.90, 'plasată'),
(2, '2025-04-02 13:45:00', 72.50, 'livrată'),
(3, '2025-04-03 14:10:00', 48.20, 'în pregătire'),
(4, '2025-04-04 16:30:00', 36.90, 'plasată'),
(5, '2025-04-05 18:50:00', 82.40, 'livrată'),
(6, '2025-04-06 11:00:00', 44.10, 'plasată'),
(7, '2025-04-07 10:25:00', 65.70, 'livrată'),
(8, '2025-04-08 13:00:00', 28.90, 'plasată'),
(9, '2025-04-09 14:45:00', 91.50, 'livrată'),
(10, '2025-04-10 15:10:00', 33.30, 'în pregătire'),
(11, '2025-04-11 16:00:00', 55.20, 'plasată'),
(12, '2025-04-12 12:20:00', 74.90, 'livrată'),
(13, '2025-04-13 11:30:00', 60.80, 'livrată'),
(14, '2025-04-14 17:00:00', 32.10, 'plasată'),
(15, '2025-04-15 18:00:00', 43.90, 'livrată'),
(16, '2025-04-16 12:30:00', 50.70, 'în pregătire'),
(17, '2025-04-17 13:50:00', 78.60, 'plasată'),
(18, '2025-04-18 15:20:00', 59.40, 'livrată'),
(19, '2025-04-19 14:00:00', 41.80, 'livrată'),
(20, '2025-04-20 10:15:00', 47.90, 'plasată'),
(21, '2025-04-21 12:25:00', 63.10, 'în pregătire'),
(22, '2025-04-22 13:40:00', 88.70, 'livrată'),
(23, '2025-04-23 17:30:00', 39.60, 'plasată'),
(24, '2025-04-24 18:45:00', 54.40, 'livrată'),
(25, '2025-04-25 11:55:00', 67.90, 'în pregătire'),
(26, '2025-04-26 12:40:00', 29.10, 'plasată'),
(27, '2025-04-27 13:10:00', 83.70, 'livrată'),
(28, '2025-04-28 15:00:00', 46.30, 'livrată'),
(29, '2025-04-29 16:25:00', 52.90, 'plasată'),
(30, '2025-04-30 17:40:00', 61.10, 'livrată'),
(31, '2025-05-01 18:30:00', 72.50, 'plasată'),
(32, '2025-05-02 19:45:00', 43.20, 'livrată'),
(33, '2025-05-03 20:10:00', 89.90, 'în pregătire'),
(34, '2025-05-04 21:20:00', 31.50, 'plasată'),
(35, '2025-05-05 10:10:00', 66.40, 'livrată'),
(36, '2025-05-06 12:25:00', 48.10, 'livrată'),
(37, '2025-05-07 14:50:00', 53.20, 'în pregătire'),
(38, '2025-05-08 15:30:00', 74.80, 'plasată'),
(39, '2025-05-09 16:40:00', 37.90, 'livrată'),
(40, '2025-05-10 17:55:00', 82.60, 'livrată'),
(41, '2025-05-11 19:00:00', 69.40, 'în pregătire'),
(42, '2025-05-12 20:15:00', 45.10, 'plasată'),
(43, '2025-05-13 21:25:00', 33.80, 'livrată'),
(44, '2025-05-14 10:30:00', 57.50, 'plasată'),
(45, '2025-05-15 12:00:00', 92.30, 'livrată'),
(46, '2025-05-16 13:30:00', 76.10, 'livrată'),
(47, '2025-05-17 14:40:00', 68.20, 'în pregătire'),
(48, '2025-05-18 16:00:00', 51.30, 'plasată'),
(49, '2025-05-19 17:20:00', 79.60, 'livrată'),
(50, '2025-05-20 18:30:00', 64.70, 'livrată');

INSERT INTO comenzi_produse (id_comanda, id_produs, cantitate) VALUES
(101, 4, 2),
(102, 15, 1),
(103, 7, 3),
(104, 9, 1),
(105, 22, 2),
(106, 11, 1),
(107, 5, 2),
(108, 18, 1),
(109, 27, 4),
(110, 33, 2),
(111, 14, 1),
(112, 6, 3),
(113, 19, 1),
(114, 23, 2),
(115, 30, 1),
(116, 10, 2),
(117, 1, 3),
(118, 12, 1),
(119, 26, 2),
(120, 8, 1),
(121, 20, 3),
(122, 29, 1),
(123, 17, 2),
(124, 25, 1),
(125, 3, 4),
(126, 21, 2),
(127, 31, 1),
(128, 13, 3),
(129, 24, 1),
(130, 2, 2),
(131, 32, 1),
(132, 28, 3),
(133, 34, 2),
(134, 16, 1),
(135, 35, 4),
(136, 36, 2),
(137, 40, 1),
(138, 41, 3),
(139, 42, 1),
(140, 43, 2),
(141, 44, 1),
(142, 45, 3),
(143, 46, 2),
(144, 47, 1),
(145, 48, 4),
(146, 49, 2),
(147, 50, 1),
(148, 37, 3),
(149, 38, 1),
(150, 39, 2);

SELECT id_comanda FROM comanda;

ALTER TABLE produse
ADD imagine VARCHAR(255) NULL;

UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Burger_Zinger_Burger_1272x1272px_5a4d38538d.png' WHERE id_produs = 1;
UPDATE produse SET imagine = 'https://kfcrestaurants.be/wp-content/uploads/2023/09/Colonel-Burger.jpg' WHERE id_produs = 2;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Burger_Fillet_Burger_1272x1272px_e06e17b32e.png' WHERE id_produs = 3;
UPDATE produse SET imagine = 'https://kfcrestaurants.be/wp-content/uploads/2019/05/double-krunch.jpg' WHERE id_produs = 4;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_cheezy_twister_05dc378f1a.png' WHERE id_produs = 5;

UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Twister_Nepicant_1272x1272px_3843144bc7.png' WHERE id_produs = 6;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Crispy_Strips_8_PC_1272x1272px_a89d217e77.png' WHERE id_produs = 7;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Crispy_Strips_8_PC_1272x1272px_a89d217e77.png' WHERE id_produs = 8;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Hot_Wings_3_PC_1272x1272px_d5d46a21a4.png' WHERE id_produs = 9;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Hot_Wings_5_PC_1272x1272px_cf4bb44959.png' WHERE id_produs = 10;

UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Bucket_Hot_1272x1272px_7a218c8fce.png   ' WHERE id_produs = 11;
UPDATE produse SET imagine = 'https://amrestcdn.azureedge.net/kfc-web-ordering/KFC_HUN/24_Egyedi_Kuponajanlatok/440x440/kfc_hun_mega_kosar_440x440.png' WHERE id_produs = 12;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Snack_Box_Kentucky_1272x1272px_7b486f4fe4.png' WHERE id_produs = 13;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Snack_Box_Wings_1272x1272px_063713fb9a.png' WHERE id_produs = 14;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/smart_menu_picant_3cee9c2379.png' WHERE id_produs = 15;

UPDATE produse SET imagine = 'https://brand-uk.assets.kfc.co.uk/2022-11/W4_22_ON_PREMISE_TWISTER_SMOKEYBBQ_1200x800.jpg?VersionId=RN2mQGoHGYE6wTWWXDsuvFyAumVWd_B_' WHERE id_produs = 16;
UPDATE produse SET imagine = 'https://sawepecomcdn.blob.core.windows.net/kfc-web-ordering/CZ/KFC/2023/COLESLAW/Box/ZingerDoubleBox.png' WHERE id_produs = 17;
UPDATE produse SET imagine = 'https://kfc.lv/wp-content/uploads/2023/09/KFC_popcorn_chicken_L.png' WHERE id_produs = 18;
UPDATE produse SET imagine = 'https://media.cnn.com/api/v1/images/stellar/prod/220718120145-kfc-new-fried-chicken-nuggets-2022.jpg?c=original' WHERE id_produs = 19;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Fries_Large_Fries_1272x1272px_31cc975c03.png' WHERE id_produs = 21;

UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Fries_Dipping_Fries_1272x1272px_d815342f24.png' WHERE id_produs = 22;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Salad_Fillet_Bites_1272x1272px_0a37bf2cd1.png' WHERE id_produs = 23;
UPDATE produse SET imagine = 'https://kfcromania.vtexassets.com/arquivos/ids/157329/Sauce%20Garlic_Ecomm_1200x1200px.png?v=638877191877970000' WHERE id_produs = 24;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Sauce_Heinz_BBQ_1272x1272px_e7eb02e314.png' WHERE id_produs = 25;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Sauce_Heinz_Sweet_Sour_1272x1272px_bd7e051285.png' WHERE id_produs = 26;

UPDATE produse SET imagine = 'https://cdn.tictuk.com/04d917c0-7bcd-6ced-acad-3e4db2bcbfd5/menus/BRWNY-M.jpg' WHERE id_produs = 27;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Deserts_Cheesecake_1272x1272px_7943242972.png' WHERE id_produs = 28;
UPDATE produse SET imagine = 'https://kfc.lv/wp-content/uploads/2025/11/Tiramisu-WEB.png' WHERE id_produs = 29;
UPDATE produse SET imagine = 'https://amrestcdn.azureedge.net/kfc-web-ordering/KFC_HUN/20_Reggeli/Delivery/440x440/kfc_karamellas_palacsinta_440x440.png' WHERE id_produs = 30;
UPDATE produse SET imagine = 'https://kfc.ee/wp-content/uploads/2021/10/Chocolate_donut.png' WHERE id_produs = 31;

UPDATE produse SET imagine = 'https://mcxhoreca.vtexassets.com/arquivos/ids/167069-800-800?v=637916621076600000&width=800&height=800&aspect=true' WHERE id_produs = 32;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Caramel_6eb4a2b172.png' WHERE id_produs = 33;
UPDATE produse SET imagine = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcThVK1UfjNEVB83xDOuHI3Q7LG8pCH11NJQtw&s' WHERE id_produs = 34;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/milkshake_vanilie_771402af07.png' WHERE id_produs = 35;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_milkshake_ciocolata_60b4f459fd.png' WHERE id_produs = 36;

UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_milkshake_capsuni_1b115b920d.png' WHERE id_produs = 37;
UPDATE produse SET imagine = 'https://brand-uk.assets.kfc.co.uk/2024-10/KFC4507~44152%20_W5_24_MOBORDER_REG_PEPSI_MAX_1200x800.jpg?VersionId=8Y2Cf92uG.MPFu.WbvJqZOn3HmaF7GvQ' WHERE id_produs = 38;
UPDATE produse SET imagine = 'https://images.ctfassets.net/crbk84xktnsl/7fuVNYVcBPfOC9Jl9DsH1r/a0a3082815dea0bd3c8a92a519bb9753/Drink_Pepsi_Max_1.25L.png' WHERE id_produs = 39;
UPDATE produse SET imagine = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREvbngy0y1cRFmVthOv7QD-V1K4ZXtTmDj1g&s' WHERE id_produs = 40;
UPDATE produse SET imagine = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmMRyeMlV-fMtriKCc2g9yVzEkI9INzJpi3g&s' WHERE id_produs = 41;

UPDATE produse SET imagine = 'https://images.ctfassets.net/crbk84xktnsl/4F4LvVjFY0w0CEpcVdYZFI/0ed9d39ff9e1d45d4bb84eedda97dc73/Drink_Lipton_Iced_Tea.png' WHERE id_produs = 42;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Drinks_Dorna_Still_1272x1272px_c5e71329e8.png' WHERE id_produs = 43;
UPDATE produse SET imagine = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTitO-BTHSGt3NaVT5x4Lt5Q5bzWt3ZkiKxXg&s' WHERE id_produs = 44;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/medium_Cat_Det_Seattle_Espresso_1272x1272px_8abf7a8437.png' WHERE id_produs = 45;
UPDATE produse SET imagine = 'https://api.kfc.ro/uploads/Cat_Det_Seattle_Latte_1272x1272px_11d97ca656.png' WHERE id_produs = 46;

UPDATE produse SET imagine = 'https://amrestcdn.azureedge.net/kfc-web-ordering/KFC/Rok2023grafika/Shakenowagrafika/Shake_sredni_frappe_400.png' WHERE id_produs = 47;
UPDATE produse SET imagine = 'https://kfc.ee/wp-content/uploads/2025/05/Kiwi-Lemonade-1024x1024.png' WHERE id_produs = 48;
UPDATE produse SET imagine = 'https://kfc.ee/wp-content/uploads/2022/09/Sprite.png' WHERE id_produs = 49;
UPDATE produse SET imagine = 'https://kfc.lt/wp-content/uploads/2022/09/Fanta.png' WHERE id_produs = 50;
UPDATE produse SET imagine = 'https://amrestcdn.azureedge.net/kfc-web-ordering/KFC_HUN/16_Kosarak_uj_palast/440x440/kfc_hun_b4o_hot_shot_bites_440x440.png' WHERE id_produs = 51;

ALTER TABLE comanda
ADD COLUMN data_comanda DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE comanda
MODIFY COLUMN status ENUM( 'plasată', 'în pregătire', 'livrată') NOT NULL DEFAULT 'plasată';

DESCRIBE comanda;

ALTER TABLE comanda
DROP COLUMN data_comenzii;
