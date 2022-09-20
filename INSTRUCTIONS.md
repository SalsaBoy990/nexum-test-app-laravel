# Nexum Dokumentumkezelő app v1.0.0

GitHub repo: https://github.com/SalsaBoy990/nexum-test-app-laravel

**A master ágat használd!**

zip fájl: https://github.com/SalsaBoy990/nexum-test-app-laravel/archive/refs/heads/master.zip


## A projekt belövése

Követelmények: PHP 8, Composer 2, Node.js

Az általam használt verziók: PHP 8.0.21, Composer 2.4.1, Node.js v16.14.0

1. Composer csomagok telepítése

```bash
composer update
```

2. MySQL adatbázis létrehozása és az **`.env`** fájlban a `DB_DATABASE`, a `DB_USERNAME` és a `DB_PASSWORD` változók megadása


3. Szimbolikus link létrehozása a storage és a public mappa között:*

```bash
php artisan storage:link
```

A `TEMP/uploads` mappát bele kell másolni a `storage/app/public/` mappába.

Elképzelhető, hogy ha nem működik, akkor közvetlenül a `public/storage` mappába kell másolni ezt a mappát.
Ezek a fájlok kellenek a teszteléshez.


4. A migrációk és a seeder-ek lefuttatása


A `database/seeders/DatabaseSeeder.php` fájlban meg kell adni a létrehozandó felhasználó adatait (name, email, password). Vagy meg is lehet hagyni az alapértelmezett értékeket.

```bash
php artisan migrate:fresh --seed
```



A `storage/app/public/` mappába szükséges létrehozni egy `theme` mappát, és ide bele kell másolni a `focus-trap.js` és az `init-alpine.js` fájlokat. Ezek most a `/TEMP` mappában vannak!

Elképzelhető, hogy ha nem működik, akkor közvetlenül a `public/storage` mappába kell másolni ezeket a fájlokat.


4. Devszerver indítása:

```bash
php artisan serve
```

5. Bundle-ök generálása (Vite):

```bash
npm run build
```

A watch mód:

```bash
npm run dev
```

Az admin oldal elérése: http://localhost:8000/admin/dashboard

(De természetesen a bejelentkezés után átirányít ide a rendszer.)

### * Osztott tárhelyre történő deploy esetén az artisan nem használható

A szimbolikus link létrehozása osztott tárhelynél. A `routes/web.php`-ba:

```php
   Route::get('/symlink', function () {
        //Artisan::call('storage:link');

        // https://dumpcoder.com/symlink-laravel-storage-folder-on-shared-hosting/

        // In the example, the webroot is in the public folder
        // However, it is best to put the laravel framework into a separate folder (outside of the webroot)
        // so change the path if needed!
        $documentRoot = str_replace('public/', '', $_SERVER['DOCUMENT_ROOT']);
        $target = $documentRoot . 'storage/app/public';
        $link = $documentRoot . 'public/storage';

        symlink($target, $link);
        echo "Done";
    });
```


## A projektről

A [Laravel Jetstream](https://laravel.com/docs/9.x/starter-kits#laravel-jetstream) starter-t használtam fel. A felhasználókezelés a Jetstream általi alapértelmezett megvalósítás. Bármelyik másikat választhattam volna, pl. [Laravel Breeze](https://laravel.com/docs/9.x/starter-kits#laravel-breeze).

Az admin oldal frontendjéhez egy a korábbi projektjeimbe integrált egyszerű  HTML template-et használtam (Windmill).

Használt CSS framework: Tailwind. Kliens oldali JS könyvtár: Alpine.js 2.


## A megvalósított feladatok:

A verziókezelést leszámítva megvalósítottam az alkalmazást.


1. Dokumentumfeltöltés kialakítása

2. Hierarchikus kategóriák DB-ben történő kialakítása (plusz a teljes frontend).

3. User kezelés = Jetstream általi alapértelmezett

4. Opcionális a verzió kezelés. -> Erre nem maradt időm.

5. Az adatbázis MySQL.

## A megoldásra fordított idő

Ezeket írtam e-mailben:

"A becsült idő a legoptimálisabb esetben 18 óra, a pesszimista becslés (+8 óra biztonsági tényezővel): 26 óra.

- dokumentumok kezelése: 2 óra
- hierarchikus kategóriák kezelése: 4 óra
- jogosultságkezelés: 4 óra
- frontend: 4 óra
- tesztelés: 4 óra
"

A végeredmény végül **24 óra** lett.

[Screenshot az időmérésemről](https://drive.google.com/file/d/1TAVZoK-SNGw3Ay68VyVCaZOAOaYT4X-j/view?usp=sharing)


## Additional NOTES!

Bármelyik kategóriához történő feltöltéshez először engedélyezni kell a hozzáférést a gyökér kategóriához.
A nyitogatható kategória lista alatt, a "+ Új kategória" gomb felett lehet engedélyezni a feltöltést / új kategória felvitelét. A kategóriáknál pedig egyenként kell állítani a jogosultságokat.