#  Rezervačný systém pediatrickej ambulancie
Komplexná webová aplikácia, ktorá slúži ako rezervačný systém a zároveň ako prezentačná platforma pre pediatrickú ambulanciu. Systém je postavený na mikroslužbovej architektúre a poskytuje plynulý užívateľský zážitok pre pacientov aj zdravotnícky personál.

# Hlavné funkcie 
###### (  ⬇ nižšie sú uvedené jednotlivé funkcionality aj so screenami obrazovky  ⬇)
## Pre pacientov 
* #### Rezervácia termínu k lekárovi – Pacient musí vyplniť formulár, kde sa overuje jeho rodné číslo a meno podľa databázy.
* #### Emailová verifikácia – Po úspešnom overení dostane pacient email s potvrdením.
* #### Prístup k informáciám – Možnosť prezerania článkov publikovaných lekárom, zoznamu služieb ambulancie, pracovného personálu a ďalších informácií.

## Pre lekárov (Admin rozhranie)
* #### Správa obsahu webu – Možnosť dynamicky upravovať sekcie stránky (napr. blogy, recenzie, služby,...).
* #### Správa pacientov – Pridávanie, úprava, mazanie a vyhľadávanie pacientov.
* #### Správa rezervácií – Možnosť pridávať, upravovať a mazať termíny vyšetrení.
* #### Publikovanie článkov – Použitie WYSIWYG editora na vytváranie a úpravu blogov.
* #### Harmonogram ordinácie – Možnosť upravovať, pridávať, mazať časové sloty na vyšetrenia pre pacientov.




## Pre pacientov
* #### Rezervácia termínu k lekárovi – Pacient musí vyplniť formulár, kde sa overuje jeho rodné číslo a meno podľa databázy.
![image](https://github.com/user-attachments/assets/0ab252e1-ba6e-4132-af00-9fb85088bf59)

  
* #### Emailová verifikácia – Po úspešnom overení dostane pacient email s potvrdením.
![image](https://github.com/user-attachments/assets/2bf441c5-8c5f-464b-a8d0-c5a2368df8cf)

  
* #### Prístup k informáciám – Možnosť prezerania článkov publikovaných lekárom, zoznamu služieb ambulancie, pracovného personálu a ďalších informácií.
![image](https://github.com/user-attachments/assets/8495876e-b901-49fa-9d81-fb157fa06ebb)

  
![image](https://github.com/user-attachments/assets/dd561420-0e36-4ba3-8e88-d684f0c5eff9)



## Pre lekárov (Admin rozhranie)
* #### Správa obsahu webu – Možnosť dynamicky upravovať sekcie stránky (napr. blogy, recenzie, služby,...).
![image](https://github.com/user-attachments/assets/87275f31-cab5-4877-a032-e52cde62c922)

  
* #### Správa pacientov – Pridávanie, úprava, mazanie a vyhľadávanie pacientov.
![image](https://github.com/user-attachments/assets/aedb698f-1372-4eee-baf6-4a5b47fb0ef0)

  
* #### Správa rezervácií – Možnosť pridávať, upravovať a mazať termíny vyšetrení.
![image](https://github.com/user-attachments/assets/a5c697ea-69fc-437a-8bc8-1a40b94a9371)

  
* #### Publikovanie článkov – Použitie WYSIWYG editora na vytváranie a úpravu blogov.
  ![image](https://github.com/user-attachments/assets/412b49c2-8a6f-448a-a012-a0e8f5849e2d)

* #### Harmonogram ordinácie – Možnosť upravovať, pridávať, mazať časové sloty na vyšetrenia pre pacientov.

![image](https://github.com/user-attachments/assets/6bde4254-fb0c-4b1e-a5b0-f1d8ee19e860)


### Aplikácia je postavená na mikroslužbovej architektúre, pričom každá služba má svoju presnú zodpovednosť.

### Použité technológie:

* Frontend: Vue.js 

* Backend: Laravel 

* Databáza: MySQL

* Server: Nginx 

* Emailový server: Mailpit 

* Docker: Kontajnerizácia aplikácie

### Mikroslužby:

* Identify Service – Autorizácia a autentifikácia.

* Reservation Service – Správa rezervácií a lekárskeho harmonogramu.

* Content Service – Správa obsahu webovej stránky (články, recenzie, služby).

* Email Service – Odosielanie emailových notifikácií.

### Spustenie projektu

#### Klonovanie repozitára

* git clone [https://github.com/marekpng/pediatricka_ambulancia.git](https://github.com/marekpng/Pediatricka_Ambulancia.git)
* cd pediatricka_ambulancia

#### vytvorenie .env súboru
* cp .env.example .env

#### Generovanie aplikačného kľúča
* php artisan key:generate


#### Spustenie Docker kontajnerov
* docker-compose up -d

#### Spustenie migrácií
* php artisan migrate

#### Prístup k aplikácii

* Frontend: http://localhost:5173
* Mailpit rozhranie: http://localhost:8025
