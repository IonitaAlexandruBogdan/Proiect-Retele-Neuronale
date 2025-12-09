import csv
import os
import random

# -------------------------
# PATH-uri absolute
# -------------------------
BASE = r"d:/facultate/an 3/rn/proiect/"

INPUT_FILE = BASE + "data/raw/Dataset_CNC.csv"
TRAIN_FILE = BASE + "data/train/train.csv"
VAL_FILE   = BASE + "data/validation/val.csv"
TEST_FILE  = BASE + "data/test/test.csv"
OUTPUT_DIR = BASE + "data/processed/"

# creăm folderele
os.makedirs(BASE + "data/train/", exist_ok=True)
os.makedirs(BASE + "data/validation/", exist_ok=True)
os.makedirs(BASE + "data/test/", exist_ok=True)
os.makedirs(BASE + "data/processed/", exist_ok=True)


# -------------------------
# 1. Citire CSV
# -------------------------
def read_csv(file_path):
    with open(file_path, "r", newline="", encoding="utf-8") as f:
        reader = csv.DictReader(f)
        return list(reader)


# -------------------------
# 2. Eliminare duplicate
# -------------------------
def remove_duplicates(data):
    unique = []
    seen = set()
    for row in data:
        row_tuple = tuple(row.items())
        if row_tuple not in seen:
            seen.add(row_tuple)
            unique.append(row)
    return unique


# -------------------------
# 3. Tratare valori lipsa (mediana)
# -------------------------
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
                # păstrăm tip numeric ca string pentru CSV
                row[field] = str(medians.get(field, 0))
    return data


# -------------------------
# 4. (Removed) Normalizare min-max
# -------------------------
# Normalizarea se va face în train_model.py cu MinMaxScaler (ca să păstrăm
# același scaler pentru predicții). Nu normalizăm aici pentru a evita dublarea.


# -------------------------
# 5. Encoding pentru variabile categoriale (doar pentru inspectare)
# -------------------------
def categorical_to_int_for_inspect(data, fields):
    mappings = {}
    if not data:
        return data, mappings
    for field in fields:
        if field not in data[0]:
            continue
        unique_vals = sorted(list({row[field] for row in data}))
        mapping = {val: i for i, val in enumerate(unique_vals)}
        mappings[field] = mapping
    return data, mappings


# -------------------------
# 6. Impartire in train/val/test
# -------------------------
def split_data(data, train_ratio=0.75, val_ratio=0.15):
    random.shuffle(data)
    n = len(data)
    n_train = int(n * train_ratio)
    n_val = int(n * val_ratio)
    train = data[:n_train]
    val = data[n_train:n_train + n_val]
    test = data[n_train + n_val:]
    return train, val, test


# -------------------------
# 7. Salvare CSV
# -------------------------
def write_csv(path, data, header):
    with open(path, "w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=header)
        writer.writeheader()
        writer.writerows(data)


# -------------------------
# PIPELINE
# -------------------------
def main():
    print("Citire dataset...")
    data = read_csv(INPUT_FILE)

    print("Eliminare duplicate...")
    data = remove_duplicates(data)

    # campuri numerice exact din CSV-ul generat
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

    # campuri categorice exact din CSV-ul generat, tipurile sculelor fixe
    categorical_fields = [
        "Tip_Scula",           # Freza, Burghiu, Tarod, Placuta amovibila
        "Model_Scula",
        "Material_Prelucrat",
        "Tip_Operatie",
        "Tip_Defect"
    ]

    print("Completare valori lipsa...")
    data = fill_missing(data, numeric_fields)

    # doar inspectăm mapping-urile (dacă vrei să le salvezi separat)
    print("Colectare valori categorice (inspect)...")
    _, mappings = categorical_to_int_for_inspect(data, categorical_fields)
    # optional: salva mappings în OUTPUT_DIR pentru referință
    try:
        import json
        with open(os.path.join(OUTPUT_DIR, "categorical_mappings.json"), "w", encoding="utf-8") as jf:
            json.dump(mappings, jf, ensure_ascii=False, indent=2)
    except Exception:
        pass

    print("Impartire seturi...")
    train, val, test = split_data(data)

    header = list(train[0].keys())

    print("Salvare fisiere...")
    write_csv(TRAIN_FILE, train, header)
    write_csv(VAL_FILE, val, header)
    write_csv(TEST_FILE, test, header)

    # salvare fisier complet preprocesat (fără normalizare)
    PROCESSED_FILE = OUTPUT_DIR + "Dataset_CNC_processed.csv"
    write_csv(PROCESSED_FILE, data, header)

    print("Preprocesare finalizata cu succes!")


if __name__ == "__main__":
    main()
