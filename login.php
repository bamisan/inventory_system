<?php


include('connection.php');

if(isset($_SESSION['type']))
{
    header("location: index.php");
}


$message = '';

if(isset($_POST['login']))
{
    $query = "
	SELECT * FROM user_details 
		WHERE user_email = :user_email
	";

   $statement = $connect->prepare($query);

   $statement->execute(
        array(
                'user_email'	=>	$_POST["user_email"]
            )
    ); 

   $count = $statement->rowCount();

   if($count > 0)
   {
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            if($_POST["user_password"] == $row["user_password"])
            {
                if($row['user_status'] == 'active')
                {
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    header("location: index.php");

                }
                else
                {
                    $message =  "<label>contact master for check status</label>";
                }
            }
            else
            {
                $message = "<label> wrong password </label>";
            }

        }
   }
   else
   {
       $message = "<label> wrong email </label>";
   }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login.php</title>
    <script src="js/jquery-1.10.2.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <br />
    <div class="container">
    <h2 align="center">inventory system using php and ajax</h2>
    <br />
    <div class="panel panel-default">
        <div class="panel headin">login</div>
        <div class="panel body">
            <form method="post">
            <?php echo $message; ?>

                <div class="form-group">
                <label>user email</label>
                <input type="text" name="user_email" class="form-control" required>
                </div>

                <div class="form-group">
                <label>password</label>
                <input type="password" name="user_password" class="form-control" required>
                </div>

                <div class="form-group">
                <input type="submit" name="login" value="login" class="btn btn-info" required>
                </div>
            
            </form>
        </div>
    </div>
    </div>
</body>
</html>