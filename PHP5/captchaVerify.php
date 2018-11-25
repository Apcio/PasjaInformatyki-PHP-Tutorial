<?php
    function isCaptchaVerified() {
        $secr = '6LczVmwUAAAAAEwA8hOrlTAh5ogzTuL9X3vrO8jH';
        $resp = $_POST['g-recaptcha-response'];
        if (empty($resp)){
            return false;
        }

        $ver = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secr.'&response='.$resp);
        
        $ver = json_decode($ver);
        if (is_null($ver)) {
            return false;
        }

        return $ver->success;
    }
?>