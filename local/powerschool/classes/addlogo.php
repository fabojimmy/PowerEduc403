<?php
   require_once(__DIR__ . '/../../../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si le formulaire a été soumis
    if (isset($_POST['submit'])) {
        // Vérifiez si un fichier a été téléchargé
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === 0) {
            // Obtenez les informations du fichier
            $nomFichier = $_FILES['fichier']['name'];
            $typeFichier = $_FILES['fichier']['type'];
            $tailleFichier = $_FILES['fichier']['size'];
            $fichierTemporaire = $_FILES['fichier']['tmp_name'];
            
            // Déterminez l'emplacement où vous souhaitez stocker le fichier téléchargé
            $emplacement = $CFG->dirroot .'/local/powerschool/logo/' ;
            $emplacement1 = $CFG->wwwroot .'/local/powerschool/logo/' ;
            // var_dump($nomFichier, $typeFichier, $tailleFichier,$fichierTemporaire,$emplacement);die;

            // Vous pouvez également générer un nom de fichier unique pour éviter les conflits de noms
            // $nomFichierUnique = uniqid() . '_' . $nomFichier;

            // Déplacez le fichier téléchargé vers l'emplacement souhaité
            if (move_uploaded_file($fichierTemporaire, $emplacement . $nomFichier)) {
                // Le fichier a été téléchargé avec succès, vous pouvez maintenant faire ce que vous voulez avec le fichier

                // Par exemple, affichez le nom du fichier et l'image téléchargée
                $logo = new stdClass();
                $logo->id=$_POST["campus"];
                // var_dump($_POST["campus"]);die;
                $logo->logocampus=$emplacement1. $nomFichier;
                $DB->update_record("campus",$logo);
                echo '<h2>Fichier téléchargé :</h2>';
                echo '<p>Nom du fichier : ' . $nomFichier . '</p>';
                echo '<img src="' . $emplacement1 . $nomFichier . '" alt="Image téléchargée">';
            } else {
                $erreur = error_get_last();
                var_dump($erreur);die;
                echo "Erreur lors du téléchargement du fichier.";
            }
        } else {
            echo "Aucun fichier téléchargé.";
        }
    }
}
?>
