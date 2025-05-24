<?php
session_start();

// Connexion à la base de données avec MySQLi
$host = 'localhost';
$dbname = 'projettp';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérification de l'utilisateur connecté
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

// Vérifier si un événement est passé en paramètre pour suppression
if (isset($_POST['id']) && $user_id > 0) {
    $event_id = (int)$_POST['id'];

    // Vérifier que l'utilisateur est bien l'auteur de l'événement
    $stmt = $conn->prepare("SELECT user_id FROM submit_event WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();

        // Si l'utilisateur est le créateur de l'événement, on peut le supprimer
        if ($event['user_id'] === $user_id) {
            
            // Supprimer les inscriptions associées à l'événement
            $stmt = $conn->prepare("DELETE FROM inscriptions WHERE event_id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();

            // Supprimer l'événement
            $stmt = $conn->prepare("DELETE FROM submit_event WHERE id = ?");
            $stmt->bind_param("i", $event_id);
            if ($stmt->execute()) {
                // Rediriger vers la liste des événements après suppression
                header("Location: recuperer_evenements.php");
                exit();
            } else {
                echo "Erreur lors de la suppression de l'événement.";
            }
        } else {
            echo "Vous n'êtes pas autorisé à supprimer cet événement.";
        }
    } else {
        echo "Événement non trouvé.";
    }

    $stmt->close();
} else {
    echo "Aucun événement sélectionné.";
}

$conn->close();
?>
