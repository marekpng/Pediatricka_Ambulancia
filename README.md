#  Rezervačný systém pediatrickej ambulancie
Komplexná webová aplikácia, ktorá slúži ako rezervačný systém a zároveň ako prezentačná platforma pre pediatrickú ambulanciu. Systém je postavený na ***microservice*** architektúre a poskytuje plynulý používateľský zážitok pre pacientov aj zdravotnícky personál.

# Hlavné funkcie 
#### (  ⬇ nižšie je uvedený ***snippet*** spolu so ***screenmi*** z aplikácie  ⬇)
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

## Architektúra
### Aplikácia je postavená na mikroslužbovej architektúre, kde každá služba má svoju presnú zodpovednosť.

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




#### Spustenie Docker kontajnerov
* docker-compose up -d

#### Spustenie migrácií
* docker-compose exec content_service php artisan migrate (analogicky pre každý service rovnako)
  
#### Generovanie aplikačného kľúča
*  docker-compose exec reservation_service php artisan key:generate

#### Sprístupnenie storage
* docker-compose exec content_service php artisan storage:link

#### Prístup k aplikácii

* Frontend: http://localhost:5173
* Mailpit rozhranie: http://localhost:8025


# #Snippet aplikácie

## Pre pacientov
* #### Rezervácia termínu k lekárovi – Pacient musí vyplniť formulár, kde sa overuje jeho rodné číslo a meno podľa databázy.
![prvy](https://github.com/user-attachments/assets/3006bb75-ab98-422f-85e5-49a9a4e481e2)

  
* #### Emailová verifikácia – Po úspešnom overení dostane pacient email s potvrdením.
![druhz](https://github.com/user-attachments/assets/e053abe0-335e-4b1f-b2a8-31c835ce80ae)

  
* #### Prístup k informáciám – Možnosť prezerania článkov publikovaných lekárom, zoznamu služieb ambulancie, pracovného personálu a ďalších informácií.
![treti](https://github.com/user-attachments/assets/40668e42-a3e4-4bf6-bbbd-37aa6e6c2d95)

  
![stvrty](https://github.com/user-attachments/assets/10e3d5bb-a9fe-44b1-9b9b-faff22a55106)



## Pre lekárov (Admin rozhranie)
* #### Správa obsahu webu – Možnosť dynamicky upravovať sekcie stránky (napr. blogy, recenzie, služby,...).
![ťpiaty](https://github.com/user-attachments/assets/762376fa-c128-4af9-b753-0ca5abcca918)

  
* #### Správa pacientov – Pridávanie, úprava, mazanie a vyhľadávanie pacientov.
![siesty](https://github.com/user-attachments/assets/363cc10d-4e52-4b55-9bcc-1d88020f9173)

  
* #### Správa rezervácií – Možnosť pridávať, upravovať a mazať termíny vyšetrení.
![siedmy](https://github.com/user-attachments/assets/4c0a1ae7-ce04-4d7a-a176-4a2f62128c4b)

  
* #### Publikovanie článkov – Použitie WYSIWYG editora na vytváranie a úpravu blogov.
![osmi](https://github.com/user-attachments/assets/ab4591b3-4835-41f8-b847-efcd4f0c9103)

* #### Harmonogram ordinácie – Možnosť upravovať, pridávať, mazať časové sloty na vyšetrenia pre pacientov.

![devet](https://github.com/user-attachments/assets/02b7b39b-dbaa-4b06-9739-20f059e65674)


#### Toto bola iba časť aplikácie, pre plnohodnotný zážitok prosím spustite aplikáciu pomocou návodu vyššie ⬆


