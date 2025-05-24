<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tableau de bord</title>
    
</head>
<body>
        <style>
         body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f4f7fc; /* Light grayish background */
        }
        .container {
    width: 90%;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
        .menu {
            width: 250px;
            background-color: #4A007E; /* Deep violet */
            color: white;
            height: 100vh; /* Full height */
            padding: 20px;
            box-sizing: border-box;
        }
        .menu h2 {
            color: white;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 10px 0;
            padding: 12px;
            background-color: #4A007E; /* Lighter violet */
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .menu a:hover {
            background-color: #4A007E; /* Slightly brighter violet */
        }

        .content {
            flex: 1;
            padding: 30px;
            background-color: #ffffff; /* White background for content */
            margin-left: 20px;
            display: flex;
            justify-content: space-between; /* Aligns the stats box and pie chart horizontally */
            gap: 30px; /* Adds space between the boxes */
        }

        .stat-box {
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 8px;
    background-color: #f9f9f9;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    width: 200px; /* Fixed width for each stat box */
    height: 200px; /* Set a fixed height */
}


        .stat-box h3 {
            margin: 0;
            font-size: 18px;
            color: #4A007E; /* Deep violet */
        }

        .stat-box p {
            font-size: 18px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            font-size: 16px;
        }

        td {
            background-color: #fff;
            font-size: 14px;
            color: #555;
        }

        .btn {
            padding: 6px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
        }

        .btn.block {
    background-color: #FF5733; /* Nouveau rouge orangé */
}

.btn.block:hover {
    background-color: #C84B2C; /* Rouge plus foncé */
}

.btn.unblock {
    background-color: #28A745; /* Nouveau vert plus lumineux */
}

.btn.unblock:hover {
    background-color: #218838; /* Vert foncé */
}

.btn.delete {
    background-color: #D32F2F; /* Nouveau rouge plus vif */
}

.btn.delete:hover {
    background-color: #B71C1C; /* Rouge encore plus foncé */
}

        .btn.delete:hover {
            background-color: #e74c3c;
        }

        .no-users {
            font-size: 16px;
            color: #888;
            text-align: center;
        }

        form {
            display: inline-block;
        }

        form button {
            margin: 5px 0;
        }

        h2 {
            color: #6a1b9a;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .container table {
            border-radius: 8px;
            overflow: hidden;
        }

        .container table th {
            background-color: #6a1b9a;
            color: white;
            text-align: center;
        }

        .container table td {
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .container h2 {
            font-size: 24px;
            color: #6a1b9a;
            margin-bottom: 20px;
        }

        /* Style spécifique pour le graphique */
        .pie-chart {
            width: 400px;
            height: 600px;
           
        }
        .stat-box {
            width: 140px;
            height: 100px;
}

.content {
    flex-wrap: wrap; /* Permet de passer les blocs à la ligne si nécessaire */
}
.charts-container {
        display: flex;
        gap: 40px; /* Espace entre les deux conteneurs */
        flex-wrap: wrap; /* Permet de passer à la ligne si l'espace est limité */
        margin-top: 0px;
    }

    .chart-box {
        flex: 1; /* Les deux conteneurs prennent une largeur égale */
        max-width: 700px; /* Limite la largeur pour que les deux graphiques s'ajustent */
        height: 400px;
        background-color: #ffffff; /* Fond blanc */
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .chart-box canvas {
        width: 100%;
        height: 100%;
    }
    .btn.accept {
    background-color: #4CAF50; /* Vert */
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.accept:hover {
    background-color: #45a049;
}

.btn.reject {
    background-color: #f44336; /* Rouge */
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.reject:hover {
    background-color: #da190b;
}

    </style>
    <div class="menu">
        <h2>Menu Admin</h2>
        <a href="?page=stats">Voir les statistiques</a>
        <a href="?page=users">Liste des utilisateurs</a>
        <a href="?page=admins">Liste des administrateurs</a>
        <a href="?page=events">Liste des événements</a> 
        <a href="?page=inscrit">Liste des inscrits</a>
    </div>

    <div class="content">
        <?php
        // Informations de connexion à la base de données
        $host = 'localhost';
        $dbname = 'projettp';
        $username = 'root';
        $password = '';

        try {
            // Connexion à la base de données
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<p style='color: red;'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</p>");
        }

        // Vérifier la page demandée (par défaut : statistiques)
        $page = isset($_GET['page']) ? $_GET['page'] : 'stats';

        // Affichage des statistiques
        if ($page === 'stats') {
            // Récupérer le nombre total d'utilisateurs, d'administrateurs et d'événements
            $stmt = $pdo->query("SELECT COUNT(*) AS total_users FROM signuputi");
            $stmt2 = $pdo->query("SELECT COUNT(*) AS total_admins FROM signup");
            $stmt3 = $pdo->query("SELECT COUNT(*) AS total_events FROM submit_event");
            $stmt7 = $pdo->query("SELECT COUNT(*) AS total_inscrits FROM inscriptions");


        
            $totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
            $totalAdmins = $stmt2->fetch(PDO::FETCH_ASSOC)['total_admins'];
            $totalEvents = $stmt3->fetch(PDO::FETCH_ASSOC)['total_events'];
            $totalInsc = $stmt7->fetch(PDO::FETCH_ASSOC)['total_inscrits'];
        
            // Récupérer les catégories d'événements et leur nombre
            $stmt4 = $pdo->query("SELECT categorie, COUNT(*) AS total FROM submit_event GROUP BY categorie");
            $categories = [];
            $counts = [];
            while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $row['categorie'];
                $counts[] = $row['total'];
            }
            // Ajout d'une requête pour récupérer les noms des événements et leur nombre d'inscrits
            $stmt5 = $pdo->query("
            SELECT se.titre AS event_name, COUNT(i.event_id) AS user_count
            FROM submit_event se
            LEFT JOIN inscriptions i ON se.id = i.event_id
            WHERE se.status = 'accepté'
            GROUP BY se.id, se.titre
            ");
            $eventNames = [];
            $userCounts = [];
            while ($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                $eventNames[] = $row['event_name'];
                $userCounts[] = $row['user_count'];
            }
            // Récupérer les noms des utilisateurs et leur nombre d'événements créés
            $stmt6 = $pdo->query("
            SELECT su.nom AS user_name, COUNT(se.id) AS event_count
            FROM signuputi su
            LEFT JOIN submit_event se ON su.id = se.user_id
            GROUP BY su.id, su.nom
            ");

            $userNames = [];
            $userEventCounts = [];
            while ($row = $stmt6->fetch(PDO::FETCH_ASSOC)) {
            $userNames[] = $row['user_name'];
            $userEventCounts[] = $row['event_count'];
            }
            // Affichage des statistiques
            ?>
            <div class="stat-box">
                <h3>Total des utilisateurs:</h3>
                <p><?php echo $totalUsers; ?> </p>
              
            </div>
            <div class="stat-box">
                <h3>Total des administrateurs:</h3>
                <p><?php echo $totalAdmins; ?> </p>
            </div>
            <div class="stat-box">
                <h3>Total des événements:</h3>
                <p><?php echo $totalEvents; ?> </p>
            </div>
            <div class="stat-box">
                <h3>Total des inscrits aux événements:</h3>
                <p><?php echo $totalInsc; ?> </p>
            </div>
            <!-- Section pour le graphique -->
            <div class="stat-box" style="width: 250px; height: 250px;">
                <h3>Répartition des événements par catégorie :</h3>
                <canvas id="eventChart" ></canvas>
            </div>
       
            <div class="charts-container">
    <!-- Histogramme pour le nombre d'inscrits par événement -->
    <div class="chart-box">
        <h3>Nombre d'inscrits par événement :</h3>
        <canvas id="eventUserChart"></canvas>
    </div>

    <!-- Histogramme pour le nombre d'événements créés par utilisateur -->
    <div class="chart-box">
        <h3>Nombre d'événements créés par utilisateur :</h3>
        <canvas id="userEventChart"></canvas>
    </div>
</div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Données pour le graphique
                var ctx = document.getElementById('eventChart').getContext('2d');
                var eventChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($categories); ?>, // Les catégories d'événements
                        datasets: [{
                            label: 'Événements par catégorie',
                            data: <?php echo json_encode($counts); ?>, // Les nombres d'événements dans chaque catégorie
                            backgroundColor: [
                                '#FF5722', // Orange  
                                '#FFC107', // Jaune  
                                '#8BC34A', // Vert  
                                '#9C27B0', // Violet  
                                '#03A9F4', // Bleu vif  
                                '#E91E63', // Rose clair  
                                '#F44336', // Rouge vif  
                                '#607D8B', // Gris-bleu  
                                '#795548', // Brun  
                                '#00BCD4', // Bleu clair  
                                '#673AB7'  // Bleu-violet  

                            ],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' événement(s)';
                                    }
                                }
                            }
                        },
                        // Option pour ne pas conserver le rapport d'aspect
                        maintainAspectRatio: false
                    }
                });
                 // Données pour l'histogramme
    var ctx2 = document.getElementById('eventUserChart').getContext('2d');
    var eventUserChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($eventNames); ?>, // Noms des événements
            datasets: [{
                label: 'Nombre d\'inscrits',
                data: <?php echo json_encode($userCounts); ?>, // Nombre d'inscrits pour chaque événement
                backgroundColor: '#00bcd4', //bleu calair
                borderColor: '#00bcd4', // 
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Pas de légende nécessaire pour un histogramme simple
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' inscrit(s)';
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Événements'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nombre d\'inscrits'
                    },
                    beginAtZero: true
                }
            }
        }
    });
    // Données pour l'histogramme des événements créés par utilisateur
    var ctx3 = document.getElementById('userEventChart').getContext('2d');
    var userEventChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($userNames); ?>, // Noms des utilisateurs
            datasets: [{
                label: 'Nombre d\'événements créés',
                data: <?php echo json_encode($userEventCounts); ?>, // Nombre d'événements créés
                backgroundColor: '#e91e63', // Vert
                borderColor: '#e91e63', // Vert foncé
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Pas de légende nécessaire pour un histogramme simple
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' événement(s)';
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Utilisateurs'
                        
                        
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nombre d\'événements'
                    },
                    beginAtZero: true
                }
            }
        }
    });
            </script>
            <?php
}
        // Gestion des utilisateurs
        elseif ($page === 'users') {
            ?>
              <div class="container">
            <h2>Liste des utilisateurs inscrits</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
                $userId = (int) $_POST['user_id'];
                $action = $_POST['action'];

                if ($userId > 0) {
                    try {
                        switch ($action) {
                            case 'block':
                                $stmt = $pdo->prepare("UPDATE signuputi SET status = 'blocked' WHERE id = ?");
                                $stmt->execute([$userId]);
                                break;
                            case 'unblock':
                                $stmt = $pdo->prepare("UPDATE signuputi SET status = 'active' WHERE id = ?");
                                $stmt->execute([$userId]);
                                break;
                            case 'delete':
                                $stmt = $pdo->prepare("DELETE FROM signuputi WHERE id = ?");
                                $stmt->execute([$userId]);
                                break;
                        }
                        header("Location: " . $_SERVER['PHP_SELF'] . "?page=users");
                        exit;
                    } catch (PDOException $e) {
                        echo "<p style='color: red;'>Erreur lors de l'exécution : " . htmlspecialchars($e->getMessage()) . "</p>";
                    }
                }
            }

            // Affichage des utilisateurs
            $stmt = $pdo->query("SELECT id, nom, email, status FROM signuputi");

            if ($stmt->rowCount() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <?php if ($row['status'] === 'active'): ?>
                                            <button type="submit" name="action" value="block" class="btn block">Bloquer</button>
                                        <?php else: ?>
                                            <button type="submit" name="action" value="unblock" class="btn unblock">Débloquer</button>
                                        <?php endif; ?>
                                        <button type="submit" name="action" value="delete" class="btn delete">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-users">Aucun utilisateur trouvé.</p>
            <?php endif;
        }
        elseif ($page === 'admins') {
            // Liste des administrateurs
            ?>
              <div class="container">
            <h2>Liste des administrateurs inscrits</h2>
            <?php
            $stmt = $pdo->query("SELECT id, nom, email FROM signup");

            if ($stmt->rowCount() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-users">Aucun administrateur trouvé.</p>
            <?php endif;
        } 
        // Affichage des événements
        elseif ($page === 'events') {
            ?>
              <div class="container">
            <h2>Liste des événements</h2>
            <?php
            $stmt = $pdo->query("
                SELECT se.id, se.titre, se.description, se.date, se.lieu, se.image, se.status, se.categorie, su.nom AS user_name
                FROM submit_event se
                LEFT JOIN signuputi su ON se.user_id = su.id
            ");

            if ($stmt->rowCount() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Catégorie</th>
                            <th>Utilisateur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['titre']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['lieu']); ?></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Image événement" style="width: 100px; height: auto;">
                                    <?php else: ?>
                                        Pas d'image
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <?php if ($row['status'] === 'en attente'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="accepter">
                                            <button type="submit" class="btn accept">Accepter</button>
                                        </form>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="refuser">
                                            <button type="submit" class="btn reject">Refuser</button>
                                        </form>
                                    <?php else: ?>
                                        <?php echo ucfirst($row['status']); ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['categorie']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun événement trouvé.</p>
            <?php endif;
        }
        // Traitement de l'action Accepter ou Refuser
        if (isset($_POST['action']) && isset($_POST['event_id'])) {
            $action = $_POST['action'];
            $event_id = $_POST['event_id'];

            if ($action === 'accepter') {
                $status = 'accepté';
            } elseif ($action === 'refuser') {
                $status = 'refusé';
            }

            $stmt = $pdo->prepare("UPDATE submit_event SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $event_id);
            if ($stmt->execute()) {
                echo "<p>L'événement a été $status avec succès.</p>";
            } else {
                echo "<p>Erreur lors de la mise à jour de l'événement.</p>";
            }
        }

     
       
// Affichage des inscrits
elseif ($page === 'inscrit') {
    ?>
    <div class="container">
        <h2>Liste des événements avec utilisateurs inscrits</h2>

        <?php
        $stmt = $pdo->prepare("
            SELECT se.id AS event_id, se.titre AS event_title,
                   su.id AS creator_id, su.nom AS creator_name
            FROM submit_event se
            LEFT JOIN signuputi su ON se.user_id = su.id
            WHERE se.status = 'accepté'  -- Seuls les événements avec statut 'accepté'
        ");

        $stmt->execute();

        if ($stmt->rowCount() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Événement</th>
                        <th>Nom Événement</th>
                        <th>ID Créateur</th>
                        <th>Nom Créateur</th>
                        <th>Nom Inscrits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($event = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_id']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_title']); ?></td>
                            <td><?php echo htmlspecialchars($event['creator_id']); ?></td>
                            <td><?php echo htmlspecialchars($event['creator_name']); ?></td>
                            <td>
                                <?php
                                // Liste des inscrits
                                $event_id = $event['event_id'];
                                $user_stmt = $pdo->prepare("
                                    SELECT si.id AS user_id, si.nom AS user_name
                                    FROM inscriptions i
                                    LEFT JOIN signuputi si ON i.user_id = si.id
                                    WHERE i.event_id = :event_id
                                ");
                                $user_stmt->bindParam(':event_id', $event_id);
                                $user_stmt->execute();

                                $users = [];
                                while ($user = $user_stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $users[] = htmlspecialchars($user['user_name']) . " (ID: " . htmlspecialchars($user['user_id']) . ")";
                                }

                                if (count($users) > 0) {
                                    echo implode("<br>", $users); // Afficher la liste des inscrits
                                } else {
                                    echo "Aucun utilisateur inscrit";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun événement avec le statut 'accepté' trouvé.</p>
        <?php endif; ?>
    </div>
    <?php
}
?>


</body>
</html>
        

