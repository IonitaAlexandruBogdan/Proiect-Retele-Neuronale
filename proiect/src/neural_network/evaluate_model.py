import csv
import os
import pickle
import numpy as np

from sklearn.metrics import accuracy_score, f1_score
from tensorflow.keras.models import load_model

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

TEST_FILE = os.path.join(BASE_DIR, "..", "..", "data", "test", "test.csv")

MODEL_FILE = os.path.join(BASE_DIR, "model_cnc_multiclass.keras")
SCALER_FILE = os.path.join(BASE_DIR, "scaler_cnc.pkl")
ENCODERS_FILE = os.path.join(BASE_DIR, "encoders_cnc.pkl")
TARGET_ENCODER_FILE = os.path.join(BASE_DIR, "target_encoder.pkl")

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

target_field = "Tip_Defect"  

# -------------------------
def read_csv(path):
    with open(path, "r", encoding="utf-8") as f:
        return list(csv.DictReader(f))

def preprocess(data, scaler, encoders, target_encoder):
    X_num = np.array([[float(row[f]) for f in numeric_fields] for row in data])
    X_num = scaler.transform(X_num)

    X_cat = []
    for f in categorical_fields:
        le = encoders[f]
        X_cat.append(le.transform([row[f] for row in data]))
    X_cat = np.array(X_cat).T

    X = np.hstack([X_num, X_cat])

    y = target_encoder.transform([row[target_field] for row in data])

    return X, y

def evaluate():
    print("Incarcare model si preprocessing...")
    model = load_model(MODEL_FILE, compile=False)

    with open(SCALER_FILE, "rb") as f:
        scaler = pickle.load(f)
    with open(ENCODERS_FILE, "rb") as f:
        encoders = pickle.load(f)
    with open(TARGET_ENCODER_FILE, "rb") as f:
        target_encoder = pickle.load(f)

    print("Citire test set...")
    test_data = read_csv(TEST_FILE)
    X_test, y_test = preprocess(test_data, scaler, encoders, target_encoder)

    print("Predictii...")
    y_prob = model.predict(X_test)
    y_pred = np.argmax(y_prob, axis=1)

    acc = accuracy_score(y_test, y_pred)
    f1 = f1_score(y_test, y_pred, average="macro")

    print("\n===== METRICI TEST SET =====")
    print(f"Acuratete (Accuracy): {acc:.3f}")
    print(f"F1-score (macro):     {f1:.3f}")

if __name__ == "__main__":
    evaluate()
