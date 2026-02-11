# Documentație Arhitectură Rețele Neuronale CNC

Acest proiect conține module pentru **antrenarea și evaluarea modelelor de regresie și clasificare** pe date CNC generate sintetic. Modelele prezic atât **uzura sculelor** (regresie) cât și **tipul defectului** (clasificare).

---

## 1. Structura proiectului


---

## 2. Cerințe

- Python >= 3.10
- pip >= 21.0
- virtualenv sau venv (recomandat)
- Streamlit >= 1.30 (pentru UI)
- TensorFlow >= 2.14
- Keras >= 2.14
- numpy >= 1.25
- pandas >= 2.1
- opencv-python >= 4.8
- matplotlib >= 3.8
- scikit-learn >= 1.3
- pyyaml

---

## 3. Instalare

```bash
# Clonare repository
git clone [URL_REPOSITORY]
cd proiect-rn-[nume-prenume]

# Creare mediu virtual
python -m venv venv
# Linux/Mac:
source venv/bin/activate
# Windows:
venv\Scripts\activate

# Instalare dependențe
pip install -r requirements.txt

---

4. Generare dataset

python src/preprocessing/data_generator.py

5. Antrenare modele
5.1 Model regresie (uzura)

python src/neural_network/train_regression.py

Salvează modelul în: models/model_cnc_regression.keras

Salvează scaler și encoder pentru preprocesare

5.2 Model multiclass (tip defect)

python src/neural_network/train_model.py

Salvează modelul în: models/model_cnc_multiclass.keras

Salvează scaler, encodere și target encoder

Salvează rezultate: results/training_history.csv, results/test_metrics.json, results/hyperparameters.yaml

6. Evaluare modele
6.1 Regresie

python src/neural_network/evaluate_regression.py

Calculează MAE și RMSE pe setul de test

Folosește modelul și preprocesarea salvată

6.2 Clasificare

python src/neural_network/evaluate_model.py

Afișează classification report (accuracy, f1-score, etc.)

Folosește modelul și encoderele salvate

7. Preprocesare

Numeric: Turatie_RPM, Avans_mm_min, Adancime_Aschiere_mm, Debit_Lichid_racire_L_min, Temperatura_C, Vibratii_mm_s, Zgomot_dB

Categorical: Tip_Scula, Model_Scula, Material_Prelucrat

Target regresie: Uzura_procent

Target clasificare: Tip_Defect

8. Exemple de date

{
  "Turatie_RPM": 3200,
  "Avans_mm_min": 450.0,
  "Adancime_Aschiere_mm": 1.5,
  "Debit_Lichid_racire_L_min": 12,
  "Temperatura_C": 55.0,
  "Vibratii_mm_s": 1.2,
  "Zgomot_dB": 68.0,
  "Tip_Scula": "Freza",
  "Model_Scula": "FREZA HSS Ø8 2F",
  "Material_Prelucrat": "Otel",
  "Tip_Defect": "Niciunul"
}

9. UI (Streamlit)

streamlit run src/app/main.py

Vizualizare predicții regresie și clasificare
