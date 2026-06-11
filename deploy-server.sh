#!/bin/bash

echo "🚀 Script de déploiement SERVEUR pour Kalmi Gestion"
echo "=================================================="

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

# Demander confirmation
echo "⚠️  Ce script va préparer le projet pour le déploiement sur serveur:"
echo "   - Créer une archive du projet"
echo "   - Exclure les fichiers inutiles"
echo "   - Préparer la configuration serveur"
echo ""
read -p "Êtes-vous sûr de vouloir continuer? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Préparation annulée"
    exit 1
fi

echo ""
echo "📋 Étape 1: Nettoyage du cache local..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "📋 Étape 2: Installation des dépendances production..."
composer install --optimize-autoloader --no-dev --no-interaction

echo ""
echo "📋 Étape 3: Build des assets..."
npm ci --production
npm run build

echo ""
echo "📋 Étape 4: Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "📋 Étape 5: Création de l'archive de déploiement..."
ARCHIVE_NAME="kalmi-gestion-$(date +%Y%m%d_%H%M%S).tar.gz"

# Créer l'archive en excluant les fichiers inutiles
tar --exclude='.git' \
    --exclude='node_modules' \
    --exclude='.env' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='storage/app/public/*' \
    --exclude='bootstrap/cache/*' \
    --exclude='tests' \
    --exclude='phpunit.xml' \
    --exclude='.gitignore' \
    --exclude='DEPLOYMENT.md' \
    --exclude='deploy.sh' \
    --exclude='deploy-server.sh' \
    -czf "../$ARCHIVE_NAME" .

echo "✅ Archive créée: ../$ARCHIVE_NAME"

echo ""
echo "📋 Étape 6: Création du fichier d'instructions..."
cat > "../DEPLOY_SERVER_INSTRUCTIONS.md" << 'EOF'
# Instructions de déploiement serveur - Kalmi Gestion

## 📦 Fichiers reçus
- Archive: kalmi-gestion-[DATE].tar.gz
- Ce fichier d'instructions

## 🚀 Étapes de déploiement

### 1. Extraction des fichiers
```bash
# Sur le serveur
tar -xzf kalmi-gestion-[DATE].tar.gz
cd kalmi-gestion
```

### 2. Configuration de l'environnement
```bash
# Copier le fichier d'environnement
cp .env.production .env

# Éditer le fichier .env avec vos configurations:
nano .env
```

**Variables à configurer dans .env:**
- `APP_URL`: URL de votre domaine (ex: https://votre-site.com)
- `DB_HOST`: Host de votre base de données
- `DB_DATABASE`: Nom de la base de données
- `DB_USERNAME`: Utilisateur de la base de données
- `DB_PASSWORD`: Mot de passe de la base de données

### 3. Permissions des fichiers
```bash
# Donner les permissions appropriées
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 4. Installation des dépendances
```bash
# Installer Composer si non disponible
curl -sS https://getcomposer.org/installer | php
php composer.phar install --optimize-autoloader --no-dev

# Ou si Composer est déjà installé:
composer install --optimize-autoloader --no-dev
```

### 5. Configuration de la base de données
```bash
# Générer la clé d'application
php artisan key:generate

# Exécuter les migrations
php artisan migrate --force

# Exécuter les seeders
php artisan db:seed --force
```

### 6. Configuration du serveur web

#### Apache (.htaccess déjà inclus)
Le fichier `.htaccess` est déjà configuré dans le répertoire `public/`.

#### Nginx
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
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 7. Test de l'application
```bash
# Vérifier que l'application fonctionne
php artisan about
```

## 🔐 Comptes par défaut
Après l'exécution des seeders:
- **Admin**: email@admin.com / password
- **Vendeur**: vendeur@vendeur.com / password

## 📞 Support
En cas de problème, vérifiez:
1. Les logs: `storage/logs/laravel.log`
2. Les permissions des fichiers
3. La configuration de la base de données dans `.env`

## 🎉 Déploiement terminé!
Votre application Kalmi Gestion est maintenant en production!
EOF

echo "✅ Fichier d'instructions créé: ../DEPLOY_SERVER_INSTRUCTIONS.md"

echo ""
echo "✅ Préparation terminée avec succès!"
echo ""
echo "📦 Fichiers créés:"
echo "   - Archive: $ARCHIVE_NAME"
echo "   - Instructions: DEPLOY_SERVER_INSTRUCTIONS.md"
echo ""
echo "🚀 Transférez ces fichiers sur votre serveur et suivez les instructions!"
