<?php
/*
* Item : PHP & AJAX contact form
* Author : Kouloughli Hemza
* Time : 2/03/2017
*/
ob_start();
/* Put Here email where you will receive Contact message*/
$yourEmail = "email@email.com"; // <== Your Email
$secret = 'Add Recaptcha Secret Key Here'; // <==Your recaptcha Privte Key
// You can get Key from here: https://www.google.com/recaptcha/admin
/*---------------------------------------*/

// ---------------------Start the recaptcha ------------------------------------//
if(isset($_POST['g-recaptcha-response']) && ($_POST['g-recaptcha-response'])){
        session_start();
    $ip = $_SERVER['REMOTE_ADDR'];
    $captcha = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
    $result = json_decode($response,TRUE);
        if($result['success'] == 1){
            $_SESSION['result'] = $result['success'];
            }
    
// --------------------End Of the Captcha Check------------------------- //    
    
/////////////Showing all errors in array : DO NOT DELETE THIS
$formerrors = array();
///////////////////This Array will Hold all errors 

// Start Captcha
if(!isset($_SESSION['result']) || $_SESSION['result'] == 0){
    $formerrors[] =  'Captcha Error';
}
//end Captcha
    

// remove this to make name not required
if(empty($_POST['name'])){
$formerrors[] = "Name Cannot be empty";
}
// End name 


// Remove this to make email not required            
if(empty($_POST['email'])){
  $formerrors[] = "Email Cannot be empty";
}
// End of email

// Remove this to make email not required            
if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) == FALSE){
  $formerrors[] = "Make Sure Email is valid";
}
// End of email

// Remove this to make Phone not required            
if(empty($_POST['phone'])){
  $formerrors[] = "Phone Number Cannot be empty";
}
// End of Phone



// Remove this to make Phone not required            
if(!is_numeric($_POST['phone'])){
  $formerrors[] = "Phone Is not valid";
}
// End of Phone



// Remove this to make Message not required                       
if(empty($_POST['message'])){
   $formerrors[] = "Message Cannot be empty";
}
// End Of Message


// Remove this to make Subject not required                       
if(empty($_POST['subject'])){
   $formerrors[] = "Select a subject First";
}
// End Of Subject



/* Your New inputs */

    // CODE HERE

/* end of new Inputs*/




// End Showing Errors In Array
            
            
if(count($formerrors) == 0){
 // Saving data in variable :
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['subject'];
    $message = $_POST['message'];
    /* Your New inputs */
    
        // $newinput = $_POST['new-input'] // new-input same as ID and ajax
    
    /* end of new Inputs*/
                        
    //If No Error in the Array Start Sending the email
    $to = $yourEmail;	// Email to receive contacts
    $from = $email;
    $subject = 'Contact Form Email : ' . $title;
    $message = '<style>
                body{background-color:#fefefe}
                .email-style {padding: 30px;background: #fafafa;font-size: 18px;border: 1px solid #ddd;width: 60%;margin: auto;}
                p {padding: 15px 0px;}
                </style>
                                        
                <div class="email-style"><p> '.$title . '</p>
                
                <p>Contact Full Name : '.$name . ' </p>
                
                <p>Contact Email : '.$email . ' </p>
                
                <p>Contact Phone Number : '.$phone . '</p>
                
                <p>Message : '.$message . ' </p>
                
                <p>Cheers,</p>
                <p>'.$name.' Via Contact Form</p></div>';
                        
    $headers = "From: $from\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
       if( mail($to, $subject, $message, $headers) ){
            echo "sent";
            session_unset();
            session_destroy();
          } else {
                   echo "The server failed to send the message. Please try again later.";
                }
                        
                    // If there are Errors in form :    
   }else{ 
    
    //if there are Errors in the Array , Show errors in form
    echo '<div id="contact-errors">';
    foreach($formerrors as $error){
     echo '<div class="errors-section mdl-cell mdl-cell--12-col">
           <span class="mdl-chip mdl-chip--contact">
           <span class="mdl-chip__contact mdl-color-text--white"><i class="material-icons error-form">error_outline</i></span>
           <span class="mdl-chip__text">' . $error . '</span>
           </span></div>';}
    
    echo '</div>';}// End of errors here 
}else{
    echo 'Fill in Captcha ';

}
   
ob_flush();
?>
