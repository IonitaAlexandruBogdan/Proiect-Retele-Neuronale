from flask import Flask, render_template, request

app = Flask(__name__)

# Lista sculelor disponibile
scule_disponibile = [
    ("Freza", "FREZA CARBURA Ø10 4F"),
    ("Freza", "FREZA HSS Ø8 2F"),
    ("Burghiu", "CARBIDE DRILL Ø12"),
    ("Burghiu", "HSS DRILL Ø6"),
    ("Taraud", "TAROD M10 ISO2"),
    ("Placuta amovibila", "WNMG080408"),
    ("Placuta amovibila", "CNMG120408"),
]

# Parametri nominali tipici
turatie_nominala = 5000
avans_nominal = 600
adancime_nominala = 2.0
uzura_max = 100

def estimeaza_viata(turatie, avans, adancime, uzura):
    factor = (turatie / turatie_nominala + avans / avans_nominal + adancime / adancime_nominala) / 3
    uzura_ajustata = uzura * factor
    timp_ramas = max(0, uzura_max - uzura_ajustata)
    return round(factor, 2), round(timp_ramas, 2)

@app.route("/", methods=["GET", "POST"])
def index():
    rezultat = None
    if request.method == "POST":
        alegere = int(request.form["scula"])
        tip_scula, model_scula = scule_disponibile[alegere]

        turatie = float(request.form["turatie"])
        avans = float(request.form["avans"])
        adancime = float(request.form["adancime"])
        uzura = float(request.form["uzura"])

        factor, timp_ramas = estimeaza_viata(turatie, avans, adancime, uzura)

        rezultat = {
            "tip_scula": tip_scula,
            "model_scula": model_scula,
            "factor": factor,
            "timp_ramas": timp_ramas
        }

    return render_template("index.html", scule=scule_disponibile, rezultat=rezultat)

if __name__ == "__main__":
    app.run(debug=True)
