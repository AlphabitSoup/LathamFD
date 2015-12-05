
<!DOCTYPE html>
<html>
<?php require('header.php'); ?>
  <body>    
    <!-- Login form -->
    <div class="text-center">
      <form class="form-inline"  action="process.php" method="post">
        <div class="form" >
          <label class="sr-only" for="inputEmail" name="email">Email address</label>
          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
        <br />
          <label class="sr-only" for="inputPassword" name= "password">Password</label>
          <input type="password" class="form-control" id="inputPassword" placeholder="Password">
        </div>
        <br />
        <br />
        <button type="submit" class="btn btn-default" value="click" name="submit">Sign in</button>
      </form>
    </div>

  </body>
 <?php require('footer.php'); ?>
</html>
