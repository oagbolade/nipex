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
        <?php echo $response; ?>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Vendor Details</h2>
                <ul class="nav navbar-right panel_toolbox al_panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <form class="form-horizontal form-label-left" method="post" action="<?php echo htmlentities("processor.php"); ?>">
                	<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                	<div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?php
                      	echo $companyName ."<br/>";
												echo $companyEmail ."<br/>";
												echo $companyPhone ."<br/>";
												echo "<small><em>$approver</em></small>";
                   		?>
                    </div>
                  </div>
                	<div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="name" name="username" required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	<small class='label label-danger'>minimum 8 character</small>
                      <input type="text" id="name" name="password" required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="validityPeriod">End of Validity <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="date" id="name" name="validityPeriod" value="<?php echo $validityPeriod;  ?>" required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button <?php echo $disabled; ?> type="submit" class="btn btn-success" name="vendor" value="<?php echo $_GET['id'] ?>">Create</button>
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