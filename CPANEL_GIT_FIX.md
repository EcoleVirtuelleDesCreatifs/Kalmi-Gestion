# Guide de résolution de l'erreur Git 403 dans cPanel

## 🚨 Erreur identifiée
```
fatal: unable to access 'https://github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion/': The requested URL returned error: 403
```

## 🔍 Cause de l'erreur
L'erreur 403 signifie que Git n'a pas les permissions nécessaires pour accéder au dépôt GitHub. Dans cPanel, c'est souvent dû à :
- Absence de token d'authentification GitHub
- Configuration Git incorrecte
- Restrictions du serveur cPanel

---

## 🛠️ Solution 1: Configurer un token GitHub (recommandé)

### 1. Créer un Personal Access Token sur GitHub
1. Connectez-vous à GitHub : https://github.com
2. Allez dans Settings → Developer settings → Personal access tokens → Tokens (classic)
3. Cliquez sur "Generate new token"
4. Donnez un nom (ex: "cPanel-Kalmi-Gestion")
5. Cochez les permissions :
   - ✅ `repo` (Contrôle total des dépôts privés)
   - ✅ `workflow` (Mettre à jour les workflows GitHub Actions)
6. Cliquez sur "Generate token"
7. **Copiez immédiatement le token** (il ne sera plus affiché)

### 2. Configurer Git dans cPanel
```bash
# Dans le terminal cPanel, naviguez vers votre projet
cd public_html/Kalmi-Gestion

# Configurez Git avec votre token
git config --global credential.helper store
git config --global user.name "Votre Nom"
git config --global user.email "votre-email@example.com"

# Testez avec le token (remplacez VOTRE_TOKEN)
git pull https://VOTRE_TOKEN@github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion.git main
```

---

## 🛠️ Solution 2: Mettre à jour l'URL du dépôt

### 1. Vérifier l'URL actuelle
```bash
git remote -v
```

### 2. Mettre à jour avec le token
```bash
# Remplacez VOTRE_TOKEN par votre token GitHub
git remote set-url origin https://VOTRE_TOKEN@github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion.git
```

### 3. Faire le pull
```bash
git pull origin main
```

---

## 🛠️ Solution 3: Utiliser SSH (si disponible)

### 1. Générer une clé SSH dans cPanel
```bash
# Générer une clé SSH
ssh-keygen -t rsa -b 4096 -C "votre-email@example.com"

# Afficher la clé publique
cat ~/.ssh/id_rsa.pub
```

### 2. Ajouter la clé à GitHub
1. Copiez la clé publique affichée
2. Allez sur GitHub → Settings → SSH and GPG keys
3. Cliquez sur "New SSH key"
4. Collez la clé et donnez un nom

### 3. Configurer Git pour SSH
```bash
# Changer l'URL en SSH
git remote set-url origin git@github.com:EcoleVirtuelleDesCreatifs/Kalmi-Gestion.git

# Faire le pull
git pull origin main
```

---

## 🛠️ Solution 4: Téléchargement manuel (alternative)

Si Git ne fonctionne pas dans cPanel :

### 1. Télécharger manuellement depuis GitHub
1. Allez sur : https://github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion
2. Cliquez sur le bouton vert "Code"
3. Cliquez sur "Download ZIP"
4. Téléchargez le fichier ZIP

### 2. Extraire dans cPanel
```bash
# Naviguez vers votre répertoire
cd public_html

# Sauvegardez l'ancienne version (si elle existe)
mv Kalmi-Gestion Kalmi-Gestion-backup-$(date +%Y%m%d)

# Créez le répertoire et extrayez
mkdir Kalmi-Gestion
cd Kalmi-Gestion

# Utilisez l'utilitaire unzip de cPanel ou :
unzip ../Kalmi-Gestion-main.zip
```

### 3. Configuration après extraction
```bash
# Configurez l'environnement
cp .env.example .env

# Installez les dépendances (si composer disponible)
composer install --no-dev

# Nettoyez les caches
php artisan cache:clear
php artisan config:clear
```

---

## 🛠️ Solution 5: Utiliser le Git Manager de cPanel

### 1. Via l'interface cPanel
1. Connectez-vous à cPanel
2. Cherchez "Git Version Control" ou "Setup Git Repository"
3. Clonez le dépôt :
   - URL : `https://github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion.git`
   - Répertoire : `Kalmi-Gestion`
   - Branche : `main`

### 2. Configuration des credentials
Dans le Git Manager de cPanel, ajoutez :
- Username : Votre nom d'utilisateur GitHub
- Token/Password : Votre Personal Access Token

---

## 🔧 Commandes de diagnostic

### Vérifier la configuration Git
```bash
# Vérifier la configuration
git config --list

# Vérifier les remotes
git remote -v

# Tester la connexion
git ls-remote https://github.com/EcoleVirtuelleDesCreatifs/Kalmi-Gestion.git
```

### Nettoyer les credentials Git
```bash
# Supprimer les credentials stockés
git config --global --unset credential.helper
rm -f ~/.git-credentials
```

---

## 📋 Checklist post-mise à jour

Après avoir réussi le pull :

### 1. Vérifier les fichiers
```bash
# Vérifier que les fichiers sont à jour
ls -la

# Vérifier la version
git log --oneline -n 3
```

### 2. Mettre à jour les dépendances
```bash
# Si composer est disponible
composer install --optimize-autoloader --no-dev

# Mettre à jour les assets (si npm disponible)
npm install
npm run build
```

### 3. Base de données
```bash
# Exécuter les migrations si nécessaire
php artisan migrate --force
```

### 4. Nettoyer et optimiser
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 🚨 Erreurs courantes et solutions

### "Permission denied (publickey)"
→ Utilisez la solution avec Personal Access Token (Solution 1)

### "SSL certificate problem"
```bash
git config --global http.sslVerify false
```

### "Repository not found"
→ Vérifiez l'URL du dépôt et vos permissions d'accès

### "Composer not found"
→ Utilisez le gestionnaire de paquets cPanel ou contactez votre hébergeur

---

## 🎞️ Support cPanel

Si aucune solution ne fonctionne :

1. **Contactez votre hébergeur** pour vérifier si Git est correctement configuré
2. **Vérifiez les limitations** de votre hébergement cPanel
3. **Utilisez le File Manager** de cPanel pour les téléchargements manuels

---

## ✅ Test final

Après la mise à jour, testez :
- [ ] L'application s'affiche correctement
- [ ] Pas d'erreurs 500
- [ ] Les nouvelles fonctionnalités sont présentes
- [ ] La base de données est à jour

**URL de test** : `https://votre-domaine.com/Kalmi-Gestion/public`

---

## 📞 Assistance supplémentaire

Si vous avez besoin d'aide :
1. **GitHub** : Vérifiez que vous avez bien les permissions sur le dépôt
2. **cPanel** : Consultez la documentation de votre hébergeur
3. **Développeur** : Contactez le développeur du projet pour assistance

**Le plus simple est souvent la Solution 1 avec un Personal Access Token GitHub !** 🚀
