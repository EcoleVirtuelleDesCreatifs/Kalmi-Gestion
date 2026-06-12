#!/bin/bash

echo "🧹 Vidage complet des caches Laravel"
echo "=================================="

# Vérifier si nous sommes dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

echo ""
echo "📋 Étape 1: Vidage du cache de l'application..."
php artisan cache:clear

echo ""
echo "📋 Étape 2: Vidage du cache de configuration..."
php artisan config:clear

echo ""
echo "📋 Étape 3: Vidage du cache des routes..."
php artisan route:clear

echo ""
echo "📋 Étape 4: Vidage du cache des vues..."
php artisan view:clear

echo ""
echo "📋 Étape 5: Vidage du cache de compilation..."
php artisan clear-compiled

echo ""
echo "📋 Étape 6: Optimisation de l'application..."
php artisan optimize

echo ""
echo "✅ Tous les caches ont été vidés avec succès!"
echo ""
echo "🔍 Caches vidés:"
echo "   - Cache de l'application"
echo "   - Cache de configuration"
echo "   - Cache des routes"
echo "   - Cache des vues"
echo "   - Cache de compilation"
echo "   - Autoload optimisé"
echo ""
echo "🚀 L'application est maintenant optimisée et prête!"
