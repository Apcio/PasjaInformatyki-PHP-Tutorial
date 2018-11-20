<?php
    //funkcja pozwala korzystać z tablicy asocjacyjnej
    session_start();

    if( !isset($_POST['login']) || !isset($_POST['haslo']))
    {
        header('location: index.php');
        exit();
    }

    require_once "connect.php";
    
    try {    
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) throw new Exception("Error: ".$polaczenie->connect_errno); 
    }
    catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera!<br/><br/>'.$e.'</span>';
        exit();
    }
  
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    //echo "it Works!";
    //$sql = "SELECT * FROM uzytkownicy WHERE user = '$login' AND pass = '$haslo'";
    //dla lepszej czytelności można użyć sprintf, aby łączyć większą ilość zmiennych do SQLa
    //te funkcje mysqli pozwalają zabezpieczyć zapytanie przed próbą wstrzykiwania SQL
    if ($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownicy WHERE user = '%s'",
        mysqli_real_escape_string($polaczenie, $login)
        )
    ))
    {
        $ilu_userow = $rezultat->num_rows;
        if ($ilu_userow > 0)
        { 
            $wiersz = $rezultat->fetch_assoc();

            if (password_verify($haslo, $wiersz['pass']))
            {
                $_SESSION['zalogowany'] = true;
                $_SESSION['id'] = $wiersz['id'];

                //Globalna tablica asocjacyjna, dla danej sesji. Pozwala na przesyłanie zmiennych między
                //plikami php 
                $_SESSION['user'] = $wiersz['user'];
                $_SESSION['drewno'] = $wiersz['drewno'];
                $_SESSION['kamien'] = $wiersz['kamien'];
                $_SESSION['zboze'] = $wiersz['zboze'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['dnipremium'] = $wiersz['dnipremium'];
                //echo $user;
                
                unset($_SESSION['blad']);

                $rezultat->close();
                //inne funkcje zwalniające pamięć
                //$rezultat->close();
                //$rezultat->free();
                //$rezultat->free_result();

                header('location: gra.php');
            }
            else {
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('location: index.php');
            }
        } else
        {
            unset($_SESSION['zalogowany']);
            unset($_SESSION['id']);

            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
            header('location: index.php');
        }
    }
    $polaczenie->close();
 

    
    /*echo $login."<br />";
    echo $haslo."<br />"; */
?>