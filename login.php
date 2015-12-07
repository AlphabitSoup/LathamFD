

<?php require('header.php'); ?>
  
    <!-- Login form -->
    <div class="text-center">
      <form class="form-inline"  action="process.php" method="post">
        <div class="form" >
          <label class="sr-only" for="inputEmail" name="email">Email address</label>
          <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email">
        <br />
          <label class="sr-only" for="inputPassword" name= "password">Password</label>
          <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
        </div>
        <br />
        <br />
        <input type="submit" class="btn btn-default" value="sign in">
      </form>
    </div>

  
 <?php require('footer.php'); ?>
