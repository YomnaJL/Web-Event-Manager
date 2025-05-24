<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirige l'utilisateur s'il n'est pas connecté
    exit();
}

// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'projettp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p style='color: red;'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</p>");
}

// Identifier l'utilisateur connecté
$currentUserId = $_SESSION['user_id'];

// Obtenir les événements créés par l'utilisateur
$stmt = $pdo->prepare("
    SELECT id, titre, date, status
    FROM submit_event
    WHERE user_id = ?
");
$stmt->execute([$currentUserId]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtenir les inscrits pour chaque événement
$eventDetails = [];
foreach ($events as $event) {
    $stmtInscrits = $pdo->prepare("
        SELECT su.nom, su.email
        FROM inscriptions i
        LEFT JOIN signuputi su ON i.user_id = su.id
        WHERE i.event_id = ?
    ");
    $stmtInscrits->execute([$event['id']]);
    $inscrits = $stmtInscrits->fetchAll(PDO::FETCH_ASSOC);

    $eventDetails[] = [
        'event' => $event,
        'inscrits' => $inscrits
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes événements et leurs inscrits</title>
    
    <style>
/* Reset CSS pour éviter les décalages par défaut */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Global body */
body {
  font-family: 'Arial', sans-serif;
  background: linear-gradient(to right, #e0eafc, #cfdef3);
  color: #333;
  line-height: 1.6;
  min-height: 100vh;
}

/* Navbar Styles */
/* Navbar Styles */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #4A007E;
    padding: 0.8rem 2rem;
    color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.navbar .logo {
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
    position: relative;
    text-transform: uppercase;
}
.navbar .logo::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #ff00e1;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.4s ease;
}

.navbar .logo:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

.navbar a {
    color: #fff;
    font-size: 1.1rem;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.navbar a:hover {
    color: white;
    transform: scale(1.05);
}

/* Événements */
.event-container {
  background: white;
  padding: 20px;
  margin: 10px auto;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  max-width: 800px;
}

.event-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
}

.event-container h3 {
  color: #6a0dad;
  margin-bottom: 5px;
}

.event-container p {
  color: #555;
  font-size: 14px;
  margin-bottom: 10px;
}

.event-container h4 {
  font-size: 16px;
  color: #333;
}


        /* Liste des inscrits */
        ul {
            list-style: none;
            padding: 0;
        }

        li.inscrit {
            font-size: 14px;
            padding: 5px;
            color: #555;
        }

        li.no-inscrit {
            color: red;
            font-size: 14px;
        }

        /* Statut de l'événement */
        .status {
            font-weight: bold;
            color: #333;
            font-size: 15px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <a href="pageAcceuilnv.php" class="logo">DreamEvent</a>
    </nav>

    <?php if (count($eventDetails) > 0): ?>
        <?php foreach ($eventDetails as $detail): ?>
            <div class="event-container">
                <h3>Événement : <?php echo htmlspecialchars($detail['event']['titre']); ?></h3>
                <p>Date : <?php echo htmlspecialchars($detail['event']['date']); ?></p>
                <p class="status"><strong>Statut : </strong><?php echo htmlspecialchars($detail['event']['status']); ?></p>
                
                <!-- Vérification du statut pour ne pas afficher les inscrits si le statut est "refusé" -->
                <?php if ($detail['event']['status'] !== 'refusé'): ?>
                    <h4>Inscrits :</h4>
                    <?php if (count($detail['inscrits']) > 0): ?>
                        <ul>
                            <?php foreach ($detail['inscrits'] as $inscrit): ?>
                                <li class="inscrit"><?php echo htmlspecialchars($inscrit['nom']) . " - " . htmlspecialchars($inscrit['email']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="no-inscrit">Aucun inscrit pour cet événement.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="no-inscrit">Les inscriptions ne sont pas affichées car l'événement est refusé.</p>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align: center;">Aucun événement créé par vous.</p>
    <?php endif; ?>
</body>
</html>
