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
                  <h2>Quality Management System (QMS) Information</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    <div class="row">
                      <div class="col-md-3">
                        <p>Do you have a documented quality management system?</p>
                      </div>
                      <div class="col-md-9">
                        <input type="radio" value="yes" name="documentedQms" <?php echo $documentedQmsYes; ?> required>Yes &nbsp;&nbsp;
                        <input type="radio" value="no" name="documentedQms" <?php echo $documentedQmsNo; ?> required>No
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Do you have a documented and functional quality policy authorised by a senior officer?</p>
                      </div>
                      <div class="col-md-9">
                        <input type="radio" value="yes" name="documentedPolicy" <?php echo $documentedPolicyYes; ?> required>Yes &nbsp;&nbsp;
                        <input type="radio" value="no" name="documentedPolicy" <?php echo $documentedPolicyNo; ?> required>No
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>When was the last review date?</p>
                      </div>
                      <div class="col-md-3 form-group">
                        <input type="date" name="lastReviewDate" class="form-control" value="<?php echo $lastReviewDate; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Are staff made aware of your policy and objectives?</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="radio" value="yes" name="policyObjective" <?php echo $policyObjectiveYes; ?> required>Yes &nbsp;&nbsp;
                        <input type="radio" value="no" name="policyObjective" <?php echo $policyObjectiveNo; ?> required>No
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Is the system certified?</p>
                      </div>
                      <div class="col-md-9">
                        <input type="radio" value="yes" name="systemCertified" <?php echo $systemCertifiedYes; ?> required>Yes &nbsp;&nbsp;
                        <input type="radio" value="no" name="systemCertified" <?php echo $systemCertifiedNo; ?> required>No
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>State the relevant standard</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="text" name="relevantStandard" value="<?php echo $relevantStandard; ?>" class="form-control col-md-12" >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Name of certifying authority</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="text" name="certifyingAuthority" value="<?php echo $certifyingAuthority; ?>" class="form-control col-md-12" >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Certificate Number</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="text" name="certificateNumber" value="<?php echo $certificateNo; ?>" class="form-control col-md-12">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Do you have any plans to achieve third party accreditation ?</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="radio" value="yes" name="partyAccreditation" <?php echo $partyAccreditationYes; ?> required>Yes &nbsp;&nbsp;
                        <input type="radio" value="no" name="partyAccreditation" <?php echo $partyAccreditationNo; ?> required>No
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Name of person responsible for QMS</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="text" name="responsibleForQms" class="form-control col-md-12" value="<?php echo $responsibleForQms; ?>" placeholder="Name">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Contact Telephone Number (Full International Number)</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="text" name="contactNumber" class="form-control col-md-12" value="<?php echo $contactNumber; ?>" placeholder="080*********">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Contact email address</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <input type="email" name="contactEmail" class="form-control col-md-12" value="<?php echo $contactEmail; ?>" placeholder="info@contact.com">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>Additional Information / Comments</p>
                      </div>
                      <div class="col-md-9 form-group">
                        <textarea name="comments" class="form-control"><?php echo $comments; ?></textarea>
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
      </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<?php echo $footer; ?>