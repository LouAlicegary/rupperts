<?php

// Define your username and password
$username = "ruppert";
$password = "CRupp3rt!";

if ($_POST['txtUsername'] != $username || $_POST['txtPassword'] != $password) {

?>

<h1>Login</h1>

<form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <p><label for="txtUsername">Username:</label>
    <br /><input type="text" title="Enter your Username" name="txtUsername" /></p>
    <p><label for="txtpassword">Password:</label>
    <br /><input type="password" title="Enter your password" name="txtPassword" /></p>
    <p><input type="submit" name="Submit" value="Login" /></p>
</form>

<?php

}

else {

?>

<META http-equiv="refresh" content="0;URL=http://www.christopherruppert.com/upload_images_xx.php">


<?php

}

?>
