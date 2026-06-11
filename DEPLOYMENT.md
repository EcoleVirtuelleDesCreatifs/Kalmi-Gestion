# Guide de Déploiement - Kalmi Gestion

## 📋 Prérequis

- PHP 8.1+ 
- MySQL/MariaDB
- Composer
- Node.js & NPM
- Serveur web (Apache/Nginx)

## 🗑️ Vidage de la Base de Données

### Option 1: Commande Artisan (Recommandée)
```bash
php artisan db:clear
```

### Option 2: Seeder
```bash
php artisan db:seed --class=DatabaseCleaner
```

### Option 3: Manuellement
```sql
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE delivery_items;
TRUNCATE TABLE order_items;
TRUNCATE TABLE deliveries;
TRUNCATE TABLE orders;
TRUNCATE TABLE products;
TRUNCATE TABLE categories;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS=1;
```

## 🚀 Déploiement Automatisé

### 1. Utiliser le script de déploiement
```bash
chmod +x deploy.sh
./deploy.sh
```

### 2. Configuration manuelle

#### Étape 1: Configuration de l'environnement
```bash
cp .env.production .env
php artisan key:generate
```

#### Étape 2: Installation des dépendances
```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

#### Étape 3: Base de données
```bash
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
```

#### Étape 4: Optimisation
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔧 Configuration Serveur Web

### Apache (.htaccess déjà inclus)
Le fichier `.htaccess` est déjà configuré dans le dossier `/public`

### Nginx
```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/kalmi-gestion/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 📁 Permissions des Fichiers

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🌐 Variables d'Environnement

Éditez `.env` pour configurer:

- `APP_URL`: URL de votre site en production
- `DB_*`: Configuration de la base de données
- `MAIL_*`: Configuration email (optionnel)

## ✅ Vérification Post-Déploiement

1. **Testez l'accès** à l'application
2. **Vérifiez** que toutes les pages fonctionnent
3. **Testez** la création de comptes
4. **Vérifiez** l'upload de fichiers si applicable
5. **Testez** le responsive design

## 🔄 Mises à Jour Futures

Pour les mises à jour:
```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🚨 Sauvegarde

N'oubliez pas de configurer des sauvegardes automatiques:
- Base de données quotidienne
- Fichiers de stockage réguliers

## 📞 Support

En cas de problème:
1. Vérifiez les logs: `storage/logs/laravel.log`
2. Vérifiez les permissions
3. Testez la connexion à la base de données
4. Vérifiez la configuration du serveur web
