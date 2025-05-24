<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'projettp';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$name = htmlspecialchars($_POST['name']);
$role = htmlspecialchars($_POST['role']);
$message = htmlspecialchars($_POST['message']);
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

// Valider les données
if (!empty($name) && !empty($message) && $rating > 0) {
    // Insérer dans la base
    $stmt = $conn->prepare("INSERT INTO temoignages (name, role, message, rating) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssi", $name, $role, $message, $rating);
        $stmt->execute();
        $stmt->close();
        header("Location: pageAcceuilnv.php");
        exit();
    } else {
        die("Erreur SQL : " . $conn->error);
    }
} else {
    echo "Veuillez remplir tous les champs obligatoires.";
}

$conn->close();
?>
