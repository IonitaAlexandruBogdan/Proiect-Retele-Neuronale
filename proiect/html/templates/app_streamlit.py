import streamlit as st
from predict import predict_uzura  
import pickle
import os

scule_disponibile = [
    ("Freza", "FREZA CARBURA Ø10 4F"),
    ("Freza", "FREZA HSS Ø8 2F"),
    ("Burghiu", "CARBIDE DRILL Ø12"),
    ("Burghiu", "HSS DRILL Ø6"),
    ("Tarod", "TAROD M10 ISO2"),
    ("Placuta amovibila", "WNMG080408"),
    ("Placuta amovibila", "CNMG120408"),
]

materiale = ["Otel", "Aluminiu", "Inox"]

st.title("🔧 Predictie Uzura și Defect CNC")

st.sidebar.header("Selectați scula și materialul")
scula_index = st.sidebar.selectbox("Alege scula:", list(range(len(scule_disponibile))),
                                   format_func=lambda x: f"{scule_disponibile[x][0]} - {scule_disponibile[x][1]}")
material = st.sidebar.selectbox("Material prelucrat:", materiale)

st.sidebar.header("Parametri de prelucrare")
turatie = st.sidebar.number_input("Turație RPM", min_value=100, max_value=10000, value=1500)
avans = st.sidebar.number_input("Avans mm/min", min_value=10.0, max_value=5000.0, value=500.0)
adancime = st.sidebar.number_input("Adancime așchiere mm", min_value=0.1, max_value=10.0, value=2.0)
debit = st.sidebar.number_input("Debit lichid răcire L/min", min_value=0.0, max_value=100.0, value=5.0)
temperatura = st.sidebar.number_input("Temperatura C", min_value=0.0, max_value=200.0, value=30.0)
vibratii = st.sidebar.number_input("Vibrații mm/s", min_value=0.0, max_value=20.0, value=0.5)
zgomot = st.sidebar.number_input("Zgomot dB", min_value=0.0, max_value=150.0, value=70.0)

if st.button("Predict Uzura și Defect"):
    try:
        tip_scula, model_scula = scule_disponibile[scula_index]

        input_dict = {
            "Tip_Scula": tip_scula,
            "Model_Scula": model_scula,
            "Material_Prelucrat": material,
            "Turatie_RPM": turatie,
            "Avans_mm_min": avans,
            "Adancime_Aschiere_mm": adancime,
            "Debit_Lichid_racire_L_min": debit,
            "Temperatura_C": temperatura,
            "Vibratii_mm_s": vibratii,
            "Zgomot_dB": zgomot
        }

        uzura_pred = predict_uzura(input_dict)  

        st.success(f"Predicție Uzură: {uzura_pred:.2f}%")
        st.info("Tipul defectului estimat: **N/A** (poți adăuga model multi-class aici)")

    except Exception as e:
        st.error(f"Eroare la predicție: {str(e)}")
