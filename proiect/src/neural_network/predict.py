import os
from tensorflow.keras.models import load_model
import pickle
import numpy as np

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

# -------------------------
# Fisiere model si preprocessing
# -------------------------
MODEL_FILE = os.path.join(BASE_DIR, "model_cnc.keras")       # sau .h5 dacă ai salvat așa
SCALER_FILE = os.path.join(BASE_DIR, "scaler_cnc.pkl")
ENCODERS_FILE = os.path.join(BASE_DIR, "encoders_cnc.pkl")

# -------------------------
# Câmpuri folosite la antrenare
# -------------------------
numeric_fields = [
    "Turatie_RPM",
    "Avans_mm_min",
    "Adancime_Aschiere_mm",
    "Debit_Lichid_racire_L_min",
    "Temperatura_C",
    "Vibratii_mm_s",
    "Zgomot_dB"
]

categorical_fields = [
    "Tip_Scula",
    "Model_Scula",
    "Material_Prelucrat"
]

# -------------------------
# Încarcare model și preprocessing
# -------------------------
model = load_model(MODEL_FILE, compile=False)

with open(SCALER_FILE, "rb") as f:
    scaler = pickle.load(f)

with open(ENCODERS_FILE, "rb") as f:
    encoders = pickle.load(f)

# -------------------------
# Preprocesare input
# -------------------------
def preprocess_input(input_dict):
    # Numeric
    numeric_values = np.array([float(input_dict[f]) for f in numeric_fields]).reshape(1, -1)
    X_numeric = scaler.transform(numeric_values)

    # Categorical
    X_categ = []
    for f in categorical_fields:
        le = encoders[f]
        val = input_dict[f]
        if val not in le.classes_:
            raise ValueError(f"Valoare necunoscuta pentru {f}: '{val}'")
        X_categ.append(le.transform([val])[0])
    X_categ = np.array(X_categ).reshape(1, -1)

    # Concatenare
    X = np.hstack([X_numeric, X_categ])
    return X

# -------------------------
# Predictie uzura
# -------------------------
def predict_uzura(input_dict):
    X = preprocess_input(input_dict)
    pred = model.predict(X)[0][0]
    return float(pred)

# -------------------------
# Test rapid
# -------------------------
if __name__ == "__main__":
    # Exemplu de input complet
    test_input = {
        "Tip_Scula": "Freza",
        "Model_Scula": "FREZA CARBURA Ø10 4F",
        "Material_Prelucrat": "Otel",
        "Turatie_RPM": 1200,
        "Avans_mm_min": 500,
        "Adancime_Aschiere_mm": 2,
        "Debit_Lichid_racire_L_min": 5,
        "Temperatura_C": 30,
        "Vibratii_mm_s": 0.5,
        "Zgomot_dB": 70
    }
    print("Predicted uzura:", predict_uzura(test_input))
