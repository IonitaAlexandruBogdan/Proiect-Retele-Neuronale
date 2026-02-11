import csv
import os
import pickle
import json
import yaml
import numpy as np
import pandas as pd

from sklearn.preprocessing import MinMaxScaler, LabelEncoder, OneHotEncoder
from sklearn.utils.class_weight import compute_class_weight

from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Dropout
from tensorflow.keras.losses import SparseCategoricalCrossentropy
from tensorflow.keras.metrics import SparseCategoricalAccuracy
from tensorflow.keras.callbacks import EarlyStopping, History

# === ADDED ===
import matplotlib.pyplot as plt
from sklearn.metrics import confusion_matrix, ConfusionMatrixDisplay
# =============

# =============================
# Paths
# =============================
BASE = "d:/facultate/an 3/rn/proiect/"

INPUT = BASE + "data/raw/Dataset_CNC.csv"


TRAIN_FILE = BASE + "data/train/train.csv"
VAL_FILE   = BASE + "data/validation/val.csv"
TEST_FILE  = BASE + "data/test/test.csv"

MODEL_FILE = BASE + "models/model_cnc_multiclass.keras"
SCALER_FILE = BASE + "models/scaler_cnc.pkl"
ENCODERS_FILE = BASE + "models/encoders_cnc.pkl"
TARGET_ENCODER_FILE = BASE + "models/target_encoder.pkl"

RESULTS_DIR = os.path.join(BASE, "results")
os.makedirs(RESULTS_DIR, exist_ok=True)

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

target_field = "Tip_Defect"

# =============================
# Utils
# =============================
def read_csv(path):
    with open(path, "r", encoding="utf-8") as f:
        return list(csv.DictReader(f))

# =============================
# Preprocesare
# =============================
def prepare_data(data, scaler=None, cat_encoder=None, target_encoder=None, fit=False):
    X_num = np.array([[float(row[f]) for f in numeric_fields] for row in data])
    if fit:
        scaler = MinMaxScaler()
        X_num = scaler.fit_transform(X_num)
    else:
        X_num = scaler.transform(X_num)

    X_cat_raw = [[row[f] for f in categorical_fields] for row in data]
    if fit:
        cat_encoder = OneHotEncoder(handle_unknown="ignore", sparse_output=False)
        X_cat = cat_encoder.fit_transform(X_cat_raw)
    else:
        X_cat = cat_encoder.transform(X_cat_raw)

    X = np.hstack([X_num, X_cat])

    if fit:
        target_encoder = LabelEncoder()
        y = target_encoder.fit_transform([row[target_field] for row in data])
    else:
        y = target_encoder.transform([row[target_field] for row in data])

    return X, y, scaler, cat_encoder, target_encoder

# =============================
# Model
# =============================
def build_model(input_dim, num_classes):
    model = Sequential([
        Dense(128, activation="relu", input_dim=input_dim),
        Dropout(0.3),
        Dense(64, activation="relu"),
        Dropout(0.2),
        Dense(num_classes, activation="softmax")
    ])

    model.compile(
        optimizer="adam",
        loss=SparseCategoricalCrossentropy(),
        metrics=[SparseCategoricalAccuracy()]
    )
    return model

# =============================
# Train
# =============================
def train_model():
    print("Citire date...")
    train_data = read_csv(TRAIN_FILE)
    val_data   = read_csv(VAL_FILE)
    test_data  = read_csv(TEST_FILE)

    print("Preprocesare train...")
    X_train, y_train, scaler, cat_encoder, target_encoder = prepare_data(train_data, fit=True)
    X_val, y_val, _, _, _ = prepare_data(val_data, scaler, cat_encoder, target_encoder, fit=False)
    X_test, y_test, _, _, _ = prepare_data(test_data, scaler, cat_encoder, target_encoder, fit=False)

    print("Construire model...")
    model = build_model(input_dim=X_train.shape[1], num_classes=len(target_encoder.classes_))

    print("Calcul class weights...")
    class_weights = compute_class_weight(
        class_weight="balanced",
        classes=np.unique(y_train),
        y=y_train
    )
    class_weights = dict(enumerate(class_weights))

    early_stop = EarlyStopping(
        monitor="val_loss",
        patience=10,
        restore_best_weights=True,
        verbose=1
    )

    print("Antrenare model...")
    history = model.fit(
        X_train, y_train,
        epochs=100,
        batch_size=32,
        validation_data=(X_val, y_val),
        class_weight=class_weights,
        callbacks=[early_stop],
        verbose=1
    )

    # =============================
    # ADDED: Training Accuracy Plot
    # =============================
    plt.figure()
    plt.plot(history.history["sparse_categorical_accuracy"], label="Train Accuracy")
    plt.plot(history.history["val_sparse_categorical_accuracy"], label="Val Accuracy")
    plt.xlabel("Epoch")
    plt.ylabel("Accuracy")
    plt.title("Training & Validation Accuracy")
    plt.legend()
    plt.tight_layout()
    plt.savefig(os.path.join(RESULTS_DIR, "training_accuracy.png"))
    plt.close()

    # =============================
    # ADDED: Training Loss Plot
    # =============================
    plt.figure()
    plt.plot(history.history["loss"], label="Train Loss")
    plt.plot(history.history["val_loss"], label="Val Loss")
    plt.xlabel("Epoch")
    plt.ylabel("Loss")
    plt.title("Training & Validation Loss")
    plt.legend()
    plt.tight_layout()
    plt.savefig(os.path.join(RESULTS_DIR, "training_loss.png"))
    plt.close()

    # =============================
    # Save model + preprocessing
    # =============================
    model.save(MODEL_FILE)
    with open(SCALER_FILE, "wb") as f:
        pickle.dump(scaler, f)
    with open(ENCODERS_FILE, "wb") as f:
        pickle.dump(cat_encoder, f)
    with open(TARGET_ENCODER_FILE, "wb") as f:
        pickle.dump(target_encoder, f)

    hist_df = pd.DataFrame(history.history)
    hist_df.to_csv(os.path.join(RESULTS_DIR, "training_history.csv"), index=False)

    test_loss, test_acc = model.evaluate(X_test, y_test, verbose=0)
    y_prob = model.predict(X_test)
    y_pred = np.argmax(y_prob, axis=1)

    # =============================
    # ADDED: Confusion Matrix
    # =============================
    cm = confusion_matrix(y_test, y_pred)
    disp = ConfusionMatrixDisplay(
        confusion_matrix=cm,
        display_labels=target_encoder.classes_
    )

    plt.figure(figsize=(8, 6))
    disp.plot(cmap="Blues", values_format="d")
    plt.title("Confusion Matrix")
    plt.tight_layout()
    plt.savefig(os.path.join(RESULTS_DIR, "confusion_matrix.png"))
    plt.close()

    from sklearn.metrics import accuracy_score, f1_score, classification_report
    metrics = {
        "accuracy": float(accuracy_score(y_test, y_pred)),
        "f1_macro": float(f1_score(y_test, y_pred, average="macro")),
        "classification_report": classification_report(
            y_test,
            y_pred,
            target_names=target_encoder.classes_,
            output_dict=True
        )
    }

    with open(os.path.join(RESULTS_DIR, "test_metrics.json"), "w") as f:
        json.dump(metrics, f, indent=4)

    hyperparams = {
        "learning_rate": 0.001,
        "batch_size": 32,
        "epochs": len(history.history["loss"]),
        "optimizer": "Adam",
        "loss_function": "SparseCategoricalCrossentropy",
        "activation_hidden": "ReLU",
        "activation_output": "Softmax",
        "dropout": [0.3, 0.2],
        "early_stopping_patience": 10
    }

    with open(os.path.join(RESULTS_DIR, "hyperparameters.yaml"), "w") as f:
        yaml.dump(hyperparams, f)

    print("Model antrenat și toate graficele au fost salvate în folderul 'results/'")

if __name__ == "__main__":
    train_model()

#    "Turatie_RPM": 3200,              turația în rotații pe minut
#   "Avans_mm_min": 450.0,             avansul materialului
#    "Adancime_Aschiere_mm": 1.5,       adâncimea tăierii
#    "Debit_Lichid_racire_L_min": 12,   lichid de răcire
#    "Temperatura_C": 55.0,             temperatura sculei
#    "Vibratii_mm_s": 1.2,              vibrații măsurate
#    "Zgomot_dB": 68.0,                 nivel de zgomot
#    "Tip_Scula": "Freza",              tip sculă
#    "Model_Scula": "FREZA HSS Ø8 2F",  model sculă
#    "Material_Prelucrat": "Otel"       materialul piesei
