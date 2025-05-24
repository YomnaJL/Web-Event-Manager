<?php


// Connexion à la base de données
$host = 'localhost';
$dbname = 'projettp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si l'ID de l'événement est passé dans l'URL
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Récupérer les données de l'événement à modifier
    $stmt = $pdo->prepare("SELECT * FROM submit_event WHERE id = :id");
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "Événement introuvable.";
        exit();
    }

    // Si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérer les nouvelles données du formulaire
        $titre = trim($_POST["titre"]);
        $description = trim($_POST["description"]);
        $date = trim($_POST["date"]);
        $lieu = trim($_POST["lieu"]);
        $categorie = trim($_POST["categorie"]);

        // Vérifier si une nouvelle image est téléchargée
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $image = $_FILES["image"]["tmp_name"];
            $imageContent = file_get_contents($image);

            // Mettre à jour l'événement dans la base de données avec la nouvelle image
            $updateStmt = $pdo->prepare("UPDATE submit_event 
                                        SET titre = :titre, description = :description, date = :date, lieu = :lieu, 
                                            categorie = :categorie, image = :image 
                                        WHERE id = :id");
            $updateStmt->bindParam(':titre', $titre);
            $updateStmt->bindParam(':description', $description);
            $updateStmt->bindParam(':date', $date);
            $updateStmt->bindParam(':lieu', $lieu);
            $updateStmt->bindParam(':categorie', $categorie);
            $updateStmt->bindParam(':image', $imageContent, PDO::PARAM_LOB);
            $updateStmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        } else {
            // Si aucune nouvelle image n'est téléchargée, on ne met à jour que les autres champs
            $updateStmt = $pdo->prepare("UPDATE submit_event 
                                        SET titre = :titre, description = :description, date = :date, lieu = :lieu, 
                                            categorie = :categorie
                                        WHERE id = :id");
            $updateStmt->bindParam(':titre', $titre);
            $updateStmt->bindParam(':description', $description);
            $updateStmt->bindParam(':date', $date);
            $updateStmt->bindParam(':lieu', $lieu);
            $updateStmt->bindParam(':categorie', $categorie);
            $updateStmt->bindParam(':id', $eventId, PDO::PARAM_INT);
        }

        // Exécuter la mise à jour
        if ($updateStmt->execute()) {
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

<!-- Affichage du message de confirmation en haut de la page -->
<?php
// Afficher le message de succès s'il existe
if (isset($_SESSION['success_message'])) {
    echo '<div style="background-color: #4CAF50; color: white; text-align: center; padding: 10px; font-size: 16px; position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;">' . $_SESSION['success_message'] . '</div>';
    // Nettoyer le message après affichage
    unset($_SESSION['success_message']);
}
?>

<form method="POST" enctype="multipart/form-data">
    <h2>Modifier l'événement</h2>
    <label for="titre">Titre:</label>
    <input type="text" name="titre" value="<?= htmlspecialchars($event['titre']); ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required><?= htmlspecialchars($event['description']); ?></textarea><br>

    <label for="date">Date:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($event['date']); ?>" required><br>

    <label for="lieu">Lieu:</label>
    <input type="text" name="lieu" value="<?= htmlspecialchars($event['lieu']); ?>" required><br>

    <label for="categorie">Catégorie:</label>
    <select name="categorie" required>
        <option value="Conférence" <?= $event['categorie'] == 'Conférence' ? 'selected' : ''; ?>>Conférence</option>
        <option value="Atelier" <?= $event['categorie'] == 'Atelier' ? 'selected' : ''; ?>>Atelier</option>
        <!-- Autres options -->
    </select><br>

    <label for="image">Image (facultatif):</label>
    <input type="file" name="image"><br>

    <button type="submit">Mettre à jour l'événement</button>

    <style>
    /* Global Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    /* Form Container */
    form {
        max-width: 600px;
        margin: 2rem auto;
        background: linear-gradient(135deg, #ffffff 0%, #f1f1f1 100%);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin-top: 60px; /* Pour éviter que le formulaire soit caché derrière la barre */
    }

    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }

    /* Form Elements */
    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        margin-bottom: 1.2rem;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    textarea {
        resize: vertical;
    }

    /* Focused Elements */
    input:focus,
    textarea:focus,
    select:focus {
        border-color: #5c6bc0;
        outline: none;
    }

    /* File Input */
    input[type="file"] {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease;
    }

    input[type="file"]:focus {
        border-color: #3498db;
    }

    /* Submit Button */
    button {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(45deg, #580994, #fa2cb9);
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    button:hover {
        background: linear-gradient(45deg, #580994, #fa2cb9);
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        form {
            padding: 1.5rem;
        }

        h2 {
            font-size: 1.5rem;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            padding: 0.6rem;
        }
    }
    </style>
</form>
