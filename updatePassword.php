<?php
//to update the password after verification that the account is theirs//
//You will have a password update page, this will contain, new password, confirm new password input//
if (isset($_POST['updateBtn'])) {
    
    $newPassword = mysqli_real_escape_string($db, $_POST['newPassword']);
    
    $confirmPassword = mysqli_real_escape_string($db, $_POST['confirmPassword']);
    
    $vkey = mysqli_real_escape_string($db, $_POST['vkey']);
    
    // check if equality
    if($newPassword != $confirmPassword){
        header('location:PasswordUpdate?signup=passwordMismatch');
    }else{
    
        //password encription
        $newPasswordMd = md5($newPassword);
    	//query the db
    	$check_query = "SELECT * FROM dbTableName WHERE vKey = '$vkey' LIMIT  1";
    
    	$passwordSet = mysqli_query($db, $check_query);
    	$password_Set = mysqli_num_rows($passwordSet);
    	
    	if($password_Set == 1){
    	    $password_query = "UPDATE dbTableName SET pass_word = '$newPasswordMd' WHERE vKey = '$vkey' LIMIT 1";
            if(mysqli_query($db, $password_query)){
                header('location:loginPage?signup=updatedPassword');
            }
    	}else{
            header('location:passwordUpdatePage?signup=noIdentity');
        }
    }
}