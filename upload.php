<?php
var_dump($_POST);
var_dump($_FILES);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_pic"])) {
    $uploadDir = "Dossier-dest/"; // Dossier spécifique où les fichiers seront sauvegardés

    $uploadedFile = $_FILES["profile_pic"];
    $fileName = basename($uploadedFile["name"]);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($uploadedFile["tmp_name"], $targetPath)) {
        echo "Le fichier a été téléchargé avec succès dans le dossier spécifique.";
    } else {
        echo "Une erreur s'est produite lors du téléchargement du fichier.";
    }
} else {
    echo "Erreur : Aucun fichier n'a été envoyé.";
}
?>
