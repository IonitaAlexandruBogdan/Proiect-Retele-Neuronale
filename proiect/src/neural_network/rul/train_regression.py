import csv
import os
import pickle
import numpy as np

from sklearn.preprocessing import MinMaxScaler, OneHotEncoder
from sklearn.metrics import mean_absolute_error

from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Dropout
from tensorflow.keras.callbacks import EarlyStopping

# =============================
# Paths 
# =============================
BASE = "d:/facultate/an 3/rn/proiect/"

PROJECT_ROOT = BASE  # echivalent cu "root-ul proiectului"

TRAIN_FILE = PROJECT_ROOT + "data/train/train.csv"
VAL_FILE   = PROJECT_ROOT + "data/validation/val.csv"

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

target_field = "Uzura_procent"

# =============================
def read_csv(path):
    with open(path, "r", encoding="utf-8") as f:
        return list(csv.DictReader(f))

def prepare(data, scaler=None, encoder=None, fit=False):

    X_num = np.array([[float(r[f]) for f in numeric_fields] for r in data])

    if fit:
        scaler = MinMaxScaler()
        X_num = scaler.fit_transform(X_num)
    else:
        X_num = scaler.transform(X_num)

    X_cat_raw = [[r[f] for f in categorical_fields] for r in data]

    if fit:
        encoder = OneHotEncoder(handle_unknown="ignore", sparse_output=False)
        X_cat = encoder.fit_transform(X_cat_raw)
    else:
        X_cat = encoder.transform(X_cat_raw)

    X = np.hstack([X_num, X_cat])
    y = np.array([float(r[target_field]) for r in data])

    return X, y, scaler, encoder

# =============================
def build_model(input_dim):
    model = Sequential([
        Dense(128, activation="relu", input_dim=input_dim),
        Dropout(0.3),
        Dense(64, activation="relu"),
        Dropout(0.2),
        Dense(1, activation="linear")
    ])

    model.compile(
        optimizer="adam",
        loss="mse",
        metrics=["mae"]
    )
    return model

# =============================
def train():
    train_data = read_csv(TRAIN_FILE)
    val_data   = read_csv(VAL_FILE)

    X_train, y_train, scaler, encoder = prepare(train_data, fit=True)
    X_val, y_val, _, _ = prepare(val_data, scaler, encoder)

    model = build_model(X_train.shape[1])

    es = EarlyStopping(
        monitor="val_loss",
        patience=10,
        restore_best_weights=True
    )

    model.fit(
        X_train, y_train,
        validation_data=(X_val, y_val),
        epochs=100,
        batch_size=32,
        callbacks=[es],
        verbose=1
    )

    model.save(MODEL_FILE)
    pickle.dump(scaler, open(SCALER_FILE, "wb"))
    pickle.dump(encoder, open(ENCODER_FILE, "wb"))

    print(" Model REGRESIE antrenat!")

if __name__ == "__main__":
    train()
