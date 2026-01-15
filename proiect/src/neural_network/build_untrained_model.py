import os
import pickle
import numpy as np
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense
from tensorflow.keras.losses import SparseCategoricalCrossentropy
from tensorflow.keras.metrics import SparseCategoricalAccuracy

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

MODEL_FILE = os.path.join(BASE_DIR, "untrained_model.keras")
SCALER_FILE = os.path.join(BASE_DIR, "scaler_cnc_untrained.pkl")
ENCODERS_FILE = os.path.join(BASE_DIR, "encoders_cnc_untrained.pkl")
TARGET_ENCODER_FILE = os.path.join(BASE_DIR, "target_encoder_untrained.pkl")

numeric_fields = [
    "Turatie_RPM", "Avans_mm_min", "Adancime_Aschiere_mm",
    "Debit_Lichid_racire_L_min", "Temperatura_C", "Vibratii_mm_s", "Zgomot_dB"
]

categorical_fields = ["Tip_Scula", "Model_Scula", "Material_Prelucrat"]

num_classes = 4  

def build_untrained_model(input_dim, num_classes):
    model = Sequential()
    model.add(Dense(64, activation='relu', input_dim=input_dim))
    model.add(Dense(32, activation='relu'))
    model.add(Dense(num_classes, activation='softmax'))

    model.compile(
        optimizer='adam',
        loss=SparseCategoricalCrossentropy(),
        metrics=[SparseCategoricalAccuracy()]
    )
    return model

def save_untrained_model():
    input_dim = len(numeric_fields) + len(categorical_fields)
    model = build_untrained_model(input_dim, num_classes)
    model.save(MODEL_FILE)

    scaler = None
    encoders = {f: None for f in categorical_fields}
    target_encoder = None

    with open(SCALER_FILE, "wb") as f:
        pickle.dump(scaler, f)
    with open(ENCODERS_FILE, "wb") as f:
        pickle.dump(encoders, f)
    with open(TARGET_ENCODER_FILE, "wb") as f:
        pickle.dump(target_encoder, f)

    print("Model neantrenat salvat cu succes!")

if __name__ == "__main__":
    save_untrained_model()
