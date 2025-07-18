# Guide d'utilisation - Messagerie FaceLite2

## Comment entamer des discussions entre amis

### 1. **Prérequis**
- Les deux utilisateurs doivent être amis (statut "accepted" dans la table `amis`)

### 2. **Méthodes pour démarrer une conversation**

#### **Méthode A : Depuis la page des amis**
1. Allez sur `?page=amis`
2. Vous verrez la liste de tous vos amis
3. Cliquez sur le bouton "Message" à côté de l'ami avec qui vous voulez discuter
4. Vous serez automatiquement redirigé vers la messagerie avec la conversation ouverte

#### **Méthode B : Depuis le profil d'un ami**
1. Allez sur le profil d'un ami (`?page=profil&user_id=X`)
2. Si vous êtes amis, vous verrez un bouton "Message" dans les actions du profil
3. Cliquez sur ce bouton pour démarrer une conversation

#### **Méthode C : Depuis la messagerie**
1. Allez sur `?page=messagerie`
2. Si vous n'avez pas encore de conversation avec un ami, vous devrez d'abord en créer une
3. Utilisez l'API pour créer une nouvelle conversation

### 3. **API pour créer une conversation**

```javascript
// Créer une nouvelle conversation avec un ami
const response = await fetch('api/message/conversations.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        other_user_id: friendId // ID de l'ami
    })
});

const data = await response.json();
if (data.success) {
    // Conversation créée avec succès
    console.log('Conversation ID:', data.conversation.id);
}
```

### 4. **Vérification d'amitié**

Le système vérifie automatiquement que les deux utilisateurs sont amis avant de permettre la création d'une conversation :

```php
// Dans api/message/Conversation.php
public function areUsersFriends($user1Id, $user2Id) {
    $sql = "
        SELECT COUNT(*) as count 
        FROM amis 
        WHERE (user_id = ? AND ami_id = ? OR user_id = ? AND ami_id = ?) 
        AND statut = 'accepted'
    ";
    
    $result = $this->db->fetch($sql, [$user1Id, $user2Id, $user2Id, $user1Id]);
    return $result['count'] > 0;
}
```

### 5. **Interface utilisateur**

#### **Page des amis (`vues/users/amis.php`)**
- Liste de tous les amis avec photos de profil
- Bouton "Message" pour chaque ami
- Barre de recherche pour filtrer les amis
- Bouton "Profil" pour voir le profil complet

#### **Profil utilisateur**
- Bouton "Message" visible uniquement pour les amis
- Bouton "Ajouter en ami" pour les non-amis
- Gestion automatique de l'affichage selon le statut d'amitié

### 6. **Fonctionnalités de la messagerie**

- Historique des messages
- Interface responsive
- Design adaptatif (desktop/mobile)
- Navigation intuitive
- Recherche de conversations
- Gestion des conversations non lues

### 7. **Sécurité**

- Vérification d'amitié obligatoire
- Authentification utilisateur requise
- Validation des données côté serveur
- Protection contre les injections SQL

### 8. **Démarrage du système**

1. **Installer les tables** :
```bash
php api/message/install_tables.php
```

2. **Accéder à la messagerie** :
```
http://localhost/FaceLite2/?page=messagerie
```

### 9. **Structure des données**

#### **Table `conversations`**
- `id` : Identifiant unique
- `type` : 'private' ou 'group'
- `created_at` : Date de création
- `updated_at` : Date de dernière modification

#### **Table `conversation_participants`**
- `conversation_id` : ID de la conversation
- `user_id` : ID du participant
- `role` : 'admin' ou 'member'
- `last_read_at` : Date de dernière lecture

#### **Table `messages`**
- `conversation_id` : ID de la conversation
- `sender_id` : ID de l'expéditeur
- `content` : Contenu du message
- `message_type` : 'text', 'image', 'video', 'file'
- `created_at` : Date d'envoi

### 10. **Dépannage**

#### **Problème : "Vous devez être amis pour pouvoir discuter"**
- Vérifiez que les deux utilisateurs sont bien amis
- Vérifiez le statut dans la table `amis` (doit être 'accepted')

#### **Problème : Messages non envoyés**
- Vérifiez la connexion à la base de données
- Vérifiez les permissions d'écriture
- Vérifiez les logs d'erreur PHP

### 11. **Tests**

Pour tester le système :

```bash
# Tester la création de conversations
php api/message/test.php

# Vérifier les tables
php api/message/install_tables.php
```

### 12. **Évolutions futures**

- Messages vocaux
- Partage de fichiers
- Conversations de groupe
- Messages éphémères
- Réactions aux messages
- Citations de messages 