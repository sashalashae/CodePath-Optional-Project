<?php
  require_once('../private/initialize.php');
  $input_text = '';
  $input_text1 = '';
  $check_sum = '';
  $result_text = '';
  if(isset($_POST['submit'])) {
  
    if(isset($_POST['input_text'])) {
    
      // This is a create checksum request
      $input_text = isset($_POST['input_text']) ? $_POST['input_text'] : nil;
      $check_sum = md5($input_text);
     
    
    } else {
    
      // This is a verify checksum request
      $input_text1 = isset($_POST['input_text1']) ? $_POST['input_text1'] : nil;
      $check_sum = isset($_POST['check_sum']) ? $_POST['check_sum'] : nil;
      $check_sum1 = md5($input_text1);
      $result = strcmp($check_sum1, $check_sum);
      $result_text = $result === 0 ? 'Valid' : 'Not valid';
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Checksum: Create/Verify Checksum</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    <link rel="stylesheet" media="all" href="includes/styles.css" />
  </head>
  <body>
    
    <a href="index.php">Main menu</a>
    <br/>
    <h1>Checksum</h1>
    
    <div id="encoder">
      <h2>Create Checksum </h2>
      <form action="check_sum.php" method="post">
        <div>
          <div>
          <label for="check_sum_function">Function</label>
          <select name="check_sum_function">
            <option value="md5">MD5</option>
          </select>
        </div>
        <div>
          <label for="input_text">Input</label>
          <textarea name="input_text"><?php echo h($input_text); ?></textarea>
        </div>
        
        </div>
        <div>
          <input type="submit" name="submit" value="Create">
        </div>
      </form>
    
      <div class="result"><?php echo h($check_sum); ?></div>
      <div style="clear:both;"></div>
    </div>
    
    <hr />
    
    <div id="decoder">
      <h2>Verify Checksum</h2>
      <form action="check_sum.php" method="post">
        <div>
          <div>
          <label for="check_sum_function">Function</label>
          <select name="check_sum_function">
            <option value="md5">MD5</option>
          </select>
        </div>
        <div>
          <label for="checksum">Checksum</label>
          <textarea name="check_sum"><?php echo h($check_sum); ?></textarea>
        </div>
        <div>
          <label for="input_text1">Input</label>
          <textarea name="input_text1"><?php echo h($input_text1); ?></textarea>
        </div>
        </div>
        <div>
          <input type="submit" name="submit" value="Verify">
        </div>
      </form>
      <div class="result"><?php echo h($result_text); ?></div>
      <div style="clear:both;"></div>
    </div>
    
  </body>
</html>