import csv
import os
from sklearn.model_selection import train_test_split

BASE = "d:/facultate/an 3/rn/proiect/"
INPUT = BASE + "data/raw/Dataset_CNC.csv"

TRAIN = BASE + "data/train/train.csv"
VAL   = BASE + "data/validation/val.csv"
TEST  = BASE + "data/test/test.csv"

os.makedirs(os.path.dirname(TRAIN), exist_ok=True)
os.makedirs(os.path.dirname(VAL), exist_ok=True)
os.makedirs(os.path.dirname(TEST), exist_ok=True)

def read_csv(path):
    with open(path, encoding="utf-8") as f:
        return list(csv.DictReader(f))

def write_csv(path, data):
    with open(path, "w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=data[0].keys())
        writer.writeheader()
        writer.writerows(data)

data = read_csv(INPUT)
labels = [row["Tip_Defect"] for row in data]

train_val, test = train_test_split(
    data, test_size=0.15, random_state=42, stratify=labels
)

train, val = train_test_split(
    train_val,
    test_size=0.1765,
    random_state=42,
    stratify=[r["Tip_Defect"] for r in train_val]
)

write_csv(TRAIN, train)
write_csv(VAL, val)
write_csv(TEST, test)

print("Preprocesare terminata")
