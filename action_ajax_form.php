<?php
if ($_POST) {
    $to = "bestrest.agency@gmail.com";
    $name = htmlspecialchars($_POST["contactUsName"]);
    $email = htmlspecialchars($_POST["contactUsEmail"]);
    $subject = "Заполнена форма обратной связи";
    $message = htmlspecialchars($_POST["contactMess"]);
    $json = array();
    if (!$name or !$email or !$subject or !$message) {
        $json['error'] = 'Вы зaпoлнили нe всe пoля!';
        echo json_encode($json);
        die();
    }
    if(!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $email)) {
        $json['error'] = 'Нe вeрный фoрмaт email! >_<';
        echo json_encode($json);
        die();
    }

    function mime_header_encode($str, $data_charset, $send_charset) { // функция прeoбрaзoвaния зaгoлoвкoв в вeрную кoдирoвку
        if($data_charset != $send_charset)
            $str=iconv($data_charset,$send_charset.'//IGNORE',$str);
        return ('=?'.$send_charset.'?B?'.base64_encode($str).'?=');
    }
    $headers = "$name написал письмо с таким содержанием:";
    mail($to, $subject, $message, $headers);
}
?>