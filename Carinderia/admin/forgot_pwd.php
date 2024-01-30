<?php
session_start();
include('config/config.php');


if (isset($_POST['reset_pwd'])) { //
  $email = $_POST['reset_email'];
  $newpass = $_POST['reset_password'];
  $rpass = $_POST['reset_password_repeat'];

  if(empty($email )|| empty($newpass) || empty($rpass)){
    $err = "Please Fill All The Fields!";
  }
  else {
      $sql = "SELECT * FROM rpos_customers WHERE customer_email =?";
      $res = mysqli_query($mysqli, $sql);
      if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($newpassword != $rpass) {
          $err =  "Password Doesn\'t Match";
        } else {

          $newpass  = sha1(md5($_POST['reset_password']));
          //Insert Captured information to a database table
          $query = "UPDATE rpos_customers SET customer_password = ? WHERE customer_email =?";
          $stmt = $mysqli->prepare($query);
          //bind paramaters
          $rc = $stmt->bind_param('s', $newpass);
          $stmt->execute();

          //declare a varible which will be passed to alert function
          if ($stmt) {
            $success = "Password Changed" && header("refresh:1; url=dashboard.php");
          } else {
            $err = "Please Try Again Or Try Later";
          }
        }
      }
    }
   

  
}

require_once('partials/_head.php');
?>

<body class="bg-warning">
  <div>
    <div class="main-content">
      <div class="header bg-gradient-primar py-7">
        <div class="container">
          <div class="header-body text-center mb-7">
            <div class="row justify-content-center">
              <div class="col-lg-5 col-md-6">
                <h1 class="text-white"><a style="color:white" href="../../index.php">Elaine, Lee, and Jecie's</a></h1>
                <h1 class="text-white"><a style="color:white" href="../../index.php">Carinderia</a></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- Page content -->
<div class="container mt--8 pb-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
      <div class="card bg-yellow shadow border-0">
        <div class="card-body px-lg-5 py-lg-5">
          <form method="post" role="form">
            <!-- Email input fields -->
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                </div>
                <input class="form-control" required name="reset_email" placeholder="Email" type="email">
              </div>
            </div>
            <!-- Add password and Repeat password fields -->
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                </div>
                <input class="form-control" required name="reset_password" placeholder="Password" type="password">
              </div>
            </div>

            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                </div>
                <input class="form-control" required name="reset_password_repeat" placeholder="Repeat Password" type="password">
              </div>
            </div>


            <div class="text-center">
              <button type="submit" name="reset_pwd" class="btn btn-primary my-4">Reset Password</button>
            </div>

            <div class="row mt-3">
              <div class="col-6">
                <a href="../../customer/index.php" class="text-white"><strong><u>Log In?</u></strong></a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Footer -->
    <?php
    require_once('partials/_footer.php');
    ?>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
  </div>
</body>

</html>