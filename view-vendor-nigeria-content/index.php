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
                <h2><?php echo $companyName ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>
                        Indicate that you have a Nigerian content policy ?*
                      </td>
                      <td>
                        <?php echo $checkNigeriaContentYes; ?>
                        <?php echo $checkNigeriaContentNo; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Nigerian Contact Name *
                      </td>
                      <td>
                        <?php echo $nigeriaContact; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Email Address*
                      </td>
                      <td>
                        <?php echo $emailAddress; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Contact Telephone Number (Full International Number)*
                      </td>
                      <td>
                        <?php echo $contactTelephone; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Have you got a Pension Scheme? *
                      </td>
                      <td>
                        <?php echo $pensionSchemeYes; ?>
                        <?php echo $pensionSchemeNo; ?>
                      </td>
                    </tr>
                   
                  </tbody>
                </table>
                <?php echo $questionnaireMenu; ?>
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