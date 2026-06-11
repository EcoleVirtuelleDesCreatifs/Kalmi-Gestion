#!/bin/bash

echo "🚀 Script de déploiement pour Kalmi Gestion"
echo "=========================================="

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

# Demander confirmation
echo "⚠️  Ce script va:"
echo "   - Vider la base de données"
echo "   - Mettre l'application en mode production"
echo "   - Optimiser les performances"
echo ""
read -p "Êtes-vous sûr de vouloir continuer? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Déploiement annulé"
    exit 1
fi

echo ""
echo "📋 Étape 1: Vidage de la base de données..."
php artisan db:clear

echo ""
echo "📋 Étape 2: Installation des dépendances..."
composer install --optimize-autoloader --no-dev

echo ""
echo "📋 Étape 3: Mise à jour des dépendances frontend..."
npm install && npm run build

echo ""
echo "📋 Étape 4: Configuration de l'environnement..."
if [ ! -f ".env" ]; then
    cp .env.production .env
    echo "✅ Fichier .env créé à partir de .env.production"
    echo "⚠️  N'oubliez pas de configurer vos clés et bases de données!"
fi

echo ""
echo "📋 Étape 5: Génération de la clé d'application..."
php artisan key:generate --force

echo ""
echo "📋 Étape 6: Migration de la base de données..."
php artisan migrate --force

echo ""
echo "📋 Étape 7: Seeders de base..."
php artisan db:seed --class=DatabaseSeeder --force

echo ""
echo "📋 Étape 8: Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "📋 Étape 9: Nettoyage du cache..."
php artisan cache:clear
php artisan config:clear

echo ""
echo "✅ Déploiement terminé avec succès!"
echo ""
echo "🔍 Prochaines étapes:"
echo "   1. Configurez votre serveur web (Apache/Nginx)"
echo "   2. Pointez le document root vers /public"
echo "   3. Configurez les permissions des fichiers"
echo "   4. Testez l'application"
echo ""
echo "🌐 Votre application est prête pour la production!"
