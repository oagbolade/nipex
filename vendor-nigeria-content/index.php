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
        <div class="row">
          <div class="col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Completion status <?php echo $completionStatus; ?> </h2>
                <ul class="nav panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <span id="general" class="chart" data-percent="<?php echo $completion ?>">
                 <span class="percent"></span>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <?php echo $response; ?>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo htmlentities("processor.php"); ?>" method="post">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Nigeria Content</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>


								<!-- Are you Nigerian? START -->
								<div class="x_content">
										<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
										<div class="row">
											<div class="col-md-3">
												<p>Indicate that you have a Nigerian content policy ?*</p>
											</div>
											<div class="col-md-9">
												<label>
												<input type="radio" value="yes" name="nigeriaContent" onclick="showContent()" <?php echo $checkNigeriaContentYes; ?> > Yes &nbsp;&nbsp;
												</label>
												<label>
												<input type="radio" id="no" value="no" name="nigeriaContent" onclick="hideContent()" <?php echo $checkNigeriaContentNo; ?>> No
												</label>
											</div>
										</div>

										<!-- To hide START -->
										<div id="hide">
											<div class="row">
												<div class="col-md-3">
													<p>Nigerian Contact Name *</p>
												</div>
												<div class="col-md-9">
														<div class="form-group">
															<input type="text" name="nigeriaContact" class="form-control " value="<?php echo $nigeriaContact; ?>" >
														</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<p>Email Address*</p>
												</div>
												<div class="col-md-9">
														<div class="form-group">
															<input type="email" name="emailAddress" class="form-control " value="<?php echo $emailAddress; ?>" >
														</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<p>Contact Telephone Number (Full International Number)*</p>
												</div>
												<div class="col-md-9">
														<div class="form-group">
															<input type="text" name="contactTelephone" value="<?php echo $contactTelephone; ?>" class="form-control " >
														</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<p>Have you got a Pension Scheme? *</p>
												</div>
												<div class="col-md-9">
													<label>
														<input type="radio" value="yes" class="" name="pensionScheme"  <?php echo $pensionSchemeYes; ?>>Yes &nbsp;&nbsp;
													<label>
													<label>
														<input type="radio" value="no" class="" name="pensionScheme" <?php echo $pensionSchemeNo; ?>>No
													<label>
												</div>
											</div>
									</div>
									<!-- To hide END -->
								</div>
								<!-- Are you Nigerian? END -->


              </div>
              <!-- save button panel -->
              <div class="x_panel">
                <div class="x_content">
                  <button <?php echo $disableSave; ?> type="submit" name="save" class="btn btn-success">Save</button>
                </div>
              </div>
            </form>
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
