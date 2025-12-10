
---

#  Etapa 4 – Arhitectura Completă a Aplicației SIA bazată pe Rețele Neuronale

**Disciplina:** Rețele Neuronale
**Instituție:** POLITEHNICA București – FIIR
**Student:** [Nume Prenume]
**GitHub Repository:** [[link](https://github.com/IonitaAlexandruBogdan/Proiect-Retele-Neuronale)]
**Data:** [09.12.2025]

---

##  Scopul Etapei 4

Această etapă presupune construirea unui **schelet funcțional al aplicației SIA**.

**Ce trebuie să funcționeze:**

* Pipeline complet fără erori: date → preprocesare → model RN → UI
* Model RN definit și compilat (neantrenat)
* UI minim funcțional (input → output)

**Ce NU este necesar:**

* Model RN cu performanță ridicată
* Hiperparametri optimizați
* UI cu funcționalități avansate

---

## 1 Nevoie Reală → Soluție SIA → Modul Software

| Nevoie reală concretă                         | Soluție SIA                                     | Modul software responsabil |
| --------------------------------------------- | ----------------------------------------------- | -------------------------- |
| Predicția uzurii sculelor CNC                 | Analiză parametri operare → alertă preventivă   | Data Acquisition + RN + UI |
| Detectarea defectelor pe suprafețe prelucrate | Clasificare imagine upload → alertă operator    | RN + Web Service           |
| Optimizarea traiectoriei robotului AGV        | Predicție timp traversare → reducere consum 20% | RN + Control Module        |

 Metrici măsurabile:

* Latență < 2 secunde
* Alertă predictivă > 90%
* Reducere consum ~20%

---

## 2 Contribuția Originală la Setul de Date

**Total observații finale:** 10,000
**Observații originale:** 4,500 (45%)

**Tip contribuție:**

* [x] Date generate prin simulare fizică
* [ ] Date achiziționate cu senzori proprii
* [ ] Etichetare manuală
* [ ] Date sintetice

**Detalii:**
Datele simulate reprezintă parametrii de operare CNC (viteză, avans, adâncime așchiere, vibrații). Simulările respectă limite reale. Cod Python generează fișiere CSV compatibile cu preprocesarea Etapei 3.

 Cod: `src/data_acquisition/generate_simulated_data.py`
 Date: `data/generated/`

---

## 3 Diagrama State Machine

**Flux principal:**

```
IDLE → ACQUIRE_DATA → PREPROCESS → INFERENCE → DISPLAY → LOG → [ERROR] → STOP
```

**Legendă:**
Flux de **monitorizare continuă CNC** pentru procesare real-time și alertare operator.

* **IDLE:** Sistem inactiv
* **ACQUIRE_DATA:** Citire senzori / fișiere generate
* **PREPROCESS:** Curățare, normalizare, encoding
* **INFERENCE:** Model RN rulează pe date
* **DISPLAY:** Rezultat afișat UI
* **LOG:** Salvare date + alertă
* **ERROR:** Gestionare erori (senzor lipsă, buffer full)

 Diagramă: `docs/state_machine.png`

---

## 4 Schelet Module SIA

| Modul                      | Folder Python           | Cerință minimă                                           |
| -------------------------- | ----------------------- | -------------------------------------------------------- |
| Data Logging / Acquisition | `src/data_acquisition/` | Produce CSV (min 40% originale), cod rulează fără erori  |
| Neural Network Module      | `src/neural_network/`   | Model RN definit, compilat, salvat/reîncărcat            |
| Web Service / UI           | `/html/`                | Primește input user și returnează output, cod funcțional |


Screenshot UI: `docs/screenshots/ui_demo.png`

---

## 5 Structura Repository Etapa 4

```
proiect-rn-[nume-prenume]/
├── data/
│   ├── raw/
│   ├── processed/
│   ├── raw/
│   ├── train/
│   ├── validation/
│   └── test/
├── src/
│   ├── data_acquisition/
│   ├── preprocessing/
│   ├── neural_network/
├── docs/
│   ├── static/
│   └── templates/
├── html/
│   ├── data_acquisition/
│   ├── preprocessing/
│   ├── neural_network/
├── README.md
├── README_Etapa3.md
├── Predicția principalelor defecte ale unor masini cu comanda numerica.pptx
├── README_Etapa4_Arhitectura_SIA.md
└── requirements.txt
```

---


