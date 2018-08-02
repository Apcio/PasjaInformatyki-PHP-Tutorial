<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        $imie = "Joanna";
        echo "$imie, witaj na stronie!";
        echo "<br>";
        echo '$imie, witaj na stronie! - apostrofy są "silniejsze" niż cydzysłowie, oznacza to, że znaki takie jak $," nie będa interpretowane przez interpreter języka';
        echo "<br>";
        echo '<img src="https://www.google.pl/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png"/>';
        echo "<br>";
        echo $imie.', witaj na stronie! - konkatenacja może być z cudzysłowiem';
    ?>
    <br><br>
    <a href="..\start.html">Powrót do spisu</a>
</body>
</html>