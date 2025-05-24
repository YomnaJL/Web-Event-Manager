<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";  // Remplacez par votre nom d'utilisateur
$password = "";  // Remplacez par votre mot de passe
$dbname = "projettp"; // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Vérifier si les données sont envoyées via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer et nettoyer les données du formulaire
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    // Vérification simple pour s'assurer que les champs ne sont pas vides
    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        echo "Tous les champs sont obligatoires.";
    } else {
        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "L'email fourni n'est pas valide.";
        } else {
            // Vérifier si l'email existe déjà dans la base de données
            $sql_check = "SELECT * FROM signup WHERE email = ?";
            if ($stmt_check = $conn->prepare($sql_check)) {
                $stmt_check->bind_param("s", $email);
                $stmt_check->execute();
                $stmt_check->store_result();

                if ($stmt_check->num_rows > 0) {
                    echo "Un compte existe déjà avec cet email.";
                } else {
                    // Hachage du mot de passe pour la sécurité
                    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                    // Préparer la requête d'insertion
                    $sql = "INSERT INTO signup (nom, email, mot_de_passe) VALUES (?, ?, ?)";

                    // Préparer la déclaration
                    if ($stmt = $conn->prepare($sql)) {
                        // Lier les paramètres
                        $stmt->bind_param("sss", $nom, $email, $mot_de_passe_hache);

                        // Exécuter la requête
                        if ($stmt->execute()) {
                            echo "Compte créé avec succès!";
                            // Rediriger l'utilisateur vers la page admin
                            header("Location: pageadmin.php"); 
                            exit(); // N'oubliez pas de mettre exit() après header pour stopper l'exécution du script
                        } else {
                            echo "Erreur lors de la création du compte: " . $stmt->error;
                        }
                        
                        // Fermer la déclaration
                        $stmt->close();
                    } else {
                        echo "Erreur de préparation de la requête : " . $conn->error;
                    }
                }

                // Fermer la déclaration de vérification de l'email
                $stmt_check->close();
            } else {
                echo "Erreur de préparation de la requête : " . $conn->error;
            }
        }
    }
}

// Fermer la connexion
$conn->close();
?>
