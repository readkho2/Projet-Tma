<?php
// Inclusion du header
include('header.php');

// Vérification de la connexion
$isConnected = (isset($_COOKIE['mail']) || isset($_SESSION['mail'])) ? true : false;

if($isConnected) {
    include('bcaAccessCodeSystem.php');
}

// Définition des travaux
$work = array();
$work[0][2] = 'Exemple de travaux 1';
$work[2][4] = 'Exemple de travaux 2';

// Récupération du parcours et du challenge depuis l'URL
$course = isset($_GET['course']) ? 'course'.$_GET['course'] : '';
$challenge = isset($_GET['challenge']) ? 'rank'.$_GET['challenge'] : '';

// Affichage des informations sur le travail
echo '<h2>Description du travail</h2>';
if ($course !== '' && $challenge !== '' && isset($work[$_GET['course']][$_GET['challenge']])) {
    echo '<strong>Parcours actuel</strong> : '.$$course.'<br>';
    echo '<strong>Challenge visé</strong> : '.$$challenge.'<br>';
    echo '<strong>Défi demandé</strong> : <u>'.$work[$_GET['course']][$_GET['challenge']].'</u><br><br>';
} else {
    echo 'Parcours ou challenge non défini.<br><br>';
}

// Formulaire d'upload du travail
?>
<h2>Upload du travail</h2>
<form action="bcaWorkUpload-validation.php<?php if(isset($_GET['course']) && isset($_GET['challenge'])) echo '?course='.$_GET['course'].'&challenge='.$_GET['challenge']; ?>" method="post" enctype="multipart/form-data">
    Sélectionnez les fichiers à uploader (formats autorisés : JPG, JPEG, PNG, GIF, PDF, PPT, PPTX) :
    <input type="file" name="filesToUpload[]" id="filesToUpload" multiple>
    <?php if(isset($_GET['course']) && isset($_GET['challenge'])): ?>
    <input type="hidden" name="course" value="<?=$_GET['course'] ?>">
    <input type="hidden" name="challenge" value="<?=$_GET['challenge'] ?>">
    <?php endif; ?>
    <input type="submit" value="Upload" name="submit">
</form>

<h2>Liste des fichiers par module</h2>
<?php
// Vérification de l'existence du répertoire cible
$target_dir = isset($idUser) && isset($nameOfDirForWork) ? $idUser.'/'.$nameOfDirForWork : '';

if($target_dir !== '' && is_dir($target_dir)) {
    // Modules
    $modules = array(
        'Programmation',
        'Base de données',
        'Développement Web',
        'Systèmes d\'exploitation',
        'Réseaux et Sécurité'
    );

    // Parcours de chaque module
    foreach($modules as $module) {
        // Chemin du répertoire du module
        $module_dir = $target_dir . '/' . $module;

        // Vérification de l'existence du répertoire du module
        if(is_dir($module_dir)) {
            echo '<h3>' . $module . '</h3>';
            // Obtention de la liste des fichiers dans le répertoire du module
            $files = scandir($module_dir);
            
            // Affichage de la liste des fichiers
            foreach($files as $file) {
                // Exclure les fichiers . et ..
                if($file != '.' && $file != '..') {
                    echo $file . '<br>';
                }
            }
        }
    }
} else {
    echo "Aucun fichier trouvé.";
}

// Lien de retour
echo '<br><a href="index.php">Retour</a>';
?>
