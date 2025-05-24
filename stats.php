<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'projettp';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour obtenir les statistiques
    $userCount = $pdo->query("SELECT COUNT(*) AS total FROM signuputi")->fetch(PDO::FETCH_ASSOC)['total'];
    $adminCount = $pdo->query("SELECT COUNT(*) AS total FROM signup")->fetch(PDO::FETCH_ASSOC)['total'];
    $eventCount = $pdo->query("SELECT COUNT(*) AS total FROM submit_event")->fetch(PDO::FETCH_ASSOC)['total'];

    // Requête pour obtenir la répartition des catégories d'événements
    $categoriesQuery = $pdo->query("SELECT categorie, COUNT(*) AS total FROM submit_event GROUP BY categorie");
    $categoriesData = $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<div id="stats-section">
    <h1>Statistiques du Dashboard</h1>
    
    <div class="stats-container">
        <div class="stat-card">
            <h2>Utilisateurs</h2>
            <p id="userCount"><?php echo $userCount; ?></p>
        </div>
        <div class="stat-card">
            <h2>Administrateurs</h2>
            <p id="adminCount"><?php echo $adminCount; ?></p>
        </div>
        <div class="stat-card">
            <h2>Événements</h2>
            <p id="eventCount"><?php echo $eventCount; ?></p>
        </div>
    </div>
    
    <div class="chart-container">
        <canvas id="statsChart"></canvas>
        <canvas id="categoryChart"></canvas>
    </div>
</div>

<script>
    // Injection des données PHP dans JavaScript
    const userCount = <?php echo $userCount; ?>;
    const adminCount = <?php echo $adminCount; ?>;
    const eventCount = <?php echo $eventCount; ?>;

    // Données des catégories d'événements
    const categoryData = <?php echo json_encode($categoriesData); ?>;
    const categoryLabels = categoryData.map(item => item.categorie);
    const categoryCounts = categoryData.map(item => item.total);

    // Chart.js pour afficher les statistiques
    const ctx = document.getElementById('statsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Utilisateurs', 'Administrateurs', 'Événements'],
            datasets: [{
                label: 'Statistiques',
                data: [userCount, adminCount, eventCount],
                backgroundColor: ['#2ecc71', '#3498db', '#e74c3c']
            }]
        }
    });

    // Chart.js pour les catégories d'événements
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCategory, {
        type: 'pie',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryCounts,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40']
            }]
        }
    });
</script>
