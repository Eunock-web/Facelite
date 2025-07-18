<?php
// Script de test pour vérifier le système de profil

echo "=== Test du système de profil FaceLite2 ===\n\n";

// 1. Test de la base de données
echo "1. Test de connexion à la base de données...\n";
try {
    require_once 'Database/database.php';
    $conn = Database::getInstance()->getConnection();
    echo "✅ Connexion à la base de données réussie\n";
} catch (Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "\n";
    exit;
}

// 2. Test de récupération des utilisateurs
echo "\n2. Test de récupération des utilisateurs...\n";
try {
    $stmt = $conn->prepare("SELECT user_id, firstname, lastname, email FROM users LIMIT 3");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($users) > 0) {
        echo "✅ " . count($users) . " utilisateur(s) trouvé(s)\n";
        foreach ($users as $user) {
            echo "   - " . $user['firstname'] . " " . $user['lastname'] . " (ID: " . $user['user_id'] . ")\n";
        }
    } else {
        echo "⚠️ Aucun utilisateur trouvé\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}

// 3. Test de récupération des informations détaillées
echo "\n3. Test de récupération des informations détaillées...\n";
try {
    $stmt = $conn->prepare("SELECT * FROM informations LIMIT 3");
    $stmt->execute();
    $infos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($infos) > 0) {
        echo "✅ " . count($infos) . " enregistrement(s) d'informations trouvé(s)\n";
    } else {
        echo "⚠️ Aucune information détaillée trouvée\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}

// 4. Test de récupération des amis
echo "\n4. Test de récupération des amis...\n";
try {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM amis WHERE statut = 'accepted'");
    $stmt->execute();
    $nb_amis = $stmt->fetchColumn();
    echo "✅ " . $nb_amis . " relation(s) d'amitié trouvée(s)\n";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
}

// 5. Test des APIs
echo "\n5. Test des APIs...\n";

// Test de l'API get.php
echo "   - Test de api/profil/get.php...\n";
$get_url = "http://localhost/FaceLite2/api/profil/get.php";
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => 'Content-Type: application/json'
    ]
]);

$response = @file_get_contents($get_url, false, $context);
if ($response !== false) {
    $data = json_decode($response, true);
    if ($data && isset($data['success'])) {
        echo "   ✅ API get.php accessible\n";
    } else {
        echo "   ⚠️ API get.php accessible mais format de réponse incorrect\n";
    }
} else {
    echo "   ❌ API get.php non accessible\n";
}

// Test de l'API getUser.php
echo "   - Test de api/profil/getUser.php...\n";
$getUser_url = "http://localhost/FaceLite2/api/profil/getUser.php?user_id=1";
$response = @file_get_contents($getUser_url, false, $context);
if ($response !== false) {
    $data = json_decode($response, true);
    if ($data && isset($data['success'])) {
        echo "   ✅ API getUser.php accessible\n";
    } else {
        echo "   ⚠️ API getUser.php accessible mais format de réponse incorrect\n";
    }
} else {
    echo "   ❌ API getUser.php non accessible\n";
}

echo "\n=== Fin du test ===\n";
echo "\nPour tester complètement le système :\n";
echo "1. Allez sur http://localhost/FaceLite2/?page=profil\n";
echo "2. Vérifiez que toutes les informations s'affichent correctement\n";
echo "3. Testez avec un autre utilisateur : http://localhost/FaceLite2/?page=profil&user_id=2\n";
?> 