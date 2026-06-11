#!/bin/bash

echo "🚀 Script de mise à jour SERVEUR pour Kalmi Gestion"
echo "=================================================="

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

# Demander confirmation
echo "⚠️  Ce script va:"
echo "   - Récupérer les dernières modifications depuis GitHub"
echo "   - Mettre à jour les dépendances"
echo "   - Exécuter les migrations de base de données"
echo "   - Optimiser l'application"
echo ""
read -p "Êtes-vous sûr de vouloir continuer? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Mise à jour annulée"
    exit 1
fi

echo ""
echo "📋 Étape 1: Sauvegarde de l'état actuel..."
# Créer un backup des fichiers importants
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

if [ -f ".env" ]; then
    cp .env "$BACKUP_DIR/.env.backup"
    echo "✅ Fichier .env sauvegardé"
fi

if [ -d "storage/app/public" ]; then
    cp -r storage/app/public "$BACKUP_DIR/"
    echo "✅ Fichiers publics sauvegardés"
fi

echo ""
echo "📋 Étape 2: Récupération des modifications depuis GitHub..."
git fetch origin

# Vérifier s'il y a des modifications
LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/main)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "✅ Déjà à jour avec la dernière version"
    echo ""
    echo "📋 Étape 3: Nettoyage et optimisation..."
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan optimize
    echo "✅ Optimisation terminée"
    echo ""
    echo "🎉 Mise à jour terminée (aucune modification requise)"
    exit 0
fi

echo "📥 Nouvelles modifications détectées, mise à jour en cours..."
git pull origin main

echo ""
echo "📋 Étape 3: Mise à jour des dépendances..."
composer install --optimize-autoloader --no-interaction

echo ""
echo "📋 Étape 4: Mise à jour des assets..."
npm ci --production
npm run build

echo ""
echo "📋 Étape 5: Mise à jour de la base de données..."
php artisan migrate --force

echo ""
echo "📋 Étape 6: Nettoyage et optimisation..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "📋 Étape 7: Vérification de l'application..."
php artisan about --only=environment,cache,database

echo ""
echo "✅ Mise à jour terminée avec succès!"
echo ""
echo "🔍 Vérifications post-mise à jour:"
echo "   - Application: http://votre-domaine.com"
echo "   - Logs: storage/logs/laravel.log"
echo "   - Backup: $BACKUP_DIR/"
echo ""
echo "🎉 Votre application Kalmi Gestion est maintenant à jour!"
