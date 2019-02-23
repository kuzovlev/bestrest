<?php
if (isset ($_POST['contact'])) {
    $to = "bestrest.agency@gmail.com";
    $from = $_POST['contact'];
    $subject = "Заполнена форма обратной связи ".$_SERVER['HTTP_REFERER'];
    $message = "С нами связался(-лась)".$_POST['contact-us-name']."\nEmail: ".$_POST['contact-us-email']."\nНаписал такое сообщение - ".$_POST['contact-us-message'];
    $boundary = md5(date('r', time()));
    $filesize = '';
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $message="
  Content-Type: multipart/mixed; boundary=\"$boundary\"

  --$boundary
  Content-Type: text/plain; charset=\"utf-8\"
  Content-Transfer-Encoding: 7bit

  $message";
    for($i=0;$i<count($_FILES['file']['name']);$i++) {
        if(is_uploaded_file($_FILES['file']['tmp_name'][$i])) {
            $attachment = chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'][$i])));
            $filename = $_FILES['file']['name'][$i];
            $filetype = $_FILES['file']['type'][$i];
            // $filesize += $_FILES['file']['size'][$i];
            $message.="

     --$boundary
     Content-Type: \"$filetype\"; name=\"$filename\"
     Content-Transfer-Encoding: base64
     Content-Disposition: attachment; filename=\"$filename\"

     $attachment";
        }
    }
    $message.="
 --$boundary--";

    if ($filesize < 10000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
        mail($to, $subject, $message, $headers);?>
        <html lang="en">
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="refresh" content="3; url=/lalala.php">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title></title>
            <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
            <style>
                @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
                @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
            </style>
            <link rel="stylesheet" href="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/default_thank_you.css">
            <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/jquery-1.9.1.min.js"></script>
            <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/html5shiv.js"></script>
        </head>
        <body>
        <header class="site-header" id="header">
            <h1 class="site-header__title" data-lead-id="site-header-title">Спасибо!</h1>
        </header>

        <div class="main-content">
            <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
            <p class="main-content__body" data-lead-id="main-content-body">Мы уже обрабатываем форму, которую Вы отправили нам и в ближайшее время свяжемся!</p>
            <p class="main-content__body" data-lead-id="main-content-body" style="font-size: 16px;">Вы будеде автоматически перенаправлены на главную страницу</p>
        </div>
        <script type="text/javascript">
            setTimeout('location.replace("/index.html")', 3000);
        </script>
        </body>
        </html>
        <?
        // echo 'Спасибо, Ваше сообщение получено, спасибо!';
    } else {
        echo 'Извините, письмо не отправлено. Размер всех файлов превышает 10 МБ.';
    }
}
?>