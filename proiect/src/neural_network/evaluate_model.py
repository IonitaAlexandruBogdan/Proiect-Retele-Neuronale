import csv, pickle, numpy as np
from sklearn.metrics import classification_report
from tensorflow.keras.models import load_model

def load(path):
    with open(path, encoding="utf-8") as f:
        return list(csv.DictReader(f))

numeric = [
    "Turatie_RPM","Avans_mm_min","Adancime_Aschiere_mm",
    "Debit_Lichid_racire_L_min","Temperatura_C",
    "Vibratii_mm_s","Uzura_procent","Zgomot_dB"
]
categorical = ["Tip_Scula","Model_Scula","Material_Prelucrat","Tip_Operatie"]

test = load("d:/facultate/an 3/rn/proiect/data/test/test.csv")

scaler = pickle.load(open("scaler.pkl","rb"))
enc = pickle.load(open("encoder.pkl","rb"))
tgt = pickle.load(open("target.pkl","rb"))
model = load_model("model_cnc.keras")

Xn = scaler.transform([[float(r[f]) for f in numeric] for r in test])
Xc = enc.transform([[r[f] for f in categorical] for r in test])
X = np.hstack([Xn, Xc])

y_true = tgt.transform([r["Tip_Defect"] for r in test])
y_pred = np.argmax(model.predict(X), axis=1)

print(classification_report(y_true, y_pred, target_names=tgt.classes_))
