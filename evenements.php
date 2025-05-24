<?php
session_start(); // Démarre la session pour récupérer l'ID de l'utilisateur connecté

// Connexion à la base de données
$host = 'localhost'; // Nom d'hôte de la base de données
$dbname = 'projettp'; // Nom de votre base de données
$username = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe de la base de données

try {
    // Création de la connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour créer un événement.";
    exit();
}

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données sans les filtrer excessivement
    $titre = trim($_POST["titre"]);
    $description = trim($_POST["description"]);
    $date = trim($_POST["date"]);
    $lieu = trim($_POST["lieu"]);
    $categorie = trim($_POST["categorie"]);

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Récupérer l'image en tant que contenu binaire
        $image = $_FILES["image"]["tmp_name"];
        $imageContent = file_get_contents($image);

        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $_SESSION['user_id'];

        // Préparer l'insertion de l'événement dans la table submit_event, incluant l'user_id
        $stmt = $pdo->prepare("INSERT INTO submit_event (titre, description, date, lieu, categorie, image, user_id) 
                               VALUES (:titre, :description, :date, :lieu, :categorie, :image, :user_id)");
        $stmt->bindParam(":titre", $titre);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":lieu", $lieu);
        $stmt->bindParam(":categorie", $categorie);
        $stmt->bindParam(":image", $imageContent, PDO::PARAM_LOB); // Spécifier le type BLOB
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT); // Lier l'ID de l'utilisateur

        // Exécuter l'insertion de l'événement
        if ($stmt->execute()) {
             // Ajouter un message de succès dans la session
             $_SESSION['success_message'] = "Votre modification a été enregistrée.";

             // Rediriger l'utilisateur vers la page des événements
             header("Location: recuperer_evenements.php");
             exit(); // Toujours arrêter le script après une redirection
         } else {
             echo "Erreur lors de la mise à jour de l'événement.";
         }
     }
 } else {
     echo "Aucun ID d'événement spécifié.";
     exit();
 }
?>
