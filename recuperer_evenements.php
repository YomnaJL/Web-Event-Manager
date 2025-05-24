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

// Variables de filtrage
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$categorie_filter = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$popularite_filter = isset($_GET['popularite']) ? $_GET['popularite'] : '';
$order_filter = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Construction de la requête SQL
$sql = "SELECT e.id, e.titre, e.description, e.date, e.lieu, e.image, e.user_id, 
               (SELECT COUNT(*) FROM inscriptions i WHERE i.event_id = e.id) AS inscriptions_count
        FROM submit_event e
        WHERE e.status = 'accepté'";

// Ajout des filtres dynamiques
$params = [];
$types = "";

// Filtre par date
if ($date_filter) {
    $date_filter = date('Y-m-d', strtotime($date_filter));
    $sql .= " AND e.date = ?";
    $params[] = $date_filter;
    $types .= "s";
}

// Filtre par catégorie
if ($categorie_filter) {
    $sql .= " AND e.categorie = ?";
    $params[] = $categorie_filter;
    $types .= "s";
}

// Déterminer le bon ORDER BY en fonction des paramètres
if ($popularite_filter) {
    if ($popularite_filter == 'Plus populaire') {
        $sql .= " ORDER BY inscriptions_count DESC";
    } elseif ($popularite_filter == 'Moins populaire') {
        $sql .= " ORDER BY inscriptions_count ASC";
    }
} else {
    // Si aucune préférence de popularité, appliquer un tri par date
    $sql .= " ORDER BY e.date " . ($order_filter == 'desc' ? 'DESC' : 'ASC');
}

// Préparer la requête
$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Récupérer les événements sous forme de tableau
$evenements = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Fermer le statement
$stmt->close();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des événements</title>
   
    <script>
        function showFilter(filterId) {
            // Masquer toutes les sections
            const sections = document.querySelectorAll('.filter-section');
            sections.forEach(section => section.classList.remove('active'));

            // Afficher la section sélectionnée
            const selectedSection = document.getElementById(filterId);
            if (selectedSection) {
                selectedSection.classList.add('active');
            }
        }
    </script>
</head>
<body>
<style>
/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    min-height: 100vh;
}

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

/* Button Styles */
button {
    border: none;
    outline: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    transition: all 0.3s ease;
    color:#ff007a;
}

/* Filter Section */
.filter-buttons {
    text-align: center;
    margin: 20px;
}

.filter-buttons button {
    padding: 10px 15px;
    margin: 5px;
    background-color: #007BFF;
    color: white;
}

.filter-buttons button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.filter-section {
    display: none; /* Hidden by default */
    margin: 20px auto;
    text-align: center;
}

.filter-section.active {
    display: block; /* Show when active */
}

.filter-section label {
    margin-right: 10px;
    font-weight: bold;
}

/* Event Cards */
#events-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Responsive Grid */
    gap: 20px;
    justify-items: center;
    padding: 20px;
}

.event {
    width: 250px;
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 2px solid #ccc;
}

.event:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
}

