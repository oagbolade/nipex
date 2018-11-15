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
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2><?php echo $sessionCaption; ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
               <form class="form-horizontal form-label-left" method="post" action="<?php echo htmlentities("processor.php"); ?>">
                	<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                	<?php echo $feeID; ?>
                	<div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fee">Fee Name <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input <?php echo $disabledFee; ?> type="text" id="fee" name="fee" <?php echo $fee ?> required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Amount <span class="required">*</span>
                    </label>
                    <div class="col-md-9 col-sm-6 col-xs-12">
                      <input type="number" step="0.01" id="amount" <?php echo $amount ?> name="amount" required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="submit" <?php echo $action; ?> name="action" class="btn btn-success"><?php echo $buttonCaption; ?></button>
                    </div>
                  </div>
               	</form>
              </div>
            </div>
          </div>
          
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>List of Fees</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
              	<?php echo $table; ?>
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