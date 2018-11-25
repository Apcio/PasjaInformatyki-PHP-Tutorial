<?php
    session_start();

    require_once 'database.php';

    function isEmailCorrectly() {
        $eMail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (empty($eMail)) {
            $_SESSION['error_text'] = "Podany adres email jest niepoprawny!";
            $_SESSION['given_email'] = "";
            return false;
        } else {
            return true;
        }
    }

    function deleteEmail($db) {
        $eMail = $_POST['email'];
        $query = $db->prepare("DELETE FROM newsletter.users WHERE email = :mail");
        $query->bindValue(':mail', $eMail, PDO::PARAM_STR);
        return $query->execute();
    }

    if (!isEmailCorrectly()) {
        header('Location: index.php');
        exit();
    }

    require_once 'captchaVerify.php';
    if (!isCaptchaVerified()) {
        $_SESSION['given_email'] = $_POST['email'];
        $_SESSION['error_text'] = 'Captcha nie została zweryfikowana!';
        header('Location: index.php');
        exit();
    }

    if (!deleteEmail($db)) {
        $_SESSION['error_text'] = "Nie udało się wypisać z newslettera. Spróbuj później.";
        $_SESSION['given_email'] = $_POST['email'];
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <title>Zapisanie się do newslettera</title>
    <meta name="description" content="Używanie PDO - zapis do bazy MySQL">
    <meta name="keywords" content="php, kurs, PDO, połączenie, MySQL">

    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">

        <header>
            <h1>Newsletter</h1>
        </header>

        <main>
            <article>
                <p>Wypisałeś(aś) się z naszego newslettera! Żegnaj :(</p>
            </article>
        </main>

    </div>

</body>
</html>