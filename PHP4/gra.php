<?php
    session_start();

    if( !isset($_SESSION['zalogowany']) )
    {
        header('location: index.php');
        exit();
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy - gra przeglądarkowa</title>
</head>

<body>
   <?php
        echo "<p>Witaj ".$_SESSION['user'].'! [ <a href = "logout.php">Wyloguj się!</a> ]</p>';
        echo "<p><b>Drewno</b>: ".$_SESSION['drewno'];
        echo " | <b>Kamień</b>: ".$_SESSION['kamien'];
        echo " | <b>Zboże</b>: ".$_SESSION['zboze']."</p>";

        echo "<p><b>E-mail</b>: ".$_SESSION['email'];
        echo "<br /><b>Data wygaśnięcia premium</b>: ".$_SESSION['dnipremium']."</p>";
        
        $dataczas = new DateTime('2018-08-01 12:20:35');
        echo "<br\><br\> Data i czas serwera: ".$dataczas->format("Y-m-d H:i:s")."<br>";
        $koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);
        $roznica = $dataczas->diff($koniec);
        if($dataczas < $koniec)
            echo "Pozostało premium: ".$roznica->format('%y lat, %m mies, %d dni,
                                                        %h godz, %i min, %s sek');
        else
            echo "Premium nieaktywne od: ".$roznica->format('%y lat, %m mies, %d dni,
                                                            %h godz, %i min, %s sek');





        echo "<br/><br/><br/>Test użycia daty:";
        echo time()."<br/>";
        echo mktime(19, 37, 0, 4, 2, 2005)."<br/>";
        echo microtime()."<br/>";

        echo "<br/>";

        echo date('Y-m-d')."<br/>";
        echo date('d.m.Y')."<br/>";
        echo date('Y_d_m')."<br/>";
        echo date('Y-m-d H:i:s')."<br/>";
        echo date('Y_d_m H-i-s')."<br/>";

        $dataczas = new DateTime();
        echo $dataczas->format('Y-m-d H:i:s')."<br>";
        echo $dataczas->format('Y-m-d H:i:s').print_r($dataczas)."<br>";
        echo print_r($dataczas)."<br>";

        $dzien = 26;
        $miesiac = 7;
        $rok = 1875;

        if(checkdate($miesiac, $dzien, $rok) == true)
            echo "<br>Poprawna data!";
        else echo "<br>Niepoprawna data!";
?>
    
</body>

</html>