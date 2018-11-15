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
            <form id="demo-form2" method="post" action="<?php echo htmlentities("processor.php") ?>" data-parsley-validate class="form">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Health, Safety And Environmental (HSE) Information</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>

								<!-- Health & Safety BEGINNING -->
                <div class="x_content">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    <div class="form-group">
                      <p><strong>Does your company have a documented and functional HSE policy? *</strong></p>
                      <label class="radio-inline">
                        <input type="radio" class = "required" required name="hsePolicy" onclick="showContent()" <?php echo $hsePolicyYes ?> value="Yes">Yes</label>
                      <label class="radio-inline">
                        <input type="radio" class = "required" id="no" onclick="hideContent()" <?php echo $hsePolicyNo ?> name="hsePolicy" value="No">No</label>
                    </div>



									<!-- To hide BEGINNING -->
									<div id="hide">
                    <div class="form-group">
                      <label>When was the last review date?*</label>
                      <input type="date" name="lastReview" value="<?php echo $lastReview ?>" class="form-control required" >
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                          <div class="form-group">
                            <label>Person responsible for HSC*</label>
                            <input type="text" name="nameOfPerson" value="<?php echo $nameOfPerson ?>" class="form-control required" >
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                          <div class="form-group">
                            <label>Contact Phone No (Intl No)*</label>
                            <input type="text" name="contactTelephoneNumber" value="<?php echo $contactTelephoneNumber ?>" class="form-control required"  placeholder="">
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                          <div class="form-group">
                            <label>Contact Email*</label>
                            <input type="text" name="contactEmail" value="<?php echo $contactEmail ?>" class="form-control required"  placeholder="">
                          </div>
                        </div>
                    </div>
                   <div class="row">
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Are staff made aware of your policy and objectives?*</strong></p>
                       <label class="radio-inline">
                        <input type="radio" class = "required"  name="yourPolicy" <?php echo $hsePolicyObjectiveYes ?> value="Yes">Yes</label>
                       <label class="radio-inline">
                        <input type="radio" class = "required" <?php echo $hsePolicyObjectiveNo ?> name="yourPolicy" value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Do you have a formal risk assessment process that identifies hazards and risks?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                        name="assessmentProcess" <?php echo $assessmentProcessYes  ?> value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required" <?php echo $assessmentProcessNo ?> name="assessmentProcess" value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Do you have formal contingency plans to deal with incidents occurring as a result of hazards?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                         <?php echo $contingencyPlansYes ?> name="contingencyPlans" value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required" name="contingencyPlans"
                        <?php echo $contingencyPlansNo ?> value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Do you have a formal accident reporting procedure and follow up process?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $accidentReportingYes  ?> name="accidentReporting" value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $accidentReportingNo  ?> name="accidentReporting" value="No">No</label>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Do you provide your workforce with adequate PPE?*</strong></p>
                       <label class="radio-inline">
                        <input type="radio" class = "required"  name="yourWorkforce"
                        <?php echo $yourWorkforceYes ?> value="Yes">Yes
                       </label>
                       <label class="radio-inline"><input type="radio" class = "required" name="yourWorkforce"
                        <?php echo $yourWorkforceNo ?> value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Do you have a system to treat minor incidents and near misses?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"  name="minorIncidents"
                        value="Yes" <?php echo $minorIncidentsYes ?>>Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required" name="minorIncidents"
                        <?php echo $minorIncidentsNo ?> value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <p><strong>Do you provide training to ensure staff awareness of HSE requirements?*</strong></p>
                        <label class="radio-inline"><input type="radio" class = "required"
                          <?php echo $staffAwarenessYes ?> name="staffAwareness" value="Yes">Yes</label>
                        <label class="radio-inline"><input type="radio" class = "required" name="staffAwareness"
                          <?php echo $staffAwarenessNo ?> value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>If Yes, is the training provided as internal or external training?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                        name="internalOrExternal" <?php echo $internalOrExternalYes ?> value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required" name="internalOrExternal"
                        <?php echo $internalOrExternalNo ?> value="No">No</label>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Do you have a system to ensure that training requirements are up to date?*</strong></p>
                       <label class="radio-inline">
                        <input type="radio"
                        <?php echo $trainingRequirementsYes ?> name="trainingRequirements"
                        value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio"
                        <?php echo $trainingRequirementsNo ?> name="trainingRequirements"
                        value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Does your company assess the competence of your subcontractors with respect to HSE matters?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $subcontractorsYes  ?> name="subcontractors" value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $subcontractorsNo ?> name="subcontractors" value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                        <p><strong>Does your company use systems to reduce the risks associated with driving and transport?*</strong></p>
                        <label class="radio-inline"><input type="radio" class = "required"
                          <?php echo $risksAssociatedYes  ?> name="risksAssociated" value="Yes">Yes</label>
                        <label class="radio-inline"><input type="radio" class = "required" name="risksAssociated"
                          <?php echo $risksAssociatedNo  ?> value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-3">
                       <p><strong>Does your company have a documented drugs / Alcohol abuse policy authorised by a senior officer?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $drugsAlcoholYes ?> name="drugsAlcohol" value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $drugsAlcoholNo ?> name="drugsAlcohol" value="No">No</label>
                     </div>
                   </div>
                   <div class="row">
                     <div class="col-sm-6 col-md-7">
                       <p><strong>Does your company conduct monitoring / internal audits of your HSE arrangements to demonstrate the effectiveness of the system?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"  name="internalAudits"
                        <?php echo $internalAuditsYes ?> value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required" name="internalAudits"
                        <?php echo $internalAuditsNo ?> value="No">No</label>
                     </div>
                     <div class="col-sm-6 col-md-12">
                       <p><strong>Do you have health Insurance scheme?*</strong></p>
                       <label class="radio-inline"><input type="radio" class = "required"
                        <?php echo $healthInsuranceYes ?> name="healthInsurance" value="Yes">Yes</label>
                       <label class="radio-inline"><input type="radio" class = "required" name="healthInsurance"
                        <?php echo $healthInsuranceNo ?> value="No">No</label>
                     </div>
                   </div>
                    <div class="form-group">
                      <label>Additional Information / Comments</label>
                      <textarea name="additionalInfo1" class="form-control required" rows="3"><?php echo $additionalInfo1 ?></textarea>
                    </div>
                </div>
							</div>
							<!-- To hide END -->
							<!-- Health & Safety END -->


            </div>


              <!-- Management Systems -->
              <div class="x_panel">
                <div class="x_title">
                  <h2>Management Systems</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                      <div class="col-sm-4 col-md-4">
                        <p>Does your company have a documented HSE management system?</p>
                        <label class="radio-inline"><input type="radio" class = "required" name="managementSystem"
                          <?php echo $managementSystemYes ?> value="Yes" onclick="showContent('true')">Yes</label>
                        <label class="radio-inline"><input type="radio" class = "required"
                          <?php echo $managementSystemNo ?> name="managementSystem" value="No" onclick="hideContent('true')">No</label>
                      </div>

											<div class="hide_management col-sm-4 col-md-4">
												<p>State applicable standards or guidelines used?</p>
												<label class="radio-inline"><input type="radio" class = "required"
													<?php echo $standardsOrGuidelinesYes ?> name="standardsOrGuidelines" value="Yes">Yes</label>
												<label class="radio-inline"><input type="radio" class = "required"
													<?php echo $standardsOrGuidelinesNo ?> name="standardsOrGuidelines" value="No">No</label>
											</div>

											<div class="hide_management col-sm-4 col-md-4">
												<p>Is the System Certified??</p>
												<label class="radio-inline"><input type="radio" class = "required"
													<?php echo $systemCertifiedYes  ?> name="systemCertified" value="Yes">Yes</label>
												<label class="radio-inline"><input type="radio" class = "required"
													<?php echo $systemCertifiedNo  ?> name="systemCertified" value="No">No</label>
											</div>
	                   </div>

											<div class="hide_management">
	                    <div class="row">
												<br />
	                      <div class="col-sm-6 col-md-6">
	                        <div class="form-group">
	                          <label>Name of Certifying body</label>
	                          <input type="text" name="nameOfCertifyingBody" value="<?php echo $nameOfCertifyingBody ?>" class="form-control required" placeholder="">
	                        </div>
	                      </div>
	                      <div class="col-sm-6 col-md-6">
	                        <div class="form-group">
	                          <label>Certificate Number</label>
	                          <input type="text" name="certificateNumber" value="<?php echo $certificateNumber ?>" class="form-control required" placeholder="">
	                        </div>
	                      </div>
	                    </div>

	                    <div class="row">
	                      <div class="col-sm-12 col-md-12">
	                        <div class="form-group">
	                          <label>Expiry Date</label>
	                          <input type="date" name="expiryDate" class="form-control required"
	                          value="<?php echo $expiryDate ?>">
	                        </div>
	                      </div>
	                      <div class="col-sm-12 col-md-12">
	                        <div class="form-group">
	                          <p><strong>Is your company working towards it?</strong></p>
	                          <label class="radio-inline"><input type="radio" class = "required" name="companyWorking"
	                            <?php echo $companyWorkingYes  ?> value="Yes">Yes</label>
	                          <label class="radio-inline"><input type="radio" class = "required" name="companyWorking"
	                            <?php echo $companyWorkingNo ?> value="No">No</label>
	                        </div>
	                      </div>
                    </div>
                </div>
                </div>
              </div>


              <!-- Statistical Data (Incidence Record) -->
              <div class="x_panel">
              	<div class="x_title">
                  <h2>Statistical Data</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered">
                      <tr>
                        <th></th>
                        <th>Year(1)</th>
                        <th>Year(2)</th>
                        <th>Year(3)</th>
                      </tr>
                      <tr>
                        <td>
                          Calender Year
                        </td>
                        <td>
                          <select name="calenderYear1" class="form-control required" id="">
                            <?php echo $option1 ?>
                          </select>
                        </td>
                        <td>
                          <select name="calenderYear2" class="form-control required" id="">
                           <?php echo $option2 ?>
                          </select>
                        </td>
                        <td>
                          <select name="calenderYear3" class="form-control required" id="">
                            <?php echo $option3 ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Total Man-hours*
                        </td>
                        <td>
                          <input type="number" name="totalManHours1" required="required"  class="form-control required" placeholder="0 if no data" value="<?php echo $year1['total manh1'] ?>">
                        </td>
                        <td>
                          <input type="number" name="totalManHours2" required="required" class="form-control required" placeholder="0 if no data" value="<?php echo $year2['total manh2'] ?>">
                        </td>
                        <td>
                          <input type="number" name="totalManHours3" required="required" class="form-control required" placeholder="0 if no data" value="<?php echo $year3['total manh3'] ?>">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Lost Time Incidents *
                        </td>
                        <td>
                          <input type="number" name="lostTimeIncidents1" required="required" class="form-control required" placeholder="0 if no incident" value="<?php echo $year1['lost time1'] ?>">
                        </td>
                        <td>
                          <input type="number" name="lostTimeIncidents2" required="required" class="form-control required" value="<?php echo $year2['lost time2'] ?>" placeholder="0 if no incident">
                        </td>
                        <td>
                          <input type="number" name="lostTimeIncidents3" required="required" class="form-control required" value="<?php echo $year3['lost time3'] ?>" placeholder="0 if no incident">
                        </td>
                      </tr>
                      <tr>
                        <td>
                         Number of Fatalities*
                        </td>
                        <td>
                          <input type="number" name="numberOfFatalities1" required="required"  class="form-control required" placeholder="0 if no fatality"
                          value="<?php echo $year1['number of facilities1'] ?>">
                        </td>
                        <td>
                          <input type="number" name="numberOfFatalities2" required="required" class="form-control required"
                          value="<?php echo $year2['number of facilities2'] ?>" placeholder="0 if no fatality">
                        </td>
                        <td>
                          <input type="number" name="numberOfFatalities3" required="required" class="form-control required"
                          value="<?php echo $year3['number of facilities3'] ?>" placeholder="0 if no fatality">
                        </td>
                      </tr>
                    </table>
                    <div class="form-group">
                      <label>Additional Information / Comments</label>
                      <textarea name="additionalInfo3" class="form-control required" rows="3"><?php echo $additionalInfo3 ?></textarea>
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
<script src=""></script>
<?php echo $footer; ?>
