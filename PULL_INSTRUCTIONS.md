# Guide complet pour Pull du projet Kalmi-Gestion

## 📋 Étapes pour récupérer le projet depuis GitHub

### 🚀 Méthode 1: Clone complet (première installation)

#### 1. Prérequis
- **Git** installé sur votre système
- **PHP 8.2+** installé
- **Composer** installé
- **MySQL/MariaDB** ou base de données compatible
- **Node.js et npm** (pour les assets)

#### 2. Cloner le dépôt
```bash
# Naviguer vers votre répertoire de projets
cd /votre/repertoire/de/projects

# Cloner le dépôt
git clone https://github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion.git

# Entrer dans le répertoire du projet
cd Kalmi-Gestion
```

#### 3. Installation des dépendances
```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Compiler les assets
npm run build
```

#### 4. Configuration de l'environnement
```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Éditer le fichier .env avec vos configurations
nano .env
```

**Variables à configurer dans .env :**
```env
APP_NAME="Kalmi Gestion"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kalmi_gestion
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

#### 5. Base de données
```bash
# Créer la base de données (manuellement ou via phpMyAdmin)
# Nom: kalmi_gestion

# Exécuter les migrations
php artisan migrate

# Exécuter les seeders (données de test)
php artisan db:seed
```

#### 6. Démarrer l'application
```bash
# Démarrer le serveur de développement
php artisan serve

# L'application sera accessible sur http://localhost:8000
```

---

### 🔄 Méthode 2: Pull (mise à jour d'une installation existante)

#### 1. Naviguer vers le projet
```bash
cd /chemin/vers/votre/Kalmi-Gestion
```

#### 2. Vérifier l'état actuel
```bash
# Vérifier s'il y a des modifications locales
git status

# Si vous avez des modifications non commitées, faites un backup ou commit
git add .
git commit -m "Backup local avant pull"
```

#### 3. Récupérer les dernières modifications
```bash
# Récupérer les informations du dépôt distant
git fetch origin

# Mettre à jour la branche main
git pull origin main

# Ou simplement
git pull
```

#### 4. Mettre à jour les dépendances
```bash
# Mettre à jour les dépendances PHP
composer update

# Mettre à jour les dépendances JavaScript
npm update

# Recompiler les assets
npm run build
```

#### 5. Base de données (si nécessaire)
```bash
# Si de nouvelles migrations ont été ajoutées
php artisan migrate

# Si de nouveaux seeders ont été ajoutés
php artisan db:seed --class=DatabaseSeeder
```

#### 6. Nettoyer et optimiser
```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### 🔧 Commandes utiles

#### Vérification du statut
```bash
# Vérifier le statut Git
git status

# Vérifier les branches
git branch -a

# Voir l'historique des commits
git log --oneline --graph
```

#### Résolution de conflits
```bash
# En cas de conflit lors du pull
git pull origin main

# Résoudre les conflits manuellement dans les fichiers
# puis marquer comme résolu
git add .
git commit -m "Résolution des conflits de fusion"
```

#### Retour en arrière (si nécessaire)
```bash
# Voir les commits précédents
git log --oneline

# Revenir au commit précédent
git reset --hard HEAD~1

# Ou revenir à un commit spécifique
git reset --hard <commit_hash>
```

---

### 🌐 Accès à l'application

#### Comptes par défaut (après seeders)
- **Admin** : `email@admin.com` / `password`
- **Vendeur** : `vendeur@vendeur.com` / `password`

#### URL principales
- **Tableau de bord** : `http://localhost:8000/dashboard`
- **Dépenses** : `http://localhost:8000/expenses`
- **Commandes** : `http://localhost:8000/orders`
- **Produits** : `http://localhost:8000/products`

---

### 🚨 Dépannage courant

#### Erreur de base de données
```bash
# Vérifier la connexion
php artisan tinker
> DB::connection()->getPdo();

# Recréer la base de données
php artisan migrate:fresh
php artisan db:seed
```

#### Erreur de dépendances
```bash
# Réinstaller Composer
composer install --no-scripts
composer install

# Réinstaller npm
rm -rf node_modules package-lock.json
npm install
npm run build
```

#### Erreur de permissions
```bash
# Donner les permissions correctes (Linux/Mac)
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

---

### 📱 Déploiement en production

Pour un déploiement en production, utilisez le script inclus :
```bash
# Exécuter le script de déploiement
./deploy.sh

# Ou utiliser le script serveur
./deploy-server.sh
```

---

### 🔗 Liens utiles

- **Dépôt GitHub** : https://github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion
- **Documentation Laravel** : https://laravel.com/docs
- **Documentation Tailwind CSS** : https://tailwindcss.com/docs

---

### ✅ Checklist post-pull

- [ ] Le projet est cloné/pull avec succès
- [ ] Les dépendances sont installées
- [ ] Le fichier .env est configuré
- [ ] La base de données est créée et migrée
- [ ] Les assets sont compilés
- [ ] Le serveur démarre sans erreur
- [ ] L'application est accessible dans le navigateur
- [ ] Les comptes par défaut fonctionnent

---

**🎉 Votre projet Kalmi-Gestion est maintenant prêt à être utilisé !**
