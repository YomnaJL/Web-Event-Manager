<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "projettp"; 

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Vérifier si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer et nettoyer les données du formulaire
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    // Vérification simple pour s'assurer que les champs ne sont pas vides
    if (empty($email) || empty($mot_de_passe)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'email fourni n'est pas valide.";
        exit();
    }

    // Préparer la requête de recherche de l'utilisateur
    $sql = "SELECT * FROM signuputi WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Lier l'email et exécuter la requête
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier si l'utilisateur existe
        if ($result->num_rows > 0) {
            // Récupérer les données de l'utilisateur
            $row = $result->fetch_assoc();

            // Vérifier le statut de l'utilisateur
            if ($row['status'] === 'blocked') {
                echo "Votre compte est bloqué. Veuillez contacter l'administrateur.";
                exit();
            } elseif ($row['status'] === 'deleted') {
                echo "Ce compte a été supprimé.";
                exit();
            }

            // Vérifier le mot de passe
            if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                // L'authentification a réussi
                session_start();
                $_SESSION['user_id'] = $row['id']; // Stocker l'ID utilisateur dans la session
                $_SESSION['username'] = $row['nom']; // Stocker le nom dans la session
                echo "Connexion réussie!";
                header("Location: pageAcceuilnv.php"); // Rediriger vers la page de création d'événements
                exit(); // Stopper l'exécution du script après redirection
            } else {
                echo "Mot de passe incorrect.";
                exit();
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email.";
            exit();
        }

        // Fermer la déclaration
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $conn->error;
        exit();
    }
}

// Fermer la connexion
$conn->close();
?>
