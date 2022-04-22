<!DOCTYPE html>
<html>
  <head>
    <title>Email-Verteiler</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php include("menue.php"); ?><br>
    <?php echo "<p style=\"color:red;\">" . $this->_["blog_error"] . "</p>"; ?>
    <?php echo $this->_["blog_content"]; ?>
  </body>
</html>