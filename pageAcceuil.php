<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQ8yP/3u2l4ecf3KsU7PY0Fg5TCnhPB4pTrAS0eM9z27MUpjKl23QBiBs" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Plateforme de Gestion d'Événements</title>
   

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Barre de navigation -->
    <header>
        <nav class="navbar">
            <div class="logo">DreamEvent</div>
            <ul class="nav-links">
                <li><a href="#">Accueil</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#temoignages">temoignages</a></li>

                <li><a href="#contact">Contactez-nous</a></li>
                <li><a href="#aboutUs">Qui sommes-nous</a></li>

            </ul>
            <a href="verification.html" id="connect-btn" class="btn-inscription">Se connecter</a> <!-- Clic pour afficher la vérification -->

        </nav>
<!-- Conteneur dynamique pour afficher verification.html -->
    <div id="verification-container" style="display:none;">
        <!-- Le contenu de verification.html sera chargé ici -->
    </div>
        <!-- Bannière principale -->
        <div class="main-banner">
            <h1>Organisez des événements mémorables avec DreamEvent</h1>
            <p>La plateforme ultime pour gérer vos événements en ligne.</p>
            
        </div>
    </header>

    <!-- Section Services -->
    <section id="services" class="services-section">
        
        <section>
            <h2>Nos Services</h2>
            <div class="service-grid">
                <div class="service-item">
                    <img src="https://openui.fly.dev/openui/24x24.svg?text=📝" alt="Icône Planification" class="service-icon">
                    <h2>Planifiez votre événement</h2>
                    <p>Simplifiez votre planification et préparez-vous au succès.</p>
                </div>
                <div class="service-item">
                    <img src="https://openui.fly.dev/openui/24x24.svg?text=👥" alt="Icône Développement" class="service-icon">
                    <h2>Développez votre événement</h2>
                    <p>Maintenir le contact et l'engagement pour une croissance continue.</p>
                </div>
            
                <div class="service-item">
                    <img src="https://openui.fly.dev/openui/24x24.svg?text=📣" alt="Icône Promotion"alt="Icône Répertoire" class="service-icon">
                    <h2>Répertoire des participants</h2>
                    <p>Gardez un registre organisé pour vos participants.</p>
                </div>
                
        </section>
        
    <!-- Section Témoignages -->

    <?php
    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'projettp';
    $username = 'root';
    $password = '';
    
    // Connexion à la base de données avec mysqli
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }
    
    // Récupérer les témoignages depuis la base de données
    $sql = "SELECT name, role, message,rating FROM temoignages ORDER BY id DESC";
    $result = $conn->query($sql);
    ?>
    
    <section id="temoignages" class="testimonial-section">
        <h2>Témoignages</h2>
        <div class="testimonial-wrapper">
            <button class="arrow left" onclick="scrollTestimonials('left')">&#8249;</button>
            <div id="testimonial-container" class="testimonial-container">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="testimonial">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    if (!empty($row['role'])) {
                        echo '<p class="role">' . htmlspecialchars($row['role']) . '</p>';
                    }
                    echo '<p class="message">' . htmlspecialchars($row['message']) . '</p>';
                    echo '<div class="stars">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $row['rating']) {
                            echo '<span class="star filled">&#9733;</span>';
                        } else {
                            echo '<span class="star">&#9733;</span>';
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun témoignage pour le moment. Soyez le premier à écrire un avis !</p>';
            }
            ?>
        
    <button class="arrow right" onclick="scrollTestimonials('right')">&#8250;</button>
    </section>
    
    
    <?php
    // Fermer la connexion
    $conn->close();
    ?>
    

    <!-- Section Contactez-nous -->
<section id="contact" class="contact-section">
    <h2>Contactez-nous</h2>
    <div class="contact-info">
        <p>📧 Email : <a href="mailto:contact@dreamevent.com">contact@dreamevent.com</a></p>
        <p>📞 Téléphone : <a href="tel:+33123456789">+216 23 567 189</a></p>
    </div>
</section>

    <!-- Section Qui sommes-nous -->
<section id="aboutUs" class="about-section">
    <h2>Qui sommes-nous ?</h2>
    <div class="about-content">
        <p>
            Chez <strong>DreamEvent</strong>, nous croyons que chaque événement mérite d’être unique et mémorable. 
            Notre mission est de simplifier l’organisation d’événements tout en offrant des solutions innovantes pour répondre à vos besoins spécifiques.
        </p>
        <p>
            Forts d’une équipe passionnée et expérimentée, nous accompagnons entreprises, associations et particuliers dans la réalisation de leurs projets événementiels, qu’ils soient professionnels ou privés.
        </p>
        <p>
            Rejoignez-nous pour transformer vos idées en expériences inoubliables !
        </p>
    </div>

    <!-- Ajout de la présentation du fondateur -->
    <div class="founder-section">
        <img src="yomna2.jpg" alt="Photo du fondateur" class="founder-photo">
        <div class="founder-info">
            <h3>Yomna Jlassi</h3>
            <p>
                Yomna Jlassi, le fondatrice de <strong>DreamEvent</strong>, est une passionnée d’événementiel avec plus de 1 ans 
                d’expérience dans le domaine. Sa vision est de rendre chaque événement exceptionnel et accessible grâce à la technologie moderne.
            </p>
        </div>
  
</section>


