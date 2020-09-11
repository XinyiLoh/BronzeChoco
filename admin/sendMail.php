<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Send Mail</h1>
  </div>

  <div class="row">

      <div class="col-lg-11">

          <div class="card mb-5 py-4 border-bottom-warning">
              <div class="card-body">

                  <?php
                        if (isset($_POST['send'])) {
                          if (!empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
                              $to = htmlspecialchars(trim($_POST['email']));
                              $subject = htmlspecialchars(trim($_POST['subject']));
                              $message = htmlspecialchars(trim($_POST['message']));

                              $headers = "From:" + $_SESSION['username'];

                              $sent = mail($to, $subject, $message, $headers);

                              if ($sent == true) {
                                  $_SESSION['status'] = "Message successfully sent!";
                                  $_SESSION['status_code'] = "success";
                              } else {
                                  $_SESSION['status'] = "Message could not be sent...";
                                  $_SESSION['status_code'] = "error";
                              }
                          }else {
                            $_SESSION['status'] = "Please fill out the form completely.";
                            $_SESSION['status_code'] = "warning";
                          }
                    }

                  $receiver = isset($_POST['email_btn']) ? $_POST['mail'] : "";

                  ?>


                  <form method="POST">
                      <table>
                          <tr>
                              <td>To : </td>
                              <td>&nbsp;&nbsp;&nbsp;<input type="email" name="email" size="100" maxlength="80" value="<?php echo $receiver; ?>" /></td>
                          </tr>
                          <tr>
                              <td>Subject : </td>
                              <td>&nbsp;&nbsp;&nbsp;<input type="text" name="subject" size="100" maxlength="80" value="<?php if (isset($_POST['subject'])) echo $_POST['subject']; ?>" /></td>
                          </tr>
                          <tr>
                              <td>Message : </td>
                              <td>&nbsp;&nbsp;&nbsp;<textarea name="message" cols="100" rows="5"><?php if (isset($_POST['message'])) echo $_POST['message']; ?></textarea></td>
                          </tr>
                      </table>
                      <br/>
                      <hr>
                      <center><button type="submit" name="send" class="btn btn-info btn-circle"><i class="fas fa-paper-plane"></i></button>Send</center>
                  </form> 

              </div>
          </div>
    </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
