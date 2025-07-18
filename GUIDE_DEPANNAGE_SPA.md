# Guide de dépannage - Problèmes de chargement SPA

## 🔍 Diagnostic du problème

### Symptômes
- Les couleurs ne s'affichent pas correctement après navigation
- Les données ne se chargent pas sans actualisation
- Les styles Tailwind ne s'appliquent pas
- L'interface semble "cassée" après navigation

### Causes possibles
1. **Styles CSS non rechargés** - Tailwind ne détecte pas les nouvelles classes
2. **Données non initialisées** - Les scripts ne se relancent pas
3. **Event listeners perdus** - Les liens SPA ne fonctionnent plus
4. **DOM non synchronisé** - Le contenu change mais les styles restent

## 🛠️ Solutions

### 1. Correction automatique (recommandé)

Le système a été corrigé avec :
- ✅ **Rechargement automatique des styles** après navigation
- ✅ **Initialisation forcée** des fonctionnalités par page
- ✅ **Gestion des event listeners** pour éviter les doublons
- ✅ **Observer DOM** pour détecter les changements

### 2. Vérification manuelle

Ouvrez la console du navigateur (F12) et tapez :

```javascript
// Vérifier l'état de la page
debugSPA.logPageLoad();

// Vérifier les styles
debugSPA.checkStyles();

// Forcer le rechargement
debugSPA.forceReloadStyles();
```

### 3. Test de navigation

Naviguez entre les pages et vérifiez dans la console :
- ✅ Messages de débogage apparaissent
- ✅ Pas d'erreurs JavaScript
- ✅ Styles appliqués correctement

### 4. Solutions spécifiques par page

#### Page Profil
```javascript
// Forcer l'initialisation du profil
Profil.init();
```

#### Page Messagerie
```javascript
// Recharger la messagerie
if (typeof Messagerie !== 'undefined') {
    new Messagerie();
}
```

#### Page Amis
```javascript
// Recharger les amis
if (typeof FriendsPage !== 'undefined') {
    new FriendsPage();
}
```

### 5. Correction des styles

Si les styles ne s'appliquent pas :

```javascript
// Forcer le rechargement Tailwind
if (window.tailwind) {
    window.tailwind.refresh();
}

// Forcer le reflow
document.body.offsetHeight;

// Réappliquer les classes
const elements = document.querySelectorAll('[class*="bg-"], [class*="text-"]');
elements.forEach(element => {
    const classes = element.className.split(' ');
    classes.forEach(className => {
        if (className.includes('bg-') || className.includes('text-')) {
            element.classList.add(className);
        }
    });
});
```

## 🔧 Améliorations apportées

### 1. Fonction `chargerPage` améliorée
```javascript
chargerPage: async (page, addHistory = true) => {
    // ... chargement du contenu ...
    
    // Attendre que le DOM soit mis à jour
    await new Promise(resolve => setTimeout(resolve, 100));
    
    // Initialiser les fonctionnalités spécifiques
    App.setupPageSpecificFeatures(pageName);
    
    // Recharger les styles
    App.reloadStyles();
}
```

### 2. Gestion des event listeners
```javascript
attachSPALinks: () => {
    // Supprimer les anciens listeners
    document.body.removeEventListener('click', Utils.handleSPAClick);
    
    // Ajouter les nouveaux
    document.body.addEventListener('click', Utils.handleSPAClick);
}
```

### 3. Observer DOM
```javascript
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.type === 'childList') {
            setTimeout(() => {
                App.reloadStyles();
            }, 50);
        }
    });
});
```

## 🧪 Tests

### Test 1 : Navigation simple
1. Allez sur `?page=profil`
2. Cliquez sur "Messagerie"
3. Vérifiez que les couleurs s'affichent
4. Retournez au profil
5. Vérifiez que les données se chargent

### Test 2 : Navigation avec paramètres
1. Allez sur `?page=profil&user_id=2`
2. Cliquez sur "Amis"
3. Vérifiez que la liste se charge
4. Retournez au profil
5. Vérifiez que les boutons fonctionnent

### Test 3 : Navigation rapide
1. Naviguez rapidement entre les pages
2. Vérifiez qu'il n'y a pas d'erreurs
3. Vérifiez que les styles restent cohérents

## 🚨 Problèmes connus et solutions

### Problème : Styles non appliqués
**Solution :** Utilisez `debugSPA.forceReloadStyles()`

### Problème : Données non chargées
**Solution :** Vérifiez que l'API correspondante fonctionne

### Problème : Liens cassés
**Solution :** Vérifiez que `Utils.attachSPALinks()` est appelé

### Problème : Performance lente
**Solution :** Les délais ont été optimisés pour un bon équilibre

## 📊 Monitoring

Le système de débogage affiche dans la console :
- 🔄 Navigation entre les pages
- ✅ Éléments trouvés/missing
- 🎨 Classes Tailwind appliquées
- 📋 État général de la page

## 🎯 Résultat attendu

Après ces corrections, vous devriez avoir :
- ✅ Navigation fluide entre les pages
- ✅ Styles appliqués immédiatement
- ✅ Données chargées automatiquement
- ✅ Pas besoin d'actualiser la page
- ✅ Interface cohérente partout 