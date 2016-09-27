<?PHP
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Inscriptions d'une personne
***************************************************************************/
    
//Récupération de toutes les randonnées auxquelles l'utilisateur est inscrit
$listeRandonnees = listeRandonneesPourPersonne($personne->id);

$nb1 = mysql_num_rows($listeRandonnees[0]);
$nb2 = mysql_num_rows($listeRandonnees[1]);
?>
<h3><?php echo $traductions['a_venir'][$_SESSION['langue']] ?></h3>
<?php if($nb1 > 0){ 

        echo $traductions['desinscriptionAide'][$_SESSION['langue']];
?>
<table>
   <tr>
       <th><?php echo $traductions['date'][$_SESSION['langue']] ?></th>
       <th><?php echo $traductions['titre'][$_SESSION['langue']] ?></th>
   </tr>
    <?php
        $aVenir = $listeRandonnees[0];
        //Création d'un tableau avec la liste des inscriptions d'une personne
        $x = 0;
        while($ligne = mysql_fetch_array($aVenir)){
            if($x%2 == 0)
                echo "<tr>";
            else
                echo "<tr style='background-color:#F6CE2B;'>";
            
            $date = $ligne[1];
            $date = explode("-", $date);
            echo "<td>$date[2].$date[1].$date[0]</td>"; 
            echo "<td><a href='detailRandonnee.php?id=$ligne[2]&inscription=false' data-ajax='false'>" . utf8_encode($ligne[0]) . "</a></td>";
            $x++;

            echo "</tr>";
        }
    ?>
</table>
<?php
}
else{
   echo $traductions['aucuneInscription'][$_SESSION['langue']];
}
?>
<h3><?php echo $traductions['passe'][$_SESSION['langue']] ?></h3>
<?php if($nb2 > 0){ ?>
<table>
   <tr>
       <th><?php echo $traductions['date'][$_SESSION['langue']] ?></th>
       <th><?php echo $traductions['titre'][$_SESSION['langue']] ?></th>
   </tr>
    <?php
        $passe = $listeRandonnees[1];
        //Création d'un tableau avec les inscriptions passées d'un membre
        $x = 0;
        while($ligne = mysql_fetch_array($passe)){
            if($x%2 == 0)
                echo "<tr>";
            else
                echo "<tr style='background-color:#F6CE2B;'>";
            $date = $ligne[1];
            $date = explode("-", $date);
            echo "<td>$date[2].$date[1].$date[0]</td>"; 
            echo "<td><a href='detailRandonnee.php?id=$ligne[2]'>" . utf8_encode($ligne[0]) . "</a></td>";
            $x++;
            echo "</tr>";
        }
        ?>
    </table>
<?php
}
else{
   echo $traductions['aucuneInscription'][$_SESSION['langue']];
}
?>
