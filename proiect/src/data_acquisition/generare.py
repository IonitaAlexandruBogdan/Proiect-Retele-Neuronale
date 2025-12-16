import random
import csv
import os

scule = [
    ("Freza", "FREZA CARBURA Ø10 4F"),
    ("Freza", "FREZA HSS Ø8 2F"),
    ("Burghiu", "CARBIDE DRILL Ø12"),
    ("Burghiu", "HSS DRILL Ø6"),
    ("Tarod", "TAROD M10 ISO2"),
    ("Placuta amovibila", "WNMG080408"),
    ("Placuta amovibila", "CNMG120408"),
]

materiale = ["Otel", "Aluminiu", "Inox"]

operatii = {
    "Freza": "Frezare",
    "Burghiu": "Gaurire",
    "Placuta amovibila": "Strunjire",
    "Tarod": "Filetare"
}

tipuri_defect = ["Niciunul", "Supraincalzire", "Uzura excesiva", "Vibratii"]

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
OUTPUT_DIR = os.path.join(BASE_DIR, "..", "..", "data", "raw")
os.makedirs(OUTPUT_DIR, exist_ok=True)

def generate_sample(id_scula_local, tip_scula, model_scula):
    defect = random.random() < 0.25
    tip_defect = "Niciunul"

    turatie = random.randint(1500, 6000)
    avans = random.uniform(200, 1200)
    adancime = random.uniform(0.1, 3.0)
    debit = random.uniform(5, 20)

    if not defect:
        temperatura = random.uniform(35, 70)
        vibratii = random.uniform(0.5, 2.0)
        uzura = random.uniform(0, 20)
        zgomot = random.uniform(60, 75)
    else:
        temperatura = random.uniform(80, 160)
        vibratii = random.uniform(3.0, 12.0)
        uzura = random.uniform(40, 100)
        zgomot = random.uniform(80, 100)
        tip_defect = random.choice(tipuri_defect[1:])  

    return [
        id_scula_local,          
        tip_scula,
        model_scula,
        int(turatie),
        round(avans, 2),
        round(adancime, 2),
        round(debit, 2),
        round(temperatura, 2),
        round(vibratii, 2),
        round(uzura, 1),
        round(zgomot, 2),
        random.choice(materiale),
        operatii[tip_scula],
        random.randint(1, 500),
        1 if defect else 0,
        tip_defect
    ]

def genereaza_dataset_cnc(numar_per_scule=300, fisier="Dataset_CNC.csv"):
    fisier_output = os.path.join(OUTPUT_DIR, fisier)

    header = [
        "ID_Scula", "Tip_Scula", "Model_Scula", 
        "Turatie_RPM", "Avans_mm_min", "Adancime_Aschiere_mm",
        "Debit_Lichid_racire_L_min", "Temperatura_C", "Vibratii_mm_s",
        "Uzura_procent", "Zgomot_dB", "Material_Prelucrat",
        "Tip_Operatie", "ID_Lot", "Scula_Defecta", "Tip_Defect"
    ]

    with open(fisier_output, mode="w", newline="", encoding="utf-8") as f:
        writer = csv.writer(f)
        writer.writerow(header)

        for tip, model in scule:
            for id_scula_local in range(1, numar_per_scule + 1):
                rand = generate_sample(id_scula_local, tip, model)
                writer.writerow(rand)

    print(f"Fisier generat cu succes: {fisier_output}")


if __name__ == "__main__":
    genereaza_dataset_cnc(300)
