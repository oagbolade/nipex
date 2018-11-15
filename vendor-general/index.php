<?php 
	require_once 'controller.php'; 
	echo $head;
?>
<style type="text/css">
</style>
<div class="container body">
	<div class="main_container">
		<?php echo $menu; ?>
		<?php echo $mastHead; ?>
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3><?php echo $pageName ?> </h3>
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
                <span class="chart" data-percent="<?php echo $completion ?>">
                 <span class="percent"></span>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="clearfix"></div>
        <?php echo $response; ?>
        <form id="demo-form2" data-parsley-validate class="form" action="<?php echo htmlentities("processor.php")?>" method="post">
        <div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
             <div class="x_title">
              <h2>General Company Information </h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
             <div class="x_content">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                  <div class="form-group">
                    <label>Company Name*</label>
                    <input readonly type="text" name="companyName" class="form-control" placeholder="Company Name" value="<?php echo $companyName ?>" >
                  </div>
                  <div class="form-group">
                    <label>Head Office Address*</label>
                    <textarea name="headOfficeAddress" rows="3" class="form-control"><?php echo $headOfficeAddress  ?></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <label>Town/City*</label>
                      <input type="text" name="townCity" class="form-control" 
                      placeholder="Town or city" value="<?php echo $townCity ?>" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <label>Post Code</label>
                      <input type="number" name="postCode" class="form-control" placeholder="Post code" value="<?php echo $postCode  ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <label>State / County*</label>
                      <input type="text" name="stateCounty" class="form-control" placeholder="State or County" value="<?php echo $stateCounty ?>" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <label>Country*</label>
                      <select name="country" id="county" class="form-control" >
                      <?php echo $countriesOption ?>                         
                      </select>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <label>Telephone 1* (Full International number)</label>
                      <input type="text" name="telephone1" class="form-control" placeholder="" value="<?php echo $telephone1 ?>" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <label>Telephone 2 (Full International number)</label>
                      <input type="text" name="telephone2" class="form-control" placeholder="" value="<?php echo $telephone2 ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Operational Address</label>
                    <textarea name="operationalAddress" class="form-control" rows="3"><?php echo $operationalAddress ?></textarea>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                      <label>Email Address*</label>
                      <input type="text" name="emailAddress" class="form-control" placeholder="" value="<?php echo $emailAddress ?>" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <label>Website</label>
                      <input type="text" name="website" class="form-control" value="<?php echo $website ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 col-sm-6">
                       <label>Previous Company Name</label>
                       <input type="text" name="previousCompanyName" class="form-control" value="<?php echo $previousCompanyName ?>">
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <label>Previous Company Address</label>
                      <input type="text" name="previousCompanyAddress" class="form-control" value="<?php echo $previousCompanyAddress ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Additional Information / Comments</label>
                    <textarea name="additionalInformation" class="form-control"><?php echo $additionalInformation ?></textarea>
                  </div>
              </div>
            </div>
          </div>
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
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<?php echo $footer; ?>