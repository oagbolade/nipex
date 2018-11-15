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
        <form method="post" action="processor.php" class="form-vertical">
         <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Legal General</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="firstYear">First year registered in Nigeria (Year Business Commenced) <span class="">*</span>
                            </label>
                            <input maxlength="4" placeholder="1960" type="text" id="firstYear" value="<?php if(isset($firstYear)) echo $firstYear; ?>" class="form-control" name="firstYear">
                          </div>
                          <div class="form-group">
                            <label for="companyType">Company type<span class="">*</span>
                            </label>
                              <input maxlength="128" type="text" id="companyType" value="<?php if(isset($companyType)) echo $companyType; ?>"  name="companyType" class="form-control" >
                          </div>
                          <div class="form-group">
                            <label for="countryRegistration">Country of registration<span class="">*</span></label>
                              <select class="form-control" name="countryRegistration" id="countryRegistration" >
                                <?php echo $countriesOption ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="cacNumber" class="control-label">CAC number<span class="">*</span></label>
                              <input id="cacNumber" class="form-control" value="<?php if(isset($cacNumber)) echo $cacNumber; ?>"  type="text" name="cacNumber" >
                          </div>
                          <div class="form-group">
                            <label for="registrationYear" class="control-label">Registration year<span class="">*</span></label>
                              <input maxlength="4" placeholder="1960" id="registrationYear" value="<?php if(isset($registrationYear)) echo $registrationYear; ?>" class="form-control" type="text" name="registrationYear" >
                          </div>
                          <div class="form-group">
                            <label for="additionalComment">Additional Information/Comments</label>
                              <textarea id="additionalComment" class="form-control" name="additionalComment"><?php if(isset($additionalComment)) echo $additionalComment; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row" id="companyOwner">
                  <div class="col-sm-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Company Ownership*</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                          <div class="form-group">
                            <table class="table">
                            	<thead>
		                          		<tr>
		                                <td>
		                                  Director
		                                </td>
		                                <td>
		                                  Nationality
		                                </td>
		                                <td>
		                                  Gender
		                                </td>
		                                <td>
		                                	Percentage Ownership
		                                </td>
		                                <td></td>
		                              </tr>
                              </thead>
                              <tbody class="al_op_ownership">
                              	<?php if(isset($shareholder)) echo $shareholder ;?>
                              </tbody>
                            </table>
                            <button <?php echo $disableSave; ?> type="button" class="btn btn-sm btn-primary" id="al_op_ownership_btn">+</button>
                          </div>
                      </div>
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Associated Company</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div class="form-group">
                          <label for="associatedName">Associated company name</label>
                          <input id="associatedName" value="<?php if(isset($associatedName)) echo $associatedName; ?>" class="form-control" type="text" name="associatedName">
                        </div> 
                      </div>
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
<script type="text/javascript" src=""></script>
<?php echo $footer; ?>