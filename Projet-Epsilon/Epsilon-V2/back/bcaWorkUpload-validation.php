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

// Vérification et création des répertoires nécessaires
if (!is_dir($idUser)) {
    mkdir($idUser, 0777);
}

if (isset($_GET['course']) && isset($_GET['challenge'])) {
    $nameOfDirForWork = $_GET['course'] . ' ' . $_GET['challenge'];
    $target_dir = $idUser . '/' . $nameOfDirForWork;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777);
    }
}

// Traitement de l'upload des fichiers
if (isset($_POST["submit"])) {
    if (isset($_FILES["fileToUpload"])) {
        $files = $_FILES["fileToUpload"];

        foreach ($files['tmp_name'] as $key => $tmp_name) {
            $target_file = $target_dir . '/' . basename($files["name"][$key]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Vérification si le fichier existe déjà
            if (file_exists($target_file)) {
                echo "Désolé, le fichier " . $files["name"][$key] . " existe déjà.<br>";
                $uploadOk = 0;
            }

            // Vérification de la taille du fichier
            if ($files["size"][$key] > 500000) {
                echo "Désolé, votre fichier " . $files["name"][$key] . " est trop gros.<br>";
                $uploadOk = 0;
            }

            // Vérification du format de fichier autorisé
            if (!in_array($imageFileType, array("jpg", "jpeg", "png", "gif", "pdf", "ppt", "pptx"))) {
                echo "Désolé, seuls les formats JPG, JPEG, PNG, GIF, PDF, PPT et PPTX sont autorisés pour " . $files["name"][$key] . ".<br>";
                $uploadOk = 0;
            }

            // Si tout est ok, tenter d'uploader le fichier
            if ($uploadOk == 1) {
                if (move_uploaded_file($files["tmp_name"][$key], $target_file)) {
                    echo "Le fichier " . htmlspecialchars(basename($files["name"][$key])) . " a été uploadé.<br>";
                } else {
                    echo "Désolé, il y a eu une erreur durant l'upload du fichier " . $files["name"][$key] . ".<br>";
                }
            }
        }
    }
}
?>

<h2>Upload du travail</h2>
<form action="bcaWorkUpload-validation.php<?php if (isset($_GET['course']) && isset($_GET['challenge'])) echo '?course=' . $_GET['course'] . '&challenge=' . $_GET['challenge']; ?>" method="post" enctype="multipart/form-data">
    Sélectionnez les fichiers à uploader (formats autorisés : JPG, JPEG, PNG, GIF, PDF, PPT, PPTX):
    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
    <?php if (isset($_GET['course']) && isset($_GET['challenge'])) : ?>
        <input type="hidden" name="course" value="<?= $_GET['course'] ?>">
        <input type="hidden" name="challenge" value="<?= $_GET['challenge'] ?>">
    <?php endif; ?>
    <input type="submit" value="Upload" name="submit">
</form>

<!-- Bouton pour afficher la liste des fichiers -->
<form action="liste-fichiers.php" method="get">
    <input type="submit" value="Afficher la liste">
</form>

<br>
<a href="index.php">Retour</a>
