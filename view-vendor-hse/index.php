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
                    <tr>
                      <td>
                        <strong>Does your company have a documented and functional HSE policy? *</strong>
                      </td>
                      <td>
                        <?php echo $hsePolicyYes ?>
                        <?php echo $hsePolicyNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        When was the last review date?*
                      </td>
                      <td>
                        <?php echo $lastReview ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Person responsible for HSC*
                      </td>
                      <td>
                        <?php echo $nameOfPerson ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Contact Phone No (Intl No)*
                      </td>
                      <td>
                        <?php echo $contactTelephoneNumber ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Contact Email*
                      </td>
                      <td>
                        <?php echo $contactEmail ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Are staff made aware of your policy and objectives?*
                      </td>
                      <td>
                        <?php echo $hsePolicyYes ?>
                        <?php echo $hsePolicyNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Do you have a formal risk assessment process that identifies hazards and risks?*
                      </td>
                      <td>
                        <?php echo $assessmentProcessYes ?>
                        <?php echo $assessmentProcessNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Do you have formal contingency plans to deal with incidents occurring as a result of hazards?*
                      </td>
                      <td>
                        <?php echo $contingencyPlansYes ?>
                        <?php echo $contingencyPlansNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Do you have a formal accident reporting procedure and follow up process?*
                      </td>
                      <td>
                        <?php echo $accidentReportingYes ?>
                        <?php echo $accidentReportingNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Do you provide your workforce with adequate PPE?*
                      </td>
                      <td>
                        <?php echo $yourWorkforceYes ?>
                        <?php echo $yourWorkforceNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Do you have a system to treat minor incidents and near misses?*
                      </td>
                      <td>
                        <?php echo $minorIncidentsYes ?>
                        <?php echo $minorIncidentsNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                       Do you provide training to ensure staff awareness of HSE requirements?*
                      </td>
                      <td>
                        <?php echo $staffAwarenessYes ?>
                        <?php echo $staffAwarenessNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      If Yes, is the training provided as internal or external training?*
                      </td>
                      <td>
                        <?php echo $internalOrExternalYes ?>
                        <?php echo $internalOrExternalNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      Do you have a system to ensure that training requirements are up to date?*
                      </td>
                      <td>
                        <?php echo $trainingRequirementsYes ?>
                        <?php echo $trainingRequirementsNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                      Does your company assess the competence of your subcontractors with respect to HSE matters?*
                      </td>
                      <td>
                        <?php echo $subcontractorsYes ?>
                        <?php echo $subcontractorsNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Does your company use systems to reduce the risks associated with driving and transport?*
                      </td>
                      <td>
                        <?php echo $risksAssociatedYes ?>
                        <?php echo $risksAssociatedNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Does your company have a documented drugs / Alcohol abuse policy authorised by a senior officer?*
                      </td>
                      <td>
                        <?php echo $drugsAlcoholYes ?>
                        <?php echo $drugsAlcoholNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Does your company conduct monitoring / internal audits of your HSE arrangements to demonstrate the effectiveness of the system?*
                      </td>
                      <td>
                        <?php echo $internalAuditsYes ?>
                        <?php echo $internalAuditsNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Do you have health Insurance scheme?*
                      </td>
                      <td>
                        <?php echo $healthInsuranceYes ?>
                        <?php echo $healthInsuranceNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Additional Information / Comments
                      </td>
                      <td>
                        <?php echo $additionalInfo1 ?>
                      </td>
                    </tr>

                  </tbody>
                </table>
               	
                <h2>Management Systems</h2>
                <!-- <div class="clearfix"></div><hr><br /> -->
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>
                        Does your company have a documented HSE management system?
                      </td>
                      <td>
                        <?php echo $managementSystemYes ?>
                        <?php echo $managementSystemNo ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        State applicable standards or guidelines used?
                      </td>
                      <td>
                        <?php echo $standardsOrGuidelinesYes ?> 
                        <?php echo $standardsOrGuidelinesNo ?> 
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Is the System Certified?
                      </td>
                      <td>
                        <?php echo $systemCertifiedYes ?> 
                        <?php echo $systemCertifiedNo ?> 
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Name of Certifying body
                      </td>
                      <td>
                        <?php echo $nameOfCertifyingBody ?> 
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Certificate Number
                      </td>
                      <td>
                        <?php echo $certificateNumber ?> 
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Expiry Date
                      </td>
                      <td>
                        <?php echo $expiryDate ?> 
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Is your company working towards it?
                      </td>
                      <td>
                        <?php echo $companyWorkingYes ?> 
                        <?php echo $companyWorkingNo ?> 
                      </td>
                    </tr>
                  </tbody>
                </table>
                  
                <h2>Statistical Data <small style="color:red;font-style: italic;">(Incidence Record)</small></h2>
                <!-- <div class="clearfix"></div><hr><br /> -->
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
                        <?php echo $year1['calender year1'] ?>
                    </td> 
                    <td>
                       <?php echo $year2['calender year2'] ?>
                    </td> 
                    <td>
                       <?php echo $year3['calender year3'] ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      Total Man-hours*
                    </td>
                    <td>
                      <?php echo $year1['total manh1'] ?>
                    </td> 
                    <td>
                      <?php echo $year2['total manh2'] ?>
                    </td>
                    <td>
                      <?php echo $year3['total manh3'] ?>
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      Lost Time Incidents *
                    </td>
                    <td>
                      <?php echo $year1['lost time1'] ?>
                    </td> 
                    <td>
                      <?php echo $year2['lost time2'] ?>
                    </td>
                    <td>
                      <?php echo $year3['lost time3'] ?>
                    </td> 
                  </tr>
                  <tr>
                    <td>
                     Number of Fatalities*
                    </td>
                    <td>
                      <?php echo $year1['number of facilities1'] ?>
                    </td> 
                    <td>
                      <?php echo $year2['number of facilities2'] ?>
                    </td>
                    <td>
                     <?php echo $year3['number of facilities3'] ?>
                    </td> 
                  </tr>
                  <tr>
                    <td>
                      Additional Information / Comments
                    </td>
                    <td colspan="3">
                      <?php echo $additionalInfo3 ?>
                    </td>
                  </tr>
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