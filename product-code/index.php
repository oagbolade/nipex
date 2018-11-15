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
          <div class="col-md-5 col-sm-12 col-xs-12">
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
                	<?php echo $inputID; ?>
                	<div class="form-group">
                    <label class="control-label col-md-4 col-sm-5 col-xs-12" for="code">Code <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                      <input type="text" id="code" placeholder="1.1.1" name="code" <?php echo $code ?> required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-5 col-xs-12" for="service">Product/Service <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                      <input type="text" id="service" placeholder="Minor Welding" <?php echo $service ?> name="service" required class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-5 col-xs-12" for="category">Permit Category <span class="required">*</span>
                    </label>
                    <div class="col-md-8 col-sm-7 col-xs-12">
                      <select class="form-control" name="category" required>
                      	<?php echo $categoryOption; ?>
                      </select>
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
          
          <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>List of Product/Service Code</h2>
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