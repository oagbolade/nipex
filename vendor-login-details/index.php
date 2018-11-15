<?php 
	require_once 'controller.php'; 
	echo $head;
?>
<div class="container body">
	<div class="main_container">
		<?php echo $menu; ?>
		<?php echo $mastHead; ?>

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3><?php echo $pageName ?></h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Change Login Details</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
                <?php echo $response; ?>
              </div>
              <div class="x_content">
              	<?php echo $warning; ?>
                <form action="<?php echo htmlentities("processor.php"); ?>" method="post">
                  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                  <div class="row">
                     <div class="col-md-4">
                       <p>Username</p>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <?php echo $userDetails['username']; ?>
                       </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                       <p>Login Email</p>
                     </div>
                     <div class="col-md-6">
                       <div class="form-group">
                         <?php echo $userDetails['email']; ?>
                       </div>
                     </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p>Old Password</p>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" name="oldPassword" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p>New Password</p>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      	<small class='label label-danger'>minimum 8 character</small>
                        <input type="password" name="newPassword" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p>Repeat New Password</p>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" name="repeatNewPassword" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-success">Change</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<?php echo $footer; ?>