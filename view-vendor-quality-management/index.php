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
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>
                        Do you have a documented quality management system?
                      </td>
                      <td>
                        <?php echo $documentedQmsYes; ?>
                        <?php echo $documentedQmsNo; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Do you have a documented and functional quality policy authorised by a senior officer?
                      </td>
                      <td>
                        <?php echo $documentedPolicyYes; ?>
                        <?php echo $documentedPolicyNo; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        When was the last review date?
                      </td>
                      <td>
                        <?php echo $lastReviewDate; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Are staff made aware of your policy and objectives?
                      </td>
                      <td>
                        <?php echo $policyObjectiveYes; ?>
                        <?php echo $policyObjectiveNo; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Is the system certified?
                      </td>
                      <td>
                        <?php echo $systemCertifiedYes; ?>
                        <?php echo $systemCertifiedNo; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        State the relevant standard
                      </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Name of certifying authority</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>
                        Certificate Number
                      </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>
                        Do you have any plans to achieve third party accreditation ?
                      </td>
                      <td>
                        <?php echo $partyAccreditationYes; ?>
                        <?php echo $partyAccreditationNo; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Name of person responsible for QMS
                      </td>
                      <td>
                        <?php echo $responsibleForQms; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Contact Telephone Number (Full International Number)
                      </td>
                      <td>
                        <?php echo $contactNumber; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Contact email address
                      </td>
                      <td>
                        <?php echo $contactEmail; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Additional Information / Comments
                      </td>
                      <td>
                        <?php echo $comments; ?>
                      </td>
                    </tr>
                    <tr></tr>
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


<!-- <div class="row">
  <div class="col-md-3">
    <p>Expiry Date</p>
  </div>
  <div class="col-md-3 form-group">
    <input type="date" class="form-control">
  </div>
</div> -->