import csv
import os
import pickle
import numpy as np

from sklearn.preprocessing import MinMaxScaler, LabelEncoder
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense
from tensorflow.keras.losses import SparseCategoricalCrossentropy
from tensorflow.keras.metrics import SparseCategoricalAccuracy

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

TRAIN_FILE = os.path.join(BASE_DIR, "..", "..", "data", "train", "train.csv")
VAL_FILE   = os.path.join(BASE_DIR, "..", "..", "data", "validation", "val.csv")

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

target_field = "Tip_Defect"  # schimbat pentru multi-class

# -------------------------
# Citire CSV
def read_csv(path):
    with open(path, "r", encoding="utf-8") as f:
        return list(csv.DictReader(f))

# -------------------------
# Preprocesare date
def prepare_data(data, scaler=None, encoders=None, target_encoder=None, fit=False):
    # Numeric
    X_num = np.array([[float(row[f]) for f in numeric_fields] for row in data])
    if fit:
        scaler = MinMaxScaler()
        X_num = scaler.fit_transform(X_num)
    else:
        X_num = scaler.transform(X_num)

    # Categorical
    X_cat = []
    if fit:
        encoders = {}
        for f in categorical_fields:
            le = LabelEncoder()
            le.fit([row[f] for row in data])
            encoders[f] = le
            X_cat.append(le.transform([row[f] for row in data]))
    else:
        for f in categorical_fields:
            le = encoders[f]
            X_cat.append(le.transform([row[f] for row in data]))
    X_cat = np.array(X_cat).T

    X = np.hstack([X_num, X_cat])

    # Target
    if fit:
        target_encoder = LabelEncoder()
        y = target_encoder.fit_transform([row[target_field] for row in data])
    else:
        y = target_encoder.transform([row[target_field] for row in data])

    return X, y, scaler, encoders, target_encoder

# -------------------------
# Model
def build_model(input_dim, num_classes):
    model = Sequential()
    model.add(Dense(64, activation='relu', input_dim=input_dim))
    model.add(Dense(32, activation='relu'))
    model.add(Dense(num_classes, activation='softmax'))  # softmax pentru multi-class

    model.compile(
        optimizer='adam',
        loss=SparseCategoricalCrossentropy(),
        metrics=[SparseCategoricalAccuracy()]
    )
    return model

# -------------------------
# Antrenare
def train_model():
    train_data = read_csv(TRAIN_FILE)
    val_data   = read_csv(VAL_FILE)

    X_train, y_train, scaler, encoders, target_encoder = prepare_data(train_data, fit=True)
    X_val, y_val, _, _, _ = prepare_data(val_data, scaler, encoders, target_encoder, fit=False)

    model = build_model(X_train.shape[1], num_classes=len(target_encoder.classes_))

    model.fit(
        X_train, y_train,
        epochs=50,
        batch_size=32,
        validation_data=(X_val, y_val),
        verbose=1
    )

    # Salvare model + preprocessing
    model.save(MODEL_FILE)
    with open(SCALER_FILE, "wb") as f:
        pickle.dump(scaler, f)
    with open(ENCODERS_FILE, "wb") as f:
        pickle.dump(encoders, f)
    with open(TARGET_ENCODER_FILE, "wb") as f:
        pickle.dump(target_encoder, f)

    print("Model multi-class antrenat si salvat cu succes!")

if __name__ == "__main__":
    train_model()
