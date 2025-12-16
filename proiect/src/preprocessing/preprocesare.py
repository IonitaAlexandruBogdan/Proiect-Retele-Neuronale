import csv
import os
import random
from sklearn.model_selection import train_test_split

BASE = r"d:/facultate/an 3/rn/proiect/"

INPUT_FILE = BASE + "data/raw/Dataset_CNC.csv"
TRAIN_FILE = BASE + "data/train/train.csv"
VAL_FILE   = BASE + "data/validation/val.csv"
TEST_FILE  = BASE + "data/test/test.csv"
OUTPUT_DIR = BASE + "data/processed/"

os.makedirs(BASE + "data/train/", exist_ok=True)
os.makedirs(BASE + "data/validation/", exist_ok=True)
os.makedirs(BASE + "data/test/", exist_ok=True)
os.makedirs(BASE + "data/processed/", exist_ok=True)

def read_csv(file_path):
    with open(file_path, "r", newline="", encoding="utf-8") as f:
        reader = csv.DictReader(f)
        return list(reader)

def remove_duplicates(data):
    unique = []
    seen = set()
    for row in data:
        row_tuple = tuple(row.items())
        if row_tuple not in seen:
            seen.add(row_tuple)
            unique.append(row)
    return unique

def median(values):
    values = sorted(values)
    n = len(values)
    if n % 2 == 1:
        return values[n // 2]
    else:
        return (values[n // 2 - 1] + values[n // 2]) / 2

def fill_missing(data, numeric_fields):
    medians = {}
    if not data:
        return data
    for field in numeric_fields:
        if field not in data[0]:
            continue
        nums = [float(row[field]) for row in data if row[field].strip() != ""]
        if len(nums) > 0:
            medians[field] = median(nums)

    for row in data:
        for field in numeric_fields:
            if field not in row:
                continue
            if row[field].strip() == "":
                row[field] = str(medians.get(field, 0))
    return data

def write_csv(path, data, header):
    with open(path, "w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=header)
        writer.writeheader()
        writer.writerows(data)

def main():
    print("Citire dataset...")
    data = read_csv(INPUT_FILE)

    print("Eliminare duplicate...")
    data = remove_duplicates(data)

    numeric_fields = [
        "Turatie_RPM",
        "Avans_mm_min",
        "Adancime_Aschiere_mm",
        "Debit_Lichid_racire_L_min",
        "Temperatura_C",
        "Vibratii_mm_s",
        "Uzura_procent",
        "Zgomot_dB"
    ]

    categorical_fields = [
        "Tip_Scula",
        "Model_Scula",
        "Material_Prelucrat",
        "Tip_Operatie",
        "Tip_Defect"
    ]

    print("Completare valori lipsa...")
    data = fill_missing(data, numeric_fields)

    if "Scula_Defecta" in data[0]:
        stratify_field = [row["Scula_Defecta"] for row in data]
    else:
        stratify_field = [row["Tip_Defect"] for row in data]

    random_seed = 42

    train_val, test = train_test_split(
        data,
        test_size=0.15,
        random_state=random_seed,
        stratify=stratify_field
    )

    train, val = train_test_split(
        train_val,
        test_size=0.1765,  
        random_state=random_seed,
        stratify=[row["Scula_Defecta"] for row in train_val]  
    )

    header = list(train[0].keys())

    print("Salvare fisiere...")
    write_csv(TRAIN_FILE, train, header)
    write_csv(VAL_FILE, val, header)
    write_csv(TEST_FILE, test, header)

    PROCESSED_FILE = OUTPUT_DIR + "Dataset_CNC_processed.csv"
    write_csv(PROCESSED_FILE, data, header)

    print("Preprocesare finalizata cu succes!")

if __name__ == "__main__":
    main()
