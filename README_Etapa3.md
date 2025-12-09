Proiect Rețele Neuronale – Estimare Uzură Sculă CNC

Disciplina: Rețele Neuronale
Universitate: POLITEHNICA București – FIIR
Student: [Nume Prenume]
Data: [Data]

Descriere proiect

Acest proiect are ca scop dezvoltarea unui model de rețea neuronală care estimează uzura sculelor utilizate în prelucrarea CNC, pe baza parametrilor de funcționare ai mașinii.
Datele provin de la senzori montați pe utilaje reale și includ atât caracteristici numerice (turatie, avans, adâncime de așchiere, temperatură, vibrații etc.), cât și categoriale (tip sculă, model, material).

project-name/
├── README.md
├── data/
│   ├── raw/               # date brute
│   ├── processed/         # date curățate
│   ├── train/             # set de instruire
│   ├── validation/        # set de validare
│   └── test/              # set de testare
├── src/
│   ├── preprocessing/     # cod pentru preprocesare
│   ├── neural_network/    # cod pentru antrenarea modelului
│   └── app.py             # aplicație Flask pentru testare model
├── html/                  # template-uri și CSS pentru interfață
├── config/                # fișiere de configurare (opțional)
└── requirements.txt       # librării Python necesare

Dataset

Format: CSV

Număr total observații: ~10.000

Număr caracteristici: 11

Tipuri date: numeric și categorial

Exemple de caracteristici:

Turatie_RPM – numeric, RPM

Avans_mm_min – numeric, mm/min

Adancime_Aschiere_mm – numeric, mm

Debit_Lichid_racire_L_min – numeric, L/min

Temperatura_C – numeric, °C

Vibratii_mm_s – numeric, mm/s

Zgomot_dB – numeric, dB

Uzura_procent – numeric, % (target)

Tip_Scula – categorial

Model_Scula – categorial

Material_Prelucrat – categorial

Preprocesare

Eliminarea duplicatelor

Completarea valorilor lipsă (numeric – mediană)

Encoding pentru variabile categoriale (LabelEncoder)

Împărțirea datasetului în train (75%), validation (15%) și test (10%)

Salvarea seturilor și a parametrilor de preprocesare

Normalizarea numerică se aplică în timpul antrenării modelului (train_model.py) pentru a păstra consistența în predicții.

Model Rețea Neuronală

Tip: Rețea feed-forward densă

Input: combinație numeric + categorial encodat

Straturi: 64 → 32 → 1 (output)

Activare: ReLU pentru straturile ascunse, linear pentru output

Loss: Mean Squared Error

Metrici: Mean Absolute Error

Antrenare: 50 epoci, batch_size = 32

Aplicație de testare

Repository-ul include o aplicație simplă Flask (src/app.py) care permite:

Alegerea tipului și modelului sculei

Introducerea parametrilor de operare

Obținerea unei predicții pentru uzura sculei

Interfața folosește HTML și CSS din folderul html/.

Cum rulez proiectul

Instalare dependențe

Preprocesare date

Antrenare model

Testare aplicație Flask

Acces: http://127.0.0.1:5000/