<script>
    // Liste des images à utiliser
    const images = [
        'party1.jpeg',
        'party2.jpeg',
        'party3.jpeg',
        'party4.jpeg'
    ];

    // Sélectionner l'élément avec la classe .main-banner
    const mainBanner = document.querySelector('.main-banner');

    // Index de la première image
    let currentImageIndex = 0;

    // Fonction pour changer l'image de fond
    function changeBackground() {
        // Incrémente l'index de l'image actuelle
        currentImageIndex = (currentImageIndex + 1) % images.length;
        // Change l'image de fond
        mainBanner.style.backgroundImage = `url(${images[currentImageIndex]})`;
    }

    // Changer l'image toutes les 3 secondes (3000 millisecondes)
    setInterval(changeBackground, 3000);

    // Définir l'image de fond initiale
    mainBanner.style.backgroundImage = `url(${images[currentImageIndex]})`;
    function scrollTestimonials(direction) {
    const container = document.getElementById('testimonial-container');
    const scrollAmount = 300; // Ajustez cette valeur pour le défilement
    if (direction === 'left') {
        container.scrollLeft -= scrollAmount;
    } else if (direction === 'right') {
        container.scrollLeft += scrollAmount;
    }
}
</script>

</body>
<style>
/* Style général */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f4f4f4; /* Fond doux pour éviter un contraste trop agressif */
    color: #333; /* Texte dans une teinte sombre lisible */
    line-height: 1.6;
}

/* Barre de navigation */
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

.nav-links {
    list-style: none;
    display: flex;
    gap: 1.5rem;
}

.nav-links li a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.nav-links li a:hover {
    color: #ff007a;
}

/* Bouton d'inscription */
.btn-inscription {
    background-color: #ff007a;
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 20px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-inscription:hover {
    background-color: #d40062;
}

/* Bannière principale */
.main-banner {
    height: 80vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    text-align: right;
    color: white;
    padding: 0 3rem;
    background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3)),
        url('banner.jpg') center/cover no-repeat;
}

.main-banner h1 {
    font-size: 3.5rem;
    font-weight: bold;
    text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.7);
}

.main-banner p {
    font-size: 1.5rem;
    margin: 1.5rem 0;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
}

.btn-principal {
    background-color: #ff007a;
    color: white;
    padding: 1rem 2rem;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-principal:hover {
    background-color: #d40062;
}

/* Section Services */
.services-section {
    padding: 4rem 2rem;
    background-color: #ffffff;
    text-align: center;
}

.services-section h2 {
    font-size: 2.5rem;
    margin-bottom: 2.5rem;
    color: #4A007E;
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.service-item {
    background-color: #f9f9f9;
    padding: 2rem;
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.1);
}

.service-item:hover {
    transform: translateY(-10px);
    box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.2);
}

.service-item i {
    font-size: 3rem;
    color: #4A007E;
    margin-bottom: 1rem;
}

.service-item h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #333;
}

.service-item p {
    color: #555;
    font-size: 1rem;
    line-height: 1.5;
}

/* Section Témoignages */
.testimonials-section {
    
    padding: 4rem 2rem;
    background-color: #4A007E;
    color: white;
    text-align: center;
}

.testimonials-section h2 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
}

.testimonial-wrapper {
    
    display: flex;
    position: relative;
}

.testimonial-container {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.3s ease;
}

.testimonial {
    flex: 0 0 30%;
    background-color: #ffffff;
    color: #333;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.testimonial h3 {
    margin: 0;
    font-size: 1.25rem;
}

.testimonial .role {
    font-style: italic;
    color: #666;
}

.testimonial .message {
    margin-top: 1rem;
    color: #555;
}
/* Style des étoiles dans les témoignages */
.stars {
    display: flex;
    justify-content: center; /* Centrer les étoiles horizontalement */
    align-items: center; /* Aligner les étoiles verticalement */
    margin-top: 10px;
}

.star {
    font-size: 1.3em; /* Taille des étoiles augmentée */
    color: #ccc; /* Couleur des étoiles non remplies */
    margin: 0 3px; /* Espacement entre les étoiles */
}

.star.filled {
    color: #f5c518; /* Couleur des étoiles remplies */
}
/* Boutons fléchés */
.arrow {
    background-color: #ff007a;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.arrow.left {
    left: 10px;
}

.arrow.right {
    right: 10px;
}

.arrow:hover {
    background-color: #d40062;
}

/* Section Contact */
.contact-section {
    padding: 4rem 2rem;
    background-color: #ffffff;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.contact-section h2 {
    font-size: 2.5rem;
    color: #4A007E;
    margin-bottom: 2rem;
}

/* */

/* Footer */
footer {
    background-color: #d3beec;
    color: white;
    text-align: center;
    padding: 2rem 0;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 2rem;
}

.footer-content p {
    margin-bottom: 0;
}

.socials {
    list-style: none;
    display: flex;
    gap: 1rem;
}

.socials li a {
    color: white;
    font-size: 1.5rem;
    transition: color 0.3s ease;
}

.socials li a:hover {
    color: #3c78e7;
}
.contact-section {
    padding: 4rem 2rem;
    background-color: #fff; /* Couleur de fond blanche */
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre pour démarquer */
    margin: 2rem 0;
    border-radius: 10px;
}

.contact-section h2 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
    color: #6e0eb2; /* Couleur pour correspondre au thème */
}

.contact-info p {
    font-size: 1.5rem;
    margin: 1rem 0;
    color: #555;
}

.contact-info a {
    color: #6e0eb2;
    text-decoration: none;
    font-weight: bold;
}

.contact-info a:hover {
    text-decoration: underline;
}
.founder-section {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-top: 3rem;
    text-align: left;
    justify-content: center;
}

.founder-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%; /* Rendre l'image circulaire */
    object-fit: cover;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Ajouter une ombre subtile */
    border: 3px solid #6e0eb2; /* Bordure colorée */
}

.founder-info {
    max-width: 600px;
}

.founder-info h3 {
    font-size: 1.8rem;
    color: #6e0eb2;
    margin-bottom: 1rem;
}

.founder-info p {
    font-size: 1.2rem;
    color: #555;
    line-height: 1.6;
}

</style>

</html>