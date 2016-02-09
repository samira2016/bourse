<?php

//les niveaux d'access aux site 
return array(
    '0'=>'nouveau compte ',//nouveau inscrit pas encore validé par l'administrateur 
    
    '1'=>'intermediaire',//validé par l'adminstrateur peut reserver un ordre ou vente d'action et passer les ordres
    '2'=>'representant',//enregistre modifie les données de sa societe
    '-1'=>'compte supprime',//par l'adminstrateur ou par l'utilisateur lui meme se desinscrire
    '9'=>'administrateur'//enregistre un nouveau utilisateur societe  /change les droits 
    
);
?>
