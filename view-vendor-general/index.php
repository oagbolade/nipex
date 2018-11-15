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
            <h3><?php echo $pageName ?></h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <?php echo $response; ?>
        <div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
             <div class="x_title">
                <h2><?php echo $companyName?></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <tbody>
                    </tr>
                    <tr>
                      <td>
                        Head Office Address*
                      </td>
                      <td>
                        <?php echo $headOfficeAddress ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Town/City*
                      </td>
                      <td>
                        <?php echo $townCity ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Post Code*
                      </td>
                      <td>
                        <?php echo $postCode ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       State / County*
                      </td>
                      <td>
                        <?php echo $stateCounty ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       County*
                      </td>
                      <td>
                        <?php echo $country ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Telephone 1* (Full International number)
                      </td>
                      <td>
                        <?php echo $telephone1 ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Telephone 2* (Full International number)
                      </td>
                      <td>
                        <?php echo $telephone2 ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Operational Address
                      </td>
                      <td>
                        <?php echo $operationalAddress ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Email Address*
                      </td>
                      <td>
                        <?php echo $emailAddress ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Website
                      </td>
                      <td>
                        <?php echo $website ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Previous Company Name
                      </td>
                      <td>
                        <?php echo $previousCompanyName ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Previous Company Address
                      </td>
                      <td>
                        <?php echo $previousCompanyAddress ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Additional Information / Comments
                      </td>
                      <td>
                        <?php echo $additionalInformation ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <?php echo $questionnaireMenu; ?>
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