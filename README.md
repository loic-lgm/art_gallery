# Art Gallery

### DESCRIPTION
Gallerie d'oeuvre d'art
TODO

### REQUIREMENTS
- TODO

### SETUP
1. cloner le repo
2. configuration DB
    - créer un fichier `.env.local` à la racine
    - copier `DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8&charset=utf8mb4"` dans `.env.local`
    - remplacer ses credentials DB
3. faire les migrations
    - TODO
3. installer les dépendances
    - se déplacer dans /mon-projet 
    - `composer install`
    - `yarn instal`
4. lancer le server 
    - BACK : `php -S localhost:8000 -t public` || `symfony server:serve`
    - FRONT : `yarn watch`
