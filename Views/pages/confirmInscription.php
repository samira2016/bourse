<?php


if (isset($_SESSION['success'])) {
    echo'<p class="bg-success">' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo'<p class="bg-danger">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
if (isset($_GET['id']) && isset($_GET['token'])) {
    $id = $_GET['id'];
    $token = $_GET['token'];
    ?>
    <h4>Confirmation d'inscription</h4>
    
    
    
    <P>Afin de confirmer votre inscription veuillez cliquer sur ce lien
        <a href="index.php?p=confirmer&id=<?= $id ?>&token=<?= $token ?>" >Confirmation inscription</a>
    <?php
}
?>