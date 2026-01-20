import os
from flask import Flask, render_template, request
from predict import predict_uzura  

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
TEMPLATE_DIR = os.path.join(BASE_DIR, "../../html/templates")
STATIC_DIR = os.path.join(BASE_DIR, "../../html/static")

app = Flask(__name__, template_folder=TEMPLATE_DIR, static_folder=STATIC_DIR)

scule_disponibile = [
    ("Freza", "FREZA CARBURA Ø10 4F"),
    ("Freza", "FREZA HSS Ø8 2F"),
    ("Burghiu", "CARBIDE DRILL Ø12"),
    ("Burghiu", "HSS DRILL Ø6"),
    ("Tarod", "TAROD M10 ISO2"),
    ("Placuta amovibila", "WNMG080408"),
    ("Placuta amovibila", "CNMG120408"),
]

@app.route("/", methods=["GET", "POST"])
def index():
    rezultat = None
    if request.method == "POST":
        try:
            alegere = int(request.form["scula"])
            tip_scula, model_scula = scule_disponibile[alegere]

            input_dict = {
                "Tip_Scula": tip_scula,
                "Model_Scula": model_scula,
                "Material_Prelucrat": request.form["material"],
                "Turatie_RPM": float(request.form["turatie"]),
                "Avans_mm_min": float(request.form["avans"]),
                "Adancime_Aschiere_mm": float(request.form["adancime"]),
                "Debit_Lichid_racire_L_min": float(request.form["debit"]),
                "Temperatura_C": float(request.form["temperatura"]),
                "Vibratii_mm_s": float(request.form["vibratii"]),
                "Zgomot_dB": float(request.form["zgomot"])
            }

            uzura_pred = predict_uzura(input_dict)

            rezultat = {
                "tip_scula": tip_scula,
                "model_scula": model_scula,
                "uzura_pred": uzura_pred
            }

        except Exception as e:
            rezultat = {"error": str(e)}

    return render_template("index.html", scule=scule_disponibile, rezultat=rezultat)

if __name__ == "__main__":
    app.run(debug=True)
