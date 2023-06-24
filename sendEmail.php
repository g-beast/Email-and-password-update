<?php
///////////////update password///////////
/////this email if for verification during signing in/////////
if (isset($_POST['emailBtn'])) {
        
    //Get data from db
    $email = mysqli_real_escape_string($db, $_POST['email']);
    
    $email_query = "SELECT * FROM dbTableName WHERE email = '$email' LIMIT  1";
	$result_Set = mysqli_query($db, $email_query);
	$resultData = mysqli_fetch_assoc($result_Set);
	$vkey = $resultData['vKey'];
	$firstname = $resultData['firstName'];
	$result_set = mysqli_num_rows($result_Set);
	
    if($result_set == 1){
        //send confirmation email
        $subject = "Password Update.";
        $headers = "From: The organisation name<theOfficialDomainEmail>\r\n";
        $headers .="MIME-Version: 1.0\r\n";
        $headers .="Content-Type: text/html; charset-ISO-8859-1\r\n";
                
        $name = $firstname;//will refer to the receiver by the first name, this is gotten from the database. It is not Mandatory
        $verKey = "urlOfTheExactPageThatNeedsTheVerifeicationKey?vkey=$vkey";
        //these will connect the logic of sending the email with the passMailTamp.php file, html and css, that will be seen by receiver        
        ob_start();
        include 'passMailTamp.php';
        $message = ob_get_contents();
        ob_get_clean();
        //sending the email
        $mail_sent = mail($email, $subject, $message, $headers);
        
        if($mail_sent){
            //response if email is sent successfully
            header('location:ChangePassword?signup=checkmail');
        }
    }else{
        //response if the email does not exist as a regitered member
        header('location:ChangePassword?signup=noIdentity');
    }
}
//////////////////
?>