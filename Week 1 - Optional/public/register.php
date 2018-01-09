<?php
    require_once('../private/initialize.php');

    // Set default values for all variables the page needs.
    $first_name = "";
    $last_name = "";
    $email = "";
    $username = "";
    $errors = array();

    // if this is a POST request, process the form
    // Hint: private/functions.php can help

    if(is_post_request())
    {        
        // Confirm that POST values are present before accessing them.
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : "";
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : "";
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $created_at = date("Y-m-d H:i:s");
        
        $db = db_connect();
        
        // Perform Validations        
        validate_first_name($first_name, $errors);
        validate_last_name($last_name, $errors);
        validate_email($email, $errors);
        validate_username($username, $errors, $db);

        // if there were no errors, submit data to database
        if(empty($errors)) 
        {
            // Write SQL INSERT statement
            $sql = "INSERT INTO users (first_name, last_name, email, username, created_at)
            VALUES ('" . db_escape($db, $first_name) . "', '"
                . db_escape($db, $last_name) . "', '"
                . db_escape($db, $email) . "', '"
                . db_escape($db, $username) . "', '"
                . db_escape($db, $created_at) . "')";
            
            // For INSERT statments, $result is just true/false
            $result = db_query($db, $sql);
            if($result) {
                db_close($db);

            //   DONE: redirect user to success page
                header("Location: registration_success.php");
                exit;
                
             } else {
               // The SQL INSERT statement failed.
               // Just show the error, not the form
               echo db_error($db);
               db_close($db);
               exit;
             }
        }
        
    }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    
    // DONE: display any form errors here
    echo display_errors($errors);
    
  ?>

  <!-- DONE: HTML form goes here -->
    
    <form action="" method="post">
        
        <p><b>First Name: </b><input type="text" name="first_name" value="<?php echo h($first_name); ?>"></p>
        <p><b>Last Name: </b><input type="text" name="last_name" value="<?php echo h($last_name); ?>"></p>
        <p><b>Email: </b><input type="text" name="email" value="<?php echo h($email); ?>"></p>
        <p><b>Username: </b><input type="text" name="username" value="<?php echo h($username); ?>"></p>
        <p><input type="submit" value="Submit Registration"></p>
    </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