.event img {
    max-width: 70%;
    height: auto;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.event img:hover {
    transform: scale(1.1);
}

.event h3 {
    margin-top: 15px;
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
}

/* Button Styles for Event Actions */
.create-event-btn {
    padding: 10px 15px;
    background-color: #ff007a;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.create-event-btn:hover {
    background-color: #ff007a;
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.btn-modifier {
    padding: 6px 12px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    font-size: 12px;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-modifier:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.btn-modifier:active {
    background-color: #003d7a;
}

.btn-supprimer {
    padding: 6px 12px;
    background:#ff007a;
    color: white;
    border-radius: 5px;
    font-size: 12px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-supprimer:hover {
    background-color: #ff007a;
    transform: scale(1.05);
}

.btn-supprimer:active {
    background-color: #721c24;
}

.btn-inscrire {
    padding: 6px 12px;
    background-color: #218838;
    color: white;
    border-radius: 5px;
    font-size: 12px;
    text-align: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-inscrire:hover {
    background-color: #186436;
    transform: scale(1.05);
}

/* Responsiveness */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        text-align: center;
    }

    .filter-buttons button {
        width: 100%;
        margin: 10px 0;
    }

    #events-container {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); /* Adjust for mobile */
    }

    .event {
        width: 220px;
    }
}

/* Scrollbar Customization */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.navbar, .filter-buttons, .event, .create-event-btn, .btn-modifier, .btn-supprimer, .btn-inscrire {
    animation: fadeIn 1s ease-out;
    opacity: 0;
    animation-fill-mode: forwards;
    animation-delay: 0.3s;
}

.navbar, .filter-buttons, .event {
    animation-delay: 0.5s;
}

.create-event-btn, .btn-modifier, .btn-supprimer, .btn-inscrire {
    animation-delay: 0.7s;
}

    </style>
<nav class="navbar">
    <a href="pageAcceuilnv.php" class="logo">DreamEvent</a>
    <a href="evenements.html" class="create-event-btn">Créer un événement</a>
</nav>

<!-- Boutons pour choisir un filtre -->
<div class="filter-buttons">
    <button onclick="showFilter('filter-date')">Filtrer par date</button>
    <button onclick="showFilter('filter-categorie')">Filtrer par catégorie</button>
    <button onclick="showFilter('filter-popularite')">Filtrer par popularité</button>
</div>

<!-- Sections de filtre -->
<div id="filter-date" class="filter-section">
    <form method="GET" action="">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars($date_filter); ?>">

        <!-- Sélecteur pour l'ordre de la date (croissant ou décroissant) -->
        <label for="order">Ordre :</label>
        <select name="order" id="order">
            <option value="asc" <?= isset($_GET['order']) && $_GET['order'] == 'asc' ? 'selected' : ''; ?>>
                Du plus ancien au plus récent
            </option>
            <option value="desc" <?= isset($_GET['order']) && $_GET['order'] == 'desc' ? 'selected' : ''; ?>>
                Du plus récent au plus ancien
            </option>
        </select>

        <button type="submit">Appliquer</button>
    </form>
</div>


<div id="filter-categorie" class="filter-section">
    <form method="GET" action="">
        <label for="categorie">Catégorie:</label>
       
        <select name="categorie" id="categorie">
        <option value="">Toutes</option>
    <option value="Conférence" <?= $categorie_filter == 'Conférence' ? 'selected' : ''; ?>>Conférence</option>
    <option value="Atelier" <?= $categorie_filter == 'Atelier' ? 'selected' : ''; ?>>Atelier</option>
    <option value="Webinaire" <?= $categorie_filter == 'Webinaire' ? 'selected' : ''; ?>>Webinaire</option>
    <option value="Séminaire" <?= $categorie_filter == 'Séminaire' ? 'selected' : ''; ?>>Séminaire</option>
    <option value="Festival" <?= $categorie_filter == 'Festival' ? 'selected' : ''; ?>>Festival</option>
    <option value="Concert" <?= $categorie_filter == 'Concert' ? 'selected' : ''; ?>>Concert</option>
    <option value="Fête" <?= $categorie_filter == 'Fête' ? 'selected' : ''; ?>>Fête</option>
    <option value="Mariage" <?= $categorie_filter == 'Mariage' ? 'selected' : ''; ?>>Mariage</option>
    <option value="Collecte de fonds" <?= $categorie_filter == 'Collecte de fonds' ? 'selected' : ''; ?>>Collecte de fonds</option>
    <option value="Hackathon" <?= $categorie_filter == 'Hackathon' ? 'selected' : ''; ?>>Hackathon</option>
    <option value="Exposition d'art" <?= $categorie_filter == 'Exposition d\'art' ? 'selected' : ''; ?>>Exposition d'art</option>
    <option value="Match sportif" <?= $categorie_filter == 'Match sportif' ? 'selected' : ''; ?>>Match sportif</option>
    <option value="Marathon" <?= $categorie_filter == 'Marathon' ? 'selected' : ''; ?>>Marathon</option>
    <option value="Retraite spirituelle" <?= $categorie_filter == 'Retraite spirituelle' ? 'selected' : ''; ?>>Retraite spirituelle</option>
    <option value="Marché local" <?= $categorie_filter == 'Marché local' ? 'selected' : ''; ?>>Marché local</option>
    <option value="Journée portes ouvertes" <?= $categorie_filter == 'Journée portes ouvertes' ? 'selected' : ''; ?>>Journée portes ouvertes</option>
    <option value="Spectacle en direct" <?= $categorie_filter == 'Spectacle en direct' ? 'selected' : ''; ?>>Spectacle en direct</option>

        </select>
        <button type="submit">Appliquer</button>
    </form>
</div>

<div id="filter-popularite" class="filter-section">
    <form method="GET" action="">
        <label for="popularite">Popularité:</label>
        <select name="popularite" id="popularite">
            <option value="">Toutes</option>
            <option value="Plus populaire" <?= $popularite_filter == 'Plus populaire' ? 'selected' : ''; ?>>Plus populaire</option>
            <option value="Moins populaire" <?= $popularite_filter == 'Moins populaire' ? 'selected' : ''; ?>>Moins populaire</option>
        </select>
        <button type="submit">Appliquer</button>
    </form>
</div>


<div id="events-container">
    <?php if (empty($evenements)): ?>
        <p>Aucun événement disponible.</p>
    <?php else: ?>
        <?php foreach ($evenements as $event): ?>
            <?php
            // Vérifier si l'utilisateur est déjà inscrit à cet événement
            $sql_check = "SELECT COUNT(*) FROM inscriptions WHERE user_id = ? AND event_id = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("ii", $user_id, $event['id']);
            $stmt_check->execute();
            $stmt_check->bind_result($is_registered);
            $stmt_check->fetch();
            $stmt_check->close();
            ?>

            <div class="event">
                <h3><?= htmlspecialchars($event['titre']); ?></h3>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($event['description'])); ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($event['date']); ?></p>
                <p><strong>Lieu:</strong> <?= htmlspecialchars($event['lieu']); ?></p>
                <p><strong>Inscriptions:</strong> <?= $event['inscriptions_count']; ?> personnes inscrites</p>

                <?php if ($event['image']): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($event['image']); ?>" alt="Image de l'événement">
                <?php else: ?>
                    <p>Aucune image disponible.</p>
                <?php endif; ?>

                <?php if ($event['user_id'] === $user_id): ?>
                    <a href="modifier_evenement.php?id=<?= $event['id']; ?>" class="btn-modifier">Modifier</a>
                    <!-- Formulaire pour supprimer l'événement -->
                    <!-- Formulaire de suppression -->
                    <form method="POST" action="supprimer_evenement.php" onsubmit="return confirmSuppression();">
    <input type="hidden" name="id" value="<?= $event['id']; ?>">
    <button type="submit" class="btn-supprimer">Supprimer</button>
</form>

<script>
    function confirmSuppression() {
        return confirm("Êtes-vous sûr de vouloir supprimer cet événement ?");
    }
</script>

                <?php elseif (!$is_registered): ?>
                    <!-- Afficher le bouton d'inscription seulement si l'utilisateur n'a pas créé l'événement et n'est pas inscrit -->
                    <form method="POST" action="inscrire_evenement.php" onsubmit="return confirmInscription(event)">
                        <input type="hidden" name="event_id" value="<?= $event['id']; ?>">
                        <button type="submit" class="btn-inscrire">S'inscrire</button>
                        
                    </form>
                <?php else: ?>
                    <p style="color: blue;">Vous êtes déjà inscrit à cet événement !</p>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function confirmInscription(event) {
        // Empêcher l'envoi immédiat du formulaire
        event.preventDefault();

        // Afficher la boîte de confirmation
        const confirmation = confirm("Êtes-vous sûr de vouloir vous inscrire à cet événement ?");

        if (confirmation) {
            // Si l'utilisateur confirme, soumettre le formulaire
            event.target.submit();
        } else {
            // Si l'utilisateur annule, ne rien faire
            alert("Inscription annulée.");
        }
    }
</script>

</body>
</html>


