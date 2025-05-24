<?php
session_start();

// Connexion à la base de données
$host = 'localhost';
$dbname = 'projettp';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si l'utilisateur est connecté
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Vérifier si l'utilisateur est connecté avant de continuer
if ($user_id === 0) {
    die("Veuillez vous connecter pour vous inscrire à un événement.");
}

// Récupérer l'ID de l'événement
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

// Vérification si l'utilisateur est déjà inscrit à cet événement
$sql_check = "SELECT COUNT(*) FROM inscriptions WHERE user_id = ? AND event_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $event_id);
$stmt_check->execute();
$stmt_check->bind_result($is_registered);
$stmt_check->fetch();
$stmt_check->close();

// Si l'utilisateur est déjà inscrit, afficher un message et empêcher l'inscription
if ($is_registered > 0) {
    echo "Vous êtes déjà inscrit à cet événement.";
    exit; // Arrêter le script ici pour empêcher l'inscription
}

// Ajouter l'inscription à la base de données si l'utilisateur n'est pas encore inscrit
$sql_insert = "INSERT INTO inscriptions (user_id, event_id) VALUES (?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ii", $user_id, $event_id);
$stmt_insert->execute();
$stmt_insert->close();

// Rediriger l'utilisateur vers la page des événements avec un message de succès
header("Location: recuperer_evenements.php?message=Inscription réussie !");
exit;
?>
