<?php
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Calendrier des randonnées
***************************************************************************/

// Récupération des randonnées pour le mois
echo "<script> var events = new Array(); </script>";
$listeRando = getRandonnees(date("d"), date("n"), date("Y"));

//Pour chaque randonnée, ajout d'une entrée dans un tableau JS
$x = 0;
while($ligne = mysql_fetch_array($listeRando)){
    $dateSepare = explode("-", $ligne[1]);
    $date = $dateSepare[1] . "/" . $dateSepare[2] . "/" . $dateSepare[0];
    echo '<script>events[' .$x .'] = {Title: "'. utf8_encode($ligne[3]) .'", 
            Date: "'. $date .'", DateFin: "'.$ligne[2].'", Genre: "'.$ligne[4].'",
            Id: '.$ligne[0].', Soustitre: "'. utf8_encode($ligne[5]) .'"};</script>';
    $x++;
}
?>
<script>
    //Page affichée
    $("document").ready(function(){
        //Affichage du calendrier
        $("div#calendrier").datepicker({
            beforeShowDay: function(date) {
                
                var result = [true, '', null];
                var matching = $.grep(events, function(event) {
                    var dateEvent = new Date(event.Date.valueOf());
                    return dateEvent.valueOf() == date.valueOf();
                });

                if (matching.length) {
                    result = [true, 'highlight', null];
                }
                return result;
            },
            onSelect: function(dateText) {
                
                var dateArray = dateText.split('.');
                
                var date,
                    selectedDate = new Date(dateArray[2], dateArray[1] - 1, dateArray[0]),
                    i = 0,
                    event = null;
                    
                // Determine if the user clicked an event: 
                while (i < events.length && !event) {
                    date = events[i].Date;

                    if (selectedDate.valueOf() === new Date(date).valueOf()) {
                        event = events[i];
                    }
                    i++;
                }
                if (event) {
                    /* If the event is defined, perform some action here; show a tooltip, navigate to a URL, etc. */
                    $("#detailsRando").html("<div id='infoRandonnee'><b>"  + event.Title + "</b></div>" +
                            "<br /><a rel='external' id='detailsButton' href='detailRandonnee.php?id=" + event.Id +
                            "'  data-role='button' data-inline='true' data-corners='true' data-shadow='true'" +
                            "data-iconshadow='true' data-wrapperels='span' data-theme='c'" +
                            "class='ui-btn ui-btn-inline ui-shadow ui-btn-corner-all ui-btn-up-c'>" +
                            "<span class='ui-btn-inner ui-btn-corner-all'><span class='ui-btn-text'>"+
                            "<?php echo $traductions['detailsRando'][$_SESSION['langue']] ?></span></a>");
                }
                else{
                    $("#detailsRando").html("");
                }
            }
        });

    });
</script>

<h2><?php echo $traductions['listeRando'][$_SESSION['langue']] ?></h2>

<a href="rechercheRando.php?propo=1" data-role="button" data-inline="true" data-mini="true" rel="external">
        <?php echo $traductions['rechercher'][$_SESSION['langue']] ?>
    <img src="../pictures/icons/loupe.png" style="height:30px;"/>
</a>
<a href="proximite.php?rando=1" data-role="button" data-inline="true" data-mini="true" rel="external">
        <?php echo $traductions['dansRegion'][$_SESSION['langue']] ?>
    <img src="../pictures/icons/gps.png" style="height:30px;"/>
</a>
<div id="calendrier">
    
</div>
<div id="info_calendrier">
    <span id="legende_calendrier"> &nbsp;&nbsp;&nbsp;&nbsp; </span> &nbsp;= <?php echo $traductions['jourRando'][$_SESSION['langue']] ?>
</div>
<h2><?php echo $traductions['parcoursJoursSelectionne'][$_SESSION['langue']] ?></h2>
<div id="detailsRando">
    
</div>