	<style>
		th{
		font-size: 250%;
		color: 550000;
		align: center;
		}
		input{
		align: right;
		}
	</style>
	
	<table border="10" align="center">
	<tr><th>Latham Fire Department</th></tr>
    <!-- Login form -->
	<tr><th>Login Page</th></tr>

    <div class="text-center">
      <form class="form-inline"  action="process.php" method="post">
        <div class="form" >
		<tr align="center">
		<td>
          <label class="sr-only" for="inputEmail" name="email">Email address</label>
          <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email">
		  </td>
		  </tr>
        <br />
		<tr align="center">
		<td>
          <label class="sr-only" for="inputPassword" name= "password">Password: </label>
          <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
		  </td>
		  </tr>
        </div>
        <br />
        <br />
		<tr align="center">
		<td>
        <input type="submit" class="btn btn-default" value="sign in">
		</td>
		</tr>
      </form>
    </div>
	</table>

  
