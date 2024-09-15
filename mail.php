<?php
 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
 
//Create an instance; passing `true` enables exceptions

$n = 6;
function getName($n)
{
    $characters = '0123456789';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

$_SESSION["reset_code"] = "";

if (isset($_POST["resets"])) {

    
    $_SESSION["reset_code"] = getName($n);
    
 
  $mail = new PHPMailer(true);
 
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'rex010109@gmail.com';   //SMTP write your email
    $mail->Password   = 'jlxqwodubbnbbflr';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    
 
    //Recipients
    $mail->setFrom('noreply@example.com', 'HypeHaven');
    $mail->addAddress($_POST["email"]);     //Add a recipient email  
    $mail->addReplyTo($_POST["email"]); // reply to sender email
 
    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = 'Reset Password';   // email subject headings
    $mail->Body    = '
    <html>
        <body style="
            padding:20px; 
            background-color:gray;
            width: 500px;
            height: 600px;
            color: white;"
            >
        <h1>Dear ' . $_POST["email"] . ',</h1>
        <br>
        
        <p style="color: white;">Here is your password reset PIN:</p>
        <br>
        <br>

        <h1 style="
            padding:20px; 
            font-size:40px; 
            width: 400px; 
            height: 50px; 
            text-align: center;
            background-color:cyan;
            color:white;
            border-radius:25px;
            font-family:Arial, Helvetica, sans-serif;
            margin: auto"
            >
            ' . $_SESSION["reset_code"] . '
        </h1>
        <br>
        <br>
        
        <p style="color: white;">Enjoy your stay on our website!</p>
        
        <p style="color: white;">If this is not sent by you, please ignore this email</p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <p style="color: white;">Best Regards</p></br>
        <p style="color: white;">Our Staff</p>
        </body>
    </html>
    '; //email message
      
    // Success sent message alert
    $mail->send();
    echo
    " 
    <script> 
     alert('Message was sent successfully!');
     document.location.href = 'index.php';
    </script>
    ";
}
?>