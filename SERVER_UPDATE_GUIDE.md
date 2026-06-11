# Guide de mise à jour serveur - Kalmi Gestion

## 🚀 Mise à jour du serveur avec Pull depuis GitHub

### 📋 Prérequis

- **Accès SSH** au serveur
- **Git** installé sur le serveur
- **PHP 8.2+** avec Composer
- **Node.js** avec npm
- **Permissions** suffisantes pour exécuter les commandes

---

## 🔧 Méthode 1: Script automatisé (recommandé)

### 1. Transférer le script sur le serveur
```bash
# Depuis votre machine locale
scp update-server.sh utilisateur@votre-serveur:/chemin/vers/Kalmi-Gestion/

# Ou via FTP/SFTP
# Téléverser update-server.sh dans le répertoire du projet
```

### 2. Exécuter le script sur le serveur
```bash
# Se connecter au serveur
ssh utilisateur@votre-serveur

# Naviguer vers le projet
cd /chemin/vers/Kalmi-Gestion

# Rendre le script exécutable
chmod +x update-server.sh

# Exécuter la mise à jour
./update-server.sh
```

### 3. Le script va automatiquement:
- ✅ Sauvegarder l'état actuel
- ✅ Récupérer les dernières modifications
- ✅ Mettre à jour les dépendances
- ✅ Exécuter les migrations
- ✅ Optimiser l'application
- ✅ Vérifier le bon fonctionnement

---

## 🔧 Méthode 2: Commandes manuelles

### 1. Se connecter au serveur
```bash
ssh utilisateur@votre-serveur
cd /chemin/vers/Kalmi-Gestion
```

### 2. Sauvegarder l'état actuel
```bash
# Créer un backup
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

# Sauvegarder .env
cp .env "$BACKUP_DIR/.env.backup"

# Sauvegarder les fichiers uploadés
cp -r storage/app/public "$BACKUP_DIR/"
```

### 3. Récupérer les modifications
```bash
# Vérifier l'état actuel
git status

# Récupérer les dernières modifications
git fetch origin
git pull origin main
```

### 4. Mettre à jour les dépendances
```bash
# Dépendances PHP
composer install --optimize-autoloader --no-interaction

# Dépendances JavaScript
npm ci --production
npm run build
```

### 5. Base de données
```bash
# Exécuter les nouvelles migrations
php artisan migrate --force

# Mettre à jour les seeders si nécessaire
php artisan db:seed --class=DatabaseSeeder --force
```

### 6. Optimiser l'application
```bash
# Nettoyer les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recompiler les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Vérifier l'application
```bash
# Vérifier l'état de l'application
php artisan about

# Tester l'application
curl -I http://localhost
```

---

## 🌐 Commandes rapides

### Mise à jour simple (si pas de nouvelles migrations)
```bash
cd /chemin/vers/Kalmi-Gestion
git pull
composer install --no-dev
npm run build
php artisan optimize
```

### Mise à jour complète
```bash
cd /chemin/vers/Kalmi-Gestion
git pull
composer update
npm update
npm run build
php artisan migrate --force
php artisan optimize
```

---

## 🔍 Vérifications post-mise à jour

### 1. Vérifier l'application
```bash
# Test de l'application
php artisan tinker
> echo "Application OK";
> exit

# Vérifier la base de données
php artisan tinker
> DB::connection()->getPdo();
> exit
```

### 2. Vérifier les logs
```bash
# Voir les derniers logs
tail -f storage/logs/laravel.log

# Voir les erreurs récentes
grep -i error storage/logs/laravel.log | tail -10
```

### 3. Vérifier les permissions
```bash
# Permissions recommandées
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 4. Redémarrer les services si nécessaire
```bash
# Pour Apache
sudo systemctl restart apache2

# Pour Nginx
sudo systemctl restart nginx

# Pour PHP-FPM
sudo systemctl restart php8.2-fpm
```

---

## 🚨 Résolution de problèmes courants

### Erreur de dépendances
```bash
# Réinstaller Composer
rm -rf vendor composer.lock
composer install

# Réinstaller npm
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Erreur de base de données
```bash
# Vérifier la connexion
php artisan tinker
> DB::connection()->getPdo();

# Forcer les migrations
php artisan migrate --force

# Réinitialiser si nécessaire
php artisan migrate:fresh --force
php artisan db:seed --force
```

### Erreur de permissions
```bash
# Corriger les permissions
sudo chown -R www-data:www-data .
sudo chmod -R 755 storage
sudo chmod -R 755 bootstrap/cache
```

### Conflit Git
```bash
# Annuler les modifications locales et forcer le pull
git reset --hard HEAD
git clean -fd
git pull origin main
```

---

## 📋 Checklist de mise à jour

### Avant la mise à jour
- [ ] Sauvegarder la base de données
- [ ] Sauvegarder les fichiers .env
- [ ] Sauvegarder les fichiers uploadés
- [ ] Notifier les utilisateurs (maintenance)

### Pendant la mise à jour
- [ ] Récupérer les dernières modifications
- [ ] Mettre à jour les dépendances
- [ ] Exécuter les migrations
- [ ] Compiler les assets

### Après la mise à jour
- [ ] Vérifier l'application fonctionne
- [ ] Tester les fonctionnalités principales
- [ ] Vérifier les logs d'erreurs
- [ ] Nettoyer les anciens backups

---

## 🔄 Automatisation avec Cron

Pour des mises à jour automatiques, vous pouvez créer une tâche cron:

```bash
# Éditer crontab
crontab -e

# Ajouter une mise à jour quotidienne à 3h du matin
0 3 * * * cd /chemin/vers/Kalmi-Gestion && ./update-server.sh >> /var/log/kalmi-update.log 2>&1
```

---

## 📞 Support

En cas de problème:
1. **Vérifier les logs** : `storage/logs/laravel.log`
2. **Vérifier les permissions** : `ls -la storage/`
3. **Vérifier la base de données** : `php artisan tinker`
4. **Restaurer le backup** si nécessaire

---

## 🎉 Conclusion

La mise à jour du serveur est maintenant terminée ! Votre application Kalmi Gestion est à jour avec les dernières corrections et améliorations.

**URL de l'application** : http://votre-domaine.com
**Comptes** : email@admin.com / password (admin) | vendeur@vendeur.com / password (vendeur)
