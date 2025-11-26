Proiect-Retele-Neuronale
2. Descrierea Setului de Date – Dataset 2: AI4I 2020 Predictive Maintenance Dataset

2.1 Sursa datelor

Origine:
AI4I 2020 Predictive Maintenance Dataset, publicat în UCI Machine Learning Repository.

Acesta este un set de date sintetic, generat pentru studii de mentenanță predictivă.

Modul de achiziție:

☐ Senzori reali

☑ Simulare (date generate sintetic)

☑ Fișier extern

☐ Generare programatică


Perioada / condițiile colectării:

Datele nu provin dintr-o perioadă reală; sunt generate pentru a imita funcționarea industrială.

Simulează degradarea fizică a motorului, încărcarea, temperaturile și uzura sculei.

2.2 Caracteristicile dataset-ului

Număr total de observații: 10.000 rânduri

Număr de caracteristici: 10 features + 2 etichete (binary și multiclass)

Tipuri de date:

☑ Numerice

☑ Categoriale

☐ Temporale

☐ Imagini

Format fișiere:
☑ CSV
☐ JSON
☐ TXT

2.3 Descrierea fiecărei caracteristici
| Caracteristică      | Tip         | Rol     | Unitate | Descriere                                  | Domeniu valori         |
| ------------------- | ----------- | ------- | ------- | ------------------------------------------ | ---------------------- |
| UID                 | ID          | ID      | Integer | Identificator unic                         | 1–10.000               |
| Product ID          | Categorical | ID      | –       | Nivelul de calitate al produsului + serial | L/M/H + număr de serie |
| air_temperature     | Numeric     | Feature | K       | Temperatura aerului din jurul utilajului   | 298–302                |
| process_temperature | Numeric     | Feature | K       | Temperatura procesului intern              | 308–312                |
| rotational_speed    | Numeric     | Feature | rpm     | Turația arborelui                          | 1300–2900              |
| torque              | Numeric     | Feature | Nm      | Cuplu aplicat                              | 3–76                   |
| tool_wear           | Numeric     | Feature | min     | Uzura sculei                               | 0–250                  |
| machine_failure     | Categorical | Label   | –       | Binary: 0/1                                | {0, 1}                 |
| TWF                 | Categorical | Label   | –       | Binary: 0/1                                | {0, 1}                 |
| HDF                 | Categorical | Label   | –       | Binary: 0/1                                | {0, 1}                 |
| PWF                 | Categorical | Label   | –       | Binary: 0/1                                | {0, 1}                 |
| OSF                 | Categorical | Label   | –       | Binary: 0/1                                | {0, 1}                 |
| RNF                 | Categorical | Label   | –       | Binary: 0/1                                | {0, 1}                 |


