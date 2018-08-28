<?php
    session_start();

    if (isset($_POST['email']))
    {
       //Udana walidacja? Załóżmy, że tak!
       $wszystko_OK = true;

       //Sprawdź poprawność nickname'a
       $nick = $_POST['nick'];

       //Sprawdzenie długości nicka
       if ((strlen($nick) < 3) || (strlen($nick) > 20))
       {
           $wszystko_OK = false;
           $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";
       }

       if ( ctype_alnum($nick) == false )
       {
            $wszystko_OK = false;
            $_SESSION['e_nick'] = "Nick może się składać tylko z liter i cyfr (bez polskich znaków)";
       }


       //Sprawdź poprawność adresu email
       $email = $_POST['email'];
       $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
       
       if ( (filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email) )
       {
           $wszystko_OK = false;
           $_SESSION['e_email'] = "Podaj poprawny adres email";
       }

       
       //Sprawdź poprawność hasła
       $haslo1 = $_POST['haslo1'];
       $haslo2 = $_POST['haslo2'];
       
       if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20))
       {
           $wszystko_OK = false;
           $_SESSION['e_haslo1'] = "Hasło musi posiadać od 8 do 20 znaków!";
       }

       if ($haslo1 != $haslo2)
       {
            $wszystko_OK = false;
            $_SESSION['e_haslo2'] = "Oba hasła muszą być identyczne";
       }

       $haslo_hash =  password_hash($haslo1, PASSWORD_DEFAULT);
       
       

       //Czy zaakceptowano regulamin
       if (!isset($_POST['regulamin']))
       {
            $wszystko_OK = false;
            $_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu";
       }



       //Bot or not? Oto jest pytanie
       $sekret = "6LczVmwUAAAAAEwA8hOrlTAh5ogzTuL9X3vrO8jH";
       $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='
                                    .$sekret.'&response='.$_POST['g-recaptcha-response']);
       $odpowiedz = json_decode($sprawdz);
       if ($odpowiedz->success == false)
       {
            $wszystko_OK = false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";           
       }


       require_once "connect.php";
       mysqli_report(MYSQLI_REPORT_STRICT);

       try
       {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno != 0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else {
                //Czy email już istnieje?
                $rezultat = $polaczenie-> query("SELECT id FROM uzytkownicy WHERE email='$email'");
                if(!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili > 0)
                {
                    $wszystko_OK = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail";
                }

                $polaczenie->close();
            }
       }
       catch(Exception $e)
       {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności '
                .'i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska '.$e;
       }

       if($wszystko_OK == true)
       {
           //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
           echo "Udana walidacja!";
           exit();
       }
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Osadnicy - załóż darmowe konto</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
        .error
        {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
    </style>
</head>

<body>
    <form method="POST">
        Nickname: <br /> <input type="text" name="nick"/> <br />
        <?php
            if (isset($_SESSION['e_nick']))
            {
                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                unset($_SESSION['e_nick']);
            }
        ?>

        E-mail: <br /> <input type="text" name="email"/> <br />
        <?php
            if (isset($_SESSION['e_email']))
            {
                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
        ?>
        
        Hasło: <br /> <input type="password" name="haslo1"/> <br />
        <?php
            if (isset($_SESSION['e_haslo1']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo1'].'</div>';
                unset($_SESSION['e_haslo1']);
            }
        ?>

        Powtórz hasło: <br /> <input type="password" name="haslo2"/> <br />
        <?php
            if (isset($_SESSION['e_haslo2']))
            {
                echo '<div class="error">'.$_SESSION['e_haslo2'].'</div>';
                unset($_SESSION['e_haslo2']);
            }
        ?>

        <label>
            <input type="checkbox" name="regulamin"/> Akceptuję regulamin
        </label>
        <?php
            if (isset($_SESSION['e_regulamin']))
            {
                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                unset($_SESSION['e_regulamin']);
            }
        ?>

        <div class="g-recaptcha" data-sitekey="6LczVmwUAAAAAAWs9_nWo5qWzLmFo7QBUlagI6y_"></div>
        <?php
            if (isset($_SESSION['e_bot']))
            {
                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                unset($_SESSION['e_bot']);
            }
        ?>



        <input type="submit" value="Zarejestruj się" />
    </form>
    
</body>

</html>