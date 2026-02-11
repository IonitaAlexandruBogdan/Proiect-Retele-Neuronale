import streamlit as st
import numpy as np
import pickle
from tensorflow.keras.models import load_model
import matplotlib.pyplot as plt
import os

# =============================
# PATHS
# =============================
BASE = "d:/facultate/an 3/rn/proiect/"

MODEL_CLASS_FILE   = BASE + "models/model_cnc_multiclass.keras"
MODEL_RUL_FILE     = BASE + "models/model_cnc_regression.keras"
SCALER_FILE        = BASE + "models/scaler_cnc.pkl"
ENCODERS_FILE      = BASE + "models/encoders_cnc.pkl"
TARGET_ENCODER_FILE = BASE + "models/target_encoder.pkl"


# =============================
# LOAD RESOURCES
# =============================
@st.cache_resource
def load_resources():
    assert os.path.exists(MODEL_CLASS_FILE), f"Model clasificare nu există: {MODEL_CLASS_FILE}"
    assert os.path.exists(MODEL_RUL_FILE), f"Model RUL nu există: {MODEL_RUL_FILE}"

    model_cls = load_model(MODEL_CLASS_FILE, compile=False)
    model_rul = load_model(MODEL_RUL_FILE, compile=False)

    with open(SCALER_FILE, "rb") as f:
        scaler = pickle.load(f)
    with open(ENCODERS_FILE, "rb") as f:
        encoders = pickle.load(f)
    with open(TARGET_ENCODER_FILE, "rb") as f:
        target_encoder = pickle.load(f)

    return model_cls, model_rul, scaler, encoders, target_encoder

model_cls, model_rul, scaler, encoders, target_encoder = load_resources()

# =============================
# UI
# =============================
st.set_page_config(page_title="SIA CNC – Monitorizare", layout="wide")
st.title(" Sistem Inteligent de Analiză CNC")
st.subheader("Clasificare defect + Estimare RUL")

# =============================
# INPUT
# =============================
st.sidebar.header("Parametri proces")

num_features = np.array([[ 
    st.sidebar.number_input("Turație (RPM)", 500, 15000, 4500),
    st.sidebar.number_input("Avans (mm/min)", 50, 5000, 1200),
    st.sidebar.number_input("Adâncime așchiere (mm)", 0.1, 10.0, 2.5),
    st.sidebar.number_input("Debit lichid (L/min)", 0.0, 50.0, 12.0),
    st.sidebar.number_input("Temperatură (°C)", 20.0, 150.0, 65.0),
    st.sidebar.number_input("Vibrații (mm/s)", 0.0, 20.0, 3.2),
    st.sidebar.number_input("Zgomot (dB)", 40.0, 120.0, 72.0)
]])

cat_features = [[
    st.sidebar.selectbox("Tip sculă", ["Freza", "Burghiu", "Tarod", "Placuta amovibila"]),
    st.sidebar.selectbox("Model sculă", ["FREZA CARBURA Ø10 4F","FREZA HSS Ø8 2F","CARBIDE DRILL Ø12","HSS DRILL Ø6","TAROD M10 ISO2","WNMG080408","CNMG120408"]),
    st.sidebar.selectbox("Material prelucrat", ["Otel", "Aluminiu", "Inox"])
]]

# =============================
# PREPROCESS
# =============================
X_num = scaler.transform(num_features)
X_cat = encoders.transform(cat_features)
X = np.hstack([X_num, X_cat])

# =============================
# PREDICT
# =============================
if st.sidebar.button("Rulează analiza"):

    # Clasificare
    prob = model_cls.predict(X, verbose=0)
    cls_idx = np.argmax(prob, axis=1)[0]
    defect = target_encoder.inverse_transform([cls_idx])[0]

    # RUL
    rul = model_rul.predict(X, verbose=0)[0][0]
    rul = max(0, min(100, rul))

    # =============================
    # OUTPUT
    # =============================
    col1, col2 = st.columns(2)

    with col1:
        st.metric("Defect estimat", defect)
        st.markdown("### Probabilități defect")
        fig, ax = plt.subplots()
        bars = ax.bar(target_encoder.classes_, prob[0], color="skyblue")
        ax.set_ylabel("Probabilitate")
        ax.set_ylim([0,1])
        for bar, p in zip(bars, prob[0]):
            ax.text(bar.get_x() + bar.get_width()/2, bar.get_height()+0.02, f"{p:.2f}", ha="center")
        st.pyplot(fig)

    with col2:
        st.metric("⏳ RUL estimat (%)", f"{rul:.1f} %")
        st.progress(int(rul))
        if rul > 60:
            st.success("🟢 Stare bună")
        elif rul > 30:
            st.warning("🟡 Atenție")
        else:
            st.error("🔴 Mentenanță necesară")

