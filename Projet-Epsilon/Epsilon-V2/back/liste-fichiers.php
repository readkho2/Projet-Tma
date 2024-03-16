<?php
// Inclusion du header
include('header.php');

// Vérification de la connexion
$isConnected = (isset($_COOKIE['mail']) || isset($_SESSION['mail'])) ? true : false;

if ($isConnected) {
    include('bcaAccessCodeSystem.php');
}

// Fonction pour obtenir l'ID de l'utilisateur
function getIdUser()
{
    global $mail;
    require('env.php'); // Inclusion des informations de configuration
    try {
        // Définition des variables de connexion
        global $hostname, $dbname, $username, $password;

        $db = new PDO('mysql:host=' . $hostname . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $select = $db->prepare('SELECT id FROM user WHERE mail=:mail');
        $select->bindParam(':mail', $mail, PDO::PARAM_STR);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);
        return $result['id'] ?? 'erreur req';
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return 'erreur req';
    }
}

// Obtention de l'ID de l'utilisateur
$idUser = getIdUser();

// Chemin vers le répertoire des fichiers de l'utilisateur
$userDirectory = $idUser . '/';

// Liste des fichiers dans le répertoire de l'utilisateur
$files = scandir($userDirectory);

// Affichage de la liste des fichiers
if (count($files) > 2) { // Vérifie s'il y a des fichiers (la fonction scandir renvoie '.' et '..' en plus des fichiers)
    echo "<h2>Liste des fichiers téléchargés :</h2>";
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>Aucun fichier téléchargé.</p>";
}

?>

<br>
<a href="index.php">Retour</a>
