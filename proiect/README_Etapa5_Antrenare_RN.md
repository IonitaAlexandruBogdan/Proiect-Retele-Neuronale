# 📘 README – Etapa 5: Configurarea și Antrenarea Modelului RN

**Disciplina:** Rețele Neuronale  
**Instituție:** POLITEHNICA București – FIIR  
**Student:** [Ionita Alexandru Bogdan ]  
**Link Repository GitHub:** [(https://github.com/IonitaAlexandruBogdan/Proiect-Retele-Neuronale/tree/P5)]
**Data predării:** [15.01.2026]

---

## Scopul Etapei 5

Această etapă are ca scop antrenarea efectivă a rețelei neuronale definite în Etapa 4
pentru detectarea defectelor sculelor CNC și estimarea duratei de viață (RUL).

Modelul este integrat într-o aplicație Streamlit care realizează inferență reală
în timp real, respectând State Machine-ul definit anterior.

# Pregătire Dataset

   Dataset-ul este generat sintetic pentru aplicații CNC și conține:
- Parametri de proces (turație, avans, vibrații etc.)
- Informații despre sculă și material
- Etichete multi-class pentru tip defect
- Variabilă continuă pentru uzură (RUL)

   Clasele sunt:
- Niciunul
- Supraincalzire
- Uzura excesiva
- Vibratii

Dataset-ul a fost împărțit STRATIFICAT:
- 70% Train
- 15% Validation
- 15% Test
random_state = 42

# Arhitectura Rețelei Neuronale

- Input: 7 features numerice + one-hot categorice
- Dense(128, ReLU)
- Dropout(0.3)
- Dense(64, ReLU)
- Dropout(0.2)
- Output: Softmax (4 clase)

Regresie RUL
- Output: 1 neuron (Linear)
- Loss: MSE
- Metrică: MAE

# TABEL HIPERPARAMETRI

| Hiperparametru | Valoare | Justificare |
|---------------|--------|-------------|
| Learning rate | 0.001 | Valoare standard pentru Adam, convergență stabilă |
| Batch size | 32 | Echilibru stabilitate gradient / memorie |
| Epochs | max 100 | Early stopping activ după 10 epoci |
| Optimizer | Adam | Adaptive learning rate, potrivit pentru date eterogene |
| Loss | SparseCategoricalCrossentropy | Clasificare multi-class |
| Activation | ReLU / Softmax | Non-linearitate + probabilități |
| Dropout | 0.3 / 0.2 | Reducere overfitting |

# Antrenare Model

python train_model.py
python train_regression.py

# Evaluare – Metrici

                precision    recall  f1-score   support

      Niciunul       1.00      0.89      0.94       345
Supraincalzire       0.90      0.98      0.94        96
Uzura excesiva       0.77      0.95      0.85        94
      Vibratii       0.81      0.87      0.84        95

      accuracy                           0.91       630
     macro avg       0.87      0.92      0.89       630
  weighted avg       0.92      0.91      0.91       630

===== METRICI REGRESIE =====
MAE  : 11.02
RMSE : 14.82

# Analiză Erori – CONTEXT INDUSTRIAL

Modelul confundă în principal clasele "Vibratii" și "Uzura excesiva",
deoarece ambele prezintă valori ridicate de vibrații și zgomot.

Erorile apar în special când temperatura este moderată,
dar vibrațiile sunt ridicate, scenariu comun în frezare agresivă.

False negative (defect nedetectat) este critic – risc de rupere sculă.
False positive este acceptabil – scula poate fi verificată manual.

1. Creștere număr eșantioane pentru clase rare
2. Ajustare prag decizie pentru clase critice
3. Introducere feature derivat: raport vibrații/zgomot
