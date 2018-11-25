<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Newsletter - zapisz się!</title>
    <meta name="description" content="Używanie PDO - zapis do bazy MySQL">
    <meta name="keywords" content="php, kurs, PDO, połączenie, MySQL">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <div class="container">

        <header>
            <h1>Newsletter</h1>
        </header>

        <main>
            <article>
                <form method="post" action="save.php">
                    <label>Podaj adres e-mail
                        <input type="email" name="email"
                          <?= isset($_SESSION['given_email'])
                                    ? 'value="'.$_SESSION['given_email'].'"'
                                    : ''
                          ?>
                        >
                    </label>

                    <br/><br/>
                    <div class="g-recaptcha" data-sitekey="6LczVmwUAAAAAAWs9_nWo5qWzLmFo7QBUlagI6y_"></div>
                    <br/><br/>

                    <input type="submit" value="Zapisz się!">

                    <br/><br/>
                    <input class="unregister" type="submit" value="Wypisz się!" formaction="delete.php">

                    <?php
                        if (isset($_SESSION['error_text'])) {
                            echo '<p>' . $_SESSION['error_text'] . '</p>';
                            unset($_SESSION['given_email']);
                            unset($_SESSION['error_text']);
                        }
                    ?>

                </form>
            </article>
        </main>

    </div>
</body>
</html>