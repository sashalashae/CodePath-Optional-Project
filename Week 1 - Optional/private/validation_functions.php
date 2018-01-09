<?php

    $max_length = 255;

    $name_length = array(
        "min" => 2,
        "max" => $max_length
    );

    $email_length = array(
        "max" => $max_length
    );

    $username_length = array(
        "min" => 8,
        "max" => $max_length
    );

    // is_blank('abcd')
    function is_blank($value='') {
        return (strlen($value) == 0);
    }

    // has_length('abcd', ['min' => 3, 'max' => 5])
    function has_length($value, $options=array()) {
        
        $length = strlen($value);
        
        $meetsMin = !isset($options['min']) || $length >= $options['min'];
        $meetsMax = !isset($options['max']) || $length <= $options['max'];     
        
        return $meetsMin && $meetsMax;
        
    }

    function has_valid_name_format($name)
    {
        return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $name);
    }

    // has_valid_email_format('test@test.com')
    function has_valid_email_format($email) {
        // DONE
        return preg_match('/\A[A-Za-z0-9\_\.]+@[A-Za-z0-9\.]+\.[A-Za-z0-9\.]{2,}\Z/', $email);
    }

    function has_valid_username_format($username)
    {
        return preg_match('/\A[A-Za-z0-9\_]+\Z/', $username);
    }

    function has_unique_username($username, $db)
    {
        $sql = "SELECT * FROM users WHERE username='" . db_escape($db, $username) . "'";
        $result_set = db_query($db, $sql);
        return (db_num_rows($result_set) == 0);
    }

    function validate_first_name($first_name, &$errors)
    {    
        global $name_length;
        
        if(is_blank($first_name))
        {
            $errors[] = "First name cannot be blank.";
        }
        else if(!has_length($first_name, $name_length))
        {
            $errors[] = "First name must be between {$name_length['min']} and {$name_length['max']} characters.";
        }
        else if(!has_valid_name_format($first_name))
        {
            $errors[] = "First name may only contain letters, spaces, and the following symbols: hyphen, comma, period, and apostrophe.";
        }
    }

    function validate_last_name($last_name, &$errors)
    {    
        global $name_length;
        
        if(is_blank($last_name))
        {
            $errors[] = "Last name cannot be blank.";
        }
        else if(!has_length($last_name, $name_length))
        {
            $errors[] = "Last name must be between {$name_length['min']} and {$name_length['max']} characters.";
        }
        else if(!has_valid_name_format($last_name))
        {
            $errors[] = "Last name may only contain letters, spaces, and the following symbols: hyphen, comma, period, and apostrophe.";
        }
    }

    function validate_email($email, &$errors)
    {
        global $email_length;
        
        if(is_blank($email))
        {
            $errors[] = "Email cannot be blank.";
        }
        else if(!has_valid_email_format($email))
        {
            $errors[] = "Email must be a valid format.";
        }
        else if(!has_length($email, $email_length))
        {
            $errors[] = "Email must not exceed {$email_length['max']} characters.";
        }
    }

    function validate_username($username, &$errors, $db)
    {
        global $username_length;
        
        if(is_blank($username))
        {
            $errors[] = "Username cannot be blank.";
        }
        else if(!has_length($username, $username_length))
        {
            $errors[] = "Username must be between {$username_length['min']} and {$username_length['max']} characters.";
        }           
        else if(!has_valid_username_format($username))
        {
            $errors[] = "Username may only contain letters, spaces, and underscores.";
        }
        else if(!has_unique_username($username, $db))
        {
            $errors[] = "The username you requested is already in use.";
        }
    }

?>
