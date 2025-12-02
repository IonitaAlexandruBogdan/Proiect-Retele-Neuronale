# Parametri nominali (valori tipice din fabrica)
turatie_nominala = 5000      # RPM
avans_nominal = 600          # mm/min
adancime_nominala = 2.0      # mm
uzura_max = 100              # %

def estimeaza_viata(turatie, avans, adancime, uzura):
    # Factor de suprasolicitare
    factor = (turatie / turatie_nominala + avans / avans_nominal + adancime / adancime_nominala) / 3

    # Ajustare uzura
    uzura_ajustata = uzura * factor
    timp_ramas = max(0, uzura_max - uzura_ajustata)  # % viata ramasa

    return round(factor, 2), round(timp_ramas, 2)

# -------------------------
# Interactiune cu utilizatorul
# -------------------------
print("Estimare durata de viata scula CNC")
print("---------------------------------")

turatie = float(input("Introdu turatia curenta (RPM): "))
avans = float(input("Introdu avansul curent (mm/min): "))
adancime = float(input("Introdu adancimea de aschiere curenta (mm): "))
uzura = float(input("Introdu uzura sculei actuala (%): "))

factor, timp_ramas = estimeaza_viata(turatie, avans, adancime, uzura)

print("\nRezultat estimare:")
print(f"Factor suprasolicitare: {factor}")
print(f"Timp ramas de viata al sculei: {timp_ramas}%")
