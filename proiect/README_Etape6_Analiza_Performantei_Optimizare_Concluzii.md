# README – Etapa 6: Analiza Performanței, Optimizarea și Concluzii Finale

**Disciplina:** Rețele Neuronale  
**Instituție:** POLITEHNICA București – FIIR  
**Student:** [Ionita Alexandru Bogdan ]  
**Link Repository GitHub:** [(https://github.com/IonitaAlexandruBogdan/Proiect-Retele-Neuronale/tree/P5)]
**Data predării:** [15.01.2026]

---
## Scopul Etapei 6

optimizarea modelului de clasificare multi-clasă pentru defecte CNC
evaluarea detaliată a performanței
integrarea modelului final într-o aplicație funcțională (Flask)

Modelul are rolul de a identifica tipul defectului sculei (Tip_Defect) pe baza parametrilor tehnologici și a semnalelor de stare.

# Descrierea pipeline-ului final

Pipeline-ul complet implementat conține următoarele etape:

Generare date sintetice (generare.py)

Preprocesare date (preprocesare.py)

eliminare duplicate

completare valori lipsă (mediană)

split stratificat train / validation / test

Antrenare model multi-class (train_model.py)

Evaluare model (evaluate_model.py)

Inferență în aplicație web (predict.py, app.py)

# Arhitectura modelului final

Modelul utilizat este un MLP (Multi-Layer Perceptron):

Input:

caracteristici numerice normalizate (MinMaxScaler)

caracteristici categorice encodate (LabelEncoder)

Arhitectură:

Dense(64, ReLU)

Dense(32, ReLU)

Dense(4, Softmax)

Funcție de pierdere:

SparseCategoricalCrossentropy

Optimizator:

Adam

Această arhitectură permite clasificarea explicită a celor 4 clase:

Niciunul

Supraincalzire

Uzura excesiva

Vibratii

# Evaluarea modelului final – Clasificare

Evaluarea a fost realizată pe setul de test, separat de antrenare.

precision    recall  f1-score   support

Niciunul            1.00      0.89      0.94       345
Supraincalzire      0.90      0.98      0.94        96
Uzura excesiva      0.77      0.95      0.85        94
Vibratii            0.81      0.87      0.84        95

accuracy                               0.91       630
macro avg           0.87      0.92      0.89       630
weighted avg        0.92      0.91      0.91       630


# Evaluarea regresiei (uzură)

MAE  = 11.02
RMSE = 14.82


# Analiza erorilor

Erorile apar în principal între:

Uzura excesivă și Vibrații

situații cu valori intermediare ale temperaturii și vibrațiilor

Acest comportament este justificat fizic, deoarece defectele pot coexista sau avea semnături similare în datele senzoriale.

# Integrarea în aplicația Flask

Modelul final a fost integrat într-o aplicație web Flask (app.py) care permite:

introducerea parametrilor tehnologici

selectarea sculei și materialului

obținerea predicției în timp real

   # Caracteristici aplicație

reutilizează același scaler și aceiași encoders ca la antrenare

previne valori categorice necunoscute

separă clar logica de inferență (predict.py) de UI
