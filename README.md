## O Zadaní

Zadanie bolo vypracované v najnovšej verzí Laravelu v9.25.1 (PHP v8.1.5, Composer v2.3.9)

### Návod na rozbehnutie aplikácie

Celý repozitár treba vložiť do documentRootu webservera (alebo nasmerovať na priečinok)

V súbore ```.env ``` treba zmenit databázovú konekciu v sekcií ``` DB_*```

Pred spustením web aplikácie treba v konzole spustiť nasledovné príkazy aby sa framework inicializoval pre nové prostredie

Aktualizovať knižnice
```bash
composer update
```
Spustiť migráciu pre databázu (vytvorí v zvolenej databáze tabuľku ```orderbook```)
```bash
php artisan migrate
```
Premazať cache a skompilované súbory
```bash
php artisan optimize:clear
```
Spustiť periodický Job pomocou Schedule (bude napĺnať databázu každých 10 sekúnd)
```bash
php artisan short-schedule:run
```

Následne môžeme aplikáciu spustiť vo webovom prehliadači.

### Back-endová časť
Aplikácia je napojená na API službu cez ```api.kraken.com```.
Skript stiahne dáta z API, preformátuje a uloží do pripravenej databázovej tabulky.
Pri vytváraní periodického Jobu bol použitý Laravel Task Schedule, aby aplikácia nebola závislá na externom Crone.
Pomocou short-schedule knižnice sa táto činnosť vykonáva v 10 sekundovom intervale.
Dĺžku intervalu je možné upravovať v ```.env ```setting ```API_TIMEOUT```.

### Front-endová časť
Graf je vytvorený pomocou Google Line Chart. 
Čerstvé dáta sú dotahované do grafu cez AJAX. 
Po natiahnutí dát zo servera sa graf prekreslí. Aktualizácia je vykonávaná každých 10 sekúnd.

### Možné vylepšenia kódu
Ošetriť hraničné a hazardné situácie. 
Ošetrit timeouty na frontende a vylepšiť doťahovanie dát bez prekresľovania grafu.
Zapnúť automatické spúšťanie short-schedule Jobu na BE.

