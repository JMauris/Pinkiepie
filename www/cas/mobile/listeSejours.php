<?php
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Affichage du calendrier des séjours
    ***************************************************************************/
    //récupération des randonnées pour le mois
    echo "<script> var eventsSej = new Array(); </script>";
    $listeRando = getSejours(date("d"), date("n"), date("Y"));
    
    //Pour chaque séjour, affichage dans le calendrier
    $x = 0;
    while($ligne = mysql_fetch_array($listeRando)){
        $dateSepare = explode("-", $ligne[1]);
        $date = $dateSepare[1] . "/" . $dateSepare[2] . "/" . $dateSepare[0];
        echo '<script>eventsSej[' .$x .'] = {Title: "'. utf8_encode($ligne[3]) .'", 
              Date: "'. $date .'", DateFin: "'.$ligne[2].'", Genre: "'.$ligne[4].'",
              Id: '.$ligne[0].', Soustitre: "'. utf8_encode($ligne[5]) .'"};</script>';
        $x++;
    }
?>
<script>
    //Page chargée
    $("document").ready(function(){
        $("div#calendrierSej").datepicker({
            beforeShowDay: function(date) {
                var result = [true, '', null];
                var matching = $.grep(eventsSej, function(event) {
                    var dateEvent = new Date(event.Date.valueOf());
                    return dateEvent.valueOf() == date.valueOf();
                });

                if (matching.length)
                    result = [true, 'highlight', null];
                return result;
            },
            onSelect: function(dateText) {
                
                var dateArray = dateText.split('.');
                
                var date,
                    selectedDate = new Date(dateArray[2], dateArray[1] - 1, dateArray[0]),
                    i = 0,
                    event = null;
                    
                //Determine if the user clicked an event: 
                while (i < eventsSej.length && !event) {
                    date = eventsSej[i].Date;

                    if (selectedDate.valueOf() === new Date(date).valueOf()) 
                        event = eventsSej[i];
                    
                    i++;
                }
                if (event) {
                    /* If the event is defined, perform some action here; show a tooltip, navigate to a URL, etc. */
                    $("#detailsSejour").html("<div id='infoRandonnee'><b>"  + event.Title + "</b></div>" +
                            "<br /><a rel='external' id='detailsButton' href='detailRandonnee.php?id=" + event.Id +
                            "&inscr=member'  data-role='button' data-inline='true' data-corners='true' data-shadow='true'" +
                            "data-iconshadow='true' data-wrapperels='span' data-theme='c'" +
                            "class='ui-btn ui-btn-inline ui-shadow ui-btn-corner-all ui-btn-up-c'>" +
                            "<span class='ui-btn-inner ui-btn-corner-all'><span class='ui-btn-text'>"+
                            "<?php echo $traductions['detailsSejour'][$_SESSION['langue']] ?></span></a>");   
                }
                else
                    $("#detailsSejour").html("");
            }
        });
    });
</script>

<h2><?php echo $traductions['listeSejours'][$_SESSION['langue']] ?></h2>

<a href="rechercheRando.php?propo=2" data-role="button" data-inline="true" data-mini="true" rel="external">
        <?php echo $traductions['rechercher'][$_SESSION['langue']] ?>
    <img src="../pictures/icons/loupe.png" style="height:30px;"/>
</a>
<a href="proximite.php?rando=2" data-role="button" data-inline="true" data-mini="true" rel="external">
        <?php echo $traductions['dansRegion'][$_SESSION['langue']] ?>
    <img src="../pictures/icons/gps.png" style="height:30px;"/>
</a>
<div id="calendrierSej">
    
</div>
<div id="info_calendrier">
    <span id="legende_calendrier"> &nbsp;&nbsp;&nbsp;&nbsp; </span> &nbsp;= <?php echo $traductions['jourSejour'][$_SESSION['langue']] ?>
</div>
<h2><?php echo $traductions['parcoursSejourSelectionne'][$_SESSION['langue']] ?></h2>
<div id="detailsSejour">
    
</div>