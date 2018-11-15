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
                <div class="row">
                  <div class="col-sm-2 col-sm-offset-1">
                    <h4>General</h4>
                    <span id="general" class="chart" data-percent="<?php if(isset($generalCompletion))  echo $generalCompletion ?>">
                     <span class="general-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Legal</h4>
                    <span id="legal" class="chart" data-percent="<?php if(isset($legalCompletion)) echo $legalCompletion ?>">
                     <span class="legal-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Personnel</h4>
                    <span id="personnel" class="chart" data-percent="<?php if(isset($personnelCompletion)) echo $personnelCompletion ?>">
                     <span class="personnel-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Finance</h4>
                    <span id="finance" class="chart" data-percent="<?php if(isset($financeCompletion)) echo $financeCompletion ?>">
                     <span class="finance-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>HSE Information</h4>
                    <span id="hse" class="chart" data-percent="<?php if(isset($hseCompletion))  echo $hseCompletion ?>">
                     <span class="hse-percent percent">0</span>
                    </span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2 col-sm-offset-1">
                    <h4>QMS Information</h4>
                    <span id="qms" class="chart" data-percent="<?php if(isset($qmsCompletion)) echo $qmsCompletion ?>">
                     <span class="qms-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Product and Services</h4>
                    <span id="product" class="chart" data-percent="<?php if(isset($productCompletion)) echo $productCompletion ?>">
                     <span class="product-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Nigerian Content</h4>
                    <span id="nigerianContent" class="chart" data-percent="<?php if(isset($nigerianContentcompletion)) echo $nigerianContentcompletion ?>">
                     <span class="nigerian-content-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Declaration</h4>
                    <span id="declaration" class="chart" data-percent="<?php if(isset($declarationCompletion)) echo $declarationCompletion ?>">
                     <span class="declaration-percent percent">0</span>
                    </span>
                  </div>
                  <div class="col-sm-2">
                    <h4>Total Completion</h4>
                    <span id="total" class="chart" data-percent="<?php if(isset($totalCompletion)) echo $totalCompletion ?>">
                     <span class="total-percent percent">0</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <?php echo $response; ?>         
          <div class="row">
            <form id="demo-form2" data-parsley-validate class="form" action="<?php echo htmlentities("processor.php")?>" method="post">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Submission</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content">
                        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                        <input type="hidden" name="status" value="review in progress" />
                        <div class="row">
                          <div class="checkbox">
                            <label for="agree">
                            <input type="checkbox" id="agree" name="agree" checked required>I agree
                            </label>
                          </div>
                        </div>
                        <p>Please note: By agreeing to proceed, you agree to the <a href="<?php echo URL ?>document/nipex-terms-and-condition.pdf" target='_blank'>Terms & Conditions</a></p>
                    </div>
                  </div>
                </div>
            </div>
              <!-- save button panel -->
              <div class="x_panel">
                <div class="x_content">
                  <button <?php echo $disableSave; ?> type="submit" name="save" class="btn btn-success" <?php if($totalCompletion != 100) echo 'disabled' ?>>Save</button>
                </div>
              </div>
            </form>
          </div>
      </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<script type="text/javascript" src=""></script>
<?php echo $footer; ?>