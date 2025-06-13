<?php
$firstname = stripslashes($_POST['firstname']);
$message = stripslashes($_POST['message']);
$visitor_email = stripslashes($_POST['email']);
$response = $_POST["captcha"];
echo "<p>Please complete the captcha</p>";
//Recaptcha validation
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => '6Lf8QEIqAAAAAKW3nomTe91b_LCff9lCHKTS4t4j',
    'response' => $_POST["captcha"]
);
$options = array(
    'http' => array(
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);
$context = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);

if ($captcha_success->success == false) {
    echo "<p>Please complete the captcha</p>";
} else if ($captcha_success->success == true) {
    //Validate first
    if (empty($firstname) || empty($visitor_email)) {
        echo "Name and email are mandatory!";
        exit;
    }

    if (IsInjected($visitor_email)) {
        echo "Bad email value!";
        exit;
    }

    $email_from = 'web@ecocity.co.bw'; //<== update the email address
    $email_subject = "New Eco City Message";
    $email_body = "You have received a new message from:\n $firstname \n\n Contact Details:\n $visitor_email \n\n Message:\n $message";

    $to = "vanderwaltluan@gmail.com"; //<== update the email address
    $headers = "From: $email_from \r\n";
    $headers .= "Reply-To: $visitor_email \r\n";
    //Send the email!
    mail($to, $email_subject, $email_body, $headers);
    //done.
    echo "Thank you for your enquiry.";
}





// Function to validate against any email injection attempts
function IsInjected($str)
{
    $injections = array(
        '(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
    );
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    if (preg_match($inject, $str)) {
        return true;
    } else {
        return false;
    }
}

?>