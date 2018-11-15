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
              <div class="row">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $companyName ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-12">
                          <table class="table table-bordered">
                            <tr>
                              <td>First year registered in Nigeria (Year Business Commenced)</td>
                              <td><?php if(isset($firstYear)) echo $firstYear; ?></td>
                            </tr>
                            <tr>
                              <td>Company type</td>
                              <td><?php if(isset($companyType)) echo $companyType; ?></td>
                            </tr>
                            <tr>
                              <td>Country of registration</td>
                              <td><?php if(isset($countryRegistration)) echo $countryRegistration; ?></td>
                            </tr>
                            <tr>
                              <td>CAC number</td>
                              <td><?php if(isset($cacNumber)) echo $cacNumber; ?></td>
                            </tr>
                            <tr>
                              <td>Registration year</td>
                              <td><?php if(isset($registrationYear)) echo $registrationYear; ?></td>
                            </tr>
                            <tr>
                              <td>Additional Information/Comments</td>
                              <td><?php if(isset($additionalComment)) echo $additionalComment; ?></td>
                            </tr>
                            <tr>
                              <td>Company Ownership</td>
                              <td><?php if(isset($shareholders)) echo $shareholders; ?></td>
                            </tr>
                            <tr>
                              <td>Associated Company</td>
                              <td><?php if(isset($associatedName)) echo $associatedName; ?></td>
                            </tr>
                          </table>
                          <?php echo $questionnaireMenu; ?>
                        </div>
                      </div>
                    </div>
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
<script type="text/javascript" src=""></script>
<?php echo $footer; ?>