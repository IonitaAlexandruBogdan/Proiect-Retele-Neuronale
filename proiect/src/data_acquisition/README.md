# Modul Generare Dataset CNC

Acest modul Python generează un dataset sintetic pentru scule CNC, simulând valori de proces și defecte posibile. Dataset-ul poate fi utilizat ulterior pentru antrenarea unei rețele neuronale sau analiza industrială a defectelor.

---

## 1. Funcționalitate

- Generează date pentru diferite tipuri de scule: freze, burghie, tarozi și plăcuțe amovibile.
- Simulează operațiile asociate fiecărei scule: frezare, găurire, filetare, strunjire.
- Include parametri de proces: turatie, avans, adâncime a așchierii, debit lichid de răcire, temperatură, vibrații, uzură și zgomot.
- Introduce defecte simulate cu probabilități prestabilite:
  - Supraincalzire
  - Uzura excesivă
  - Vibratii
- Materiale prelucrate: oțel, aluminiu, inox.
- Fiecare exemplu conține:
  - ID sculă
  - Tip sculă
  - Model sculă
  - Parametri de proces
  - Tip operație
  - ID lot
  - Indicator defect (1/0)
  - Tip defect

---

## 2. Structura Modul

- `scule`: listă cu tipuri de scule și modelele acestora.
- `materiale`: materiale posibile pentru prelucrare.
- `operatii`: mapping tip sculă → operație asociată.
- `tipuri_defect`: tipuri de defecte simulate.
- Funcții principale:
  - `generate_sample(id_scula, tip_scula, model_scula)`: generează un singur exemplu sintetic.
  - `genereaza_dataset(numar_per_scule=600)`: generează și salvează CSV-ul complet cu toate sculele.

---

## 3. Locația fișierului generat

- Dataset-ul se salvează în folderul:

data/raw/Dataset_CNC.csv


- Folderul `data/raw/` este creat automat dacă nu există.

---

## 4. Cerințe

- Python >= 3.8
- Module Python standard: `random`, `csv`, `os`
- Recomandat pentru generarea rapidă a dataset-urilor și testare a modelelor CNC.

---

## 5. Utilizare

1. Clonează repository-ul și navighează în directorul proiectului.
2. Rulează modul pentru a genera dataset-ul:

```bash
python src/data_acquisition/generare.py
