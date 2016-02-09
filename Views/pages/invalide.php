<?php

if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}else{
    
    ?>

<h2>Ce lien n'est plus valide.<h2>

<p>Nous vous invitons à nous contacter via notre formulaire de contact pour plus d'information .</p>
<?php
}
?>