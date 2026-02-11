import os
import csv
import pickle
import numpy as np

from sklearn.metrics import mean_absolute_error, mean_squared_error
from tensorflow.keras.models import load_model

# =============================
# Paths 
# =============================
BASE = "d:/facultate/an 3/rn/proiect/"

PROJECT_ROOT = BASE  # rădăcina proiectului

TEST_FILE = PROJECT_ROOT + "data/test/test.csv"

MODEL_FILE  = BASE + "models/model_cnc_regression.keras"
SCALER_FILE = BASE + "models/scaler_reg.pkl"
ENCODER_FILE = BASE + "models/encoder_reg.pkl"


# =============================
# Features
# =============================
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

TARGET_FIELD = "Uzura_procent"

# =============================
# Utils
# =============================
def read_csv(path):
    with open(path, "r", encoding="utf-8") as f:
        return list(csv.DictReader(f))

# =============================
# Preprocesare
# =============================
def preprocess(data, scaler, encoder):
    X_num = np.array([[float(row[f]) for f in numeric_fields] for row in data])
    X_num = scaler.transform(X_num)

    X_cat_raw = [[row[f] for f in categorical_fields] for row in data]
    X_cat = encoder.transform(X_cat_raw)

    X = np.hstack([X_num, X_cat])

    y = np.array([float(row[TARGET_FIELD]) for row in data])

    return X, y

# =============================
# Evaluate
# =============================
def evaluate():
    print("Încarcare model + preprocessing...")
    model = load_model(MODEL_FILE, compile=False)

    with open(SCALER_FILE, "rb") as f:
        scaler = pickle.load(f)

    with open(ENCODER_FILE, "rb") as f:
        encoder = pickle.load(f)

    print("Citire test set...")
    test_data = read_csv(TEST_FILE)
    X_test, y_test = preprocess(test_data, scaler, encoder)

    print("Predictii RUL / uzura...")
    y_pred = model.predict(X_test).flatten()

    mae = mean_absolute_error(y_test, y_pred)
    rmse = np.sqrt(mean_squared_error(y_test, y_pred))

    print("\n===== METRICI REGRESIE =====")
    print(f"MAE  : {mae:.2f}")
    print(f"RMSE : {rmse:.2f}")

if __name__ == "__main__":
    evaluate()
