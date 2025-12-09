import csv
import numpy as np
from sklearn.preprocessing import MinMaxScaler, LabelEncoder
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense
from tensorflow.keras.losses import MeanSquaredError
from tensorflow.keras.metrics import MeanAbsoluteError
import pickle
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

MODEL_FILE = os.path.join(BASE_DIR, "model_cnc.keras")        # format Keras 3
SCALER_FILE = os.path.join(BASE_DIR, "scaler_cnc.pkl")
ENCODERS_FILE = os.path.join(BASE_DIR, "encoders_cnc.pkl")
DATA_FILE = os.path.join(BASE_DIR, "..", "..", "data", "processed", "Dataset_CNC_processed.csv")

def train_model():
    data = []
    with open(DATA_FILE, "r", encoding="utf-8") as f:
        reader = csv.DictReader(f)
        for row in reader:
            data.append(row)

    numeric_fields = ["Turatie_RPM", "Avans_mm_min", "Adancime_Aschiere_mm",
                      "Debit_Lichid_racire_L_min", "Temperatura_C", "Vibratii_mm_s", "Zgomot_dB"]
    categorical_fields = ["Tip_Scula", "Model_Scula", "Material_Prelucrat"]
    target_field = "Uzura_procent"

    # valori numerice
    X_numeric = np.array([[float(row[f]) for f in numeric_fields] for row in data], dtype=float)
    scaler = MinMaxScaler()
    X_numeric = scaler.fit_transform(X_numeric)

    # valori categoriale
    X_categ = []
    encoders = {}
    for f in categorical_fields:
        le = LabelEncoder()
        vals = [row[f] for row in data]
        le.fit(vals)
        encoders[f] = le
        X_categ.append(le.transform(vals))
    X_categ = np.array(X_categ).T

    X = np.hstack([X_numeric, X_categ])
    y = np.array([float(row[target_field]) for row in data], dtype=float)

    # Model neural
    model = Sequential()
    model.add(Dense(64, input_dim=X.shape[1], activation='relu'))
    model.add(Dense(32, activation='relu'))
    model.add(Dense(1, activation='linear'))
    model.compile(optimizer='adam', loss=MeanSquaredError(), metrics=[MeanAbsoluteError()])

    # Antrenare
    model.fit(X, y, epochs=50, batch_size=32, validation_split=0.1)

    # Salvare model si scaler / encoders
    model.save(MODEL_FILE)
    with open(SCALER_FILE, "wb") as f:
        pickle.dump(scaler, f)
    with open(ENCODERS_FILE, "wb") as f:
        pickle.dump(encoders, f)

    print("Model antrenat si salvat cu succes!")

if __name__ == "__main__":
    train_model()
