# Système de Messagerie - FaceLite2

Ce système de messagerie utilise WebSocket pour la communication en temps réel et une API REST pour la gestion des données.

## Installation

### 1. Installer les dépendances

```bash
composer install
```

### 2. Créer les tables de base de données

Exécutez le script SQL dans `database.sql` pour créer les tables nécessaires :

```sql
-- Exécuter le contenu de api/message/database.sql
```

### 3. Configurer la base de données

Modifiez les paramètres de connexion dans `api/message/Database.php` selon votre configuration.

## Utilisation

### 1. Démarrer le serveur WebSocket

Sur Windows :
```bash
start_websocket.bat
```

Ou manuellement :
```bash
php api/message/start_websocket.php
```

Le serveur WebSocket sera accessible sur `ws://localhost:8080`

### 2. Accéder à la messagerie

Naviguez vers `?page=messagerie` dans votre application.

## Structure des fichiers

### Backend (api/message/)

- `Database.php` - Classe de connexion à la base de données
- `Conversation.php` - Gestion des conversations
- `Message.php` - Gestion des messages
- `conversations.php` - API REST pour les conversations
- `messages.php` - API REST pour les messages
- `start_websocket.php` - Serveur WebSocket
- `database.sql` - Structure de la base de données

### Frontend

- `vues/users/messagerie.php` - Interface utilisateur

## API REST

### Conversations

- `GET api/message/conversations.php` - Récupérer les conversations de l'utilisateur
- `POST api/message/conversations.php` - Créer une nouvelle conversation

### Messages

- `GET api/message/messages.php?conversation_id=X` - Récupérer les messages d'une conversation
- `POST api/message/messages.php` - Envoyer un message
- `DELETE api/message/messages.php?message_id=X` - Supprimer un message

## WebSocket

### Types de messages

- `auth` - Authentification de l'utilisateur
- `message` - Envoi d'un message
- `typing` - Indicateur de frappe
- `read` - Marquer comme lu

### Format des messages

```json
{
  "type": "message",
  "conversation_id": 1,
  "content": "Bonjour !"
}
```

## Fonctionnalités

- ✅ Conversations privées
- ✅ Messages en temps réel via WebSocket
- ✅ Indicateurs de lecture
- ✅ Interface responsive
- ✅ Gestion des erreurs
- ✅ Reconnexion automatique WebSocket

## Dépannage

### Le serveur WebSocket ne démarre pas

1. Vérifiez que Ratchet est installé : `composer show cboden/ratchet`
2. Vérifiez que le port 8080 est libre
3. Vérifiez les logs d'erreur PHP

### Les messages ne s'affichent pas

1. Vérifiez que le serveur WebSocket est démarré
2. Vérifiez la console du navigateur pour les erreurs
3. Vérifiez que l'utilisateur est connecté

### Erreurs de base de données

1. Vérifiez la configuration dans `Database.php`
2. Vérifiez que les tables sont créées
3. Vérifiez les permissions de la base de données 