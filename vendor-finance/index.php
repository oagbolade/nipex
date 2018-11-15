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
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
          	<form action="<?php echo htmlentities("processor.php"); ?>" method="post">
            <div class="x_panel">
              <div class="x_title">
                <h2>Financial Information</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
                <?php echo $response; ?>
              </div>
              <div class="x_content">
                  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                  <!-- the first table starts here -->
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Year (Last Audited)</th>
                        <th>Year (2)</th>
                        <th>Year (1)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">Accounting Year</th>
                        <td> 
                          <select class="form-control" name="accountingYear1">
                            <?php echo $yearOneAccount; ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="accountingYear2">
                            <?php echo $yearTwoAccount; ?>
                          </select>
                        </td>
                        <td>
                          <select class="form-control" name="accountingYear3">
                            <?php echo $yearThreeAccount; ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Reporting Currency</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="reportingCurrency1">
                                <?php echo $value1; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="reportingCurrency2">
                                <?php echo $value2; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="reportingCurrency3">
                                <?php echo $value3; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Year Ending Month</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="yearEnding1">
                                <?php echo $optionMonth1 ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="yearEnding2">
                                <?php echo $optionMonth2 ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="yearEnding3">
                                <?php echo $optionMonth3 ?>
                              </select>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Audited Accounts</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="auditedAccount1">
                                <?php echo $yearOneOptions; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="auditedAccount2">
                                <?php echo $yearTwoOptions; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <select class="form-control" name="auditedAccount3">
                                <?php echo $yearThreeOptions; ?>
                              </select>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Annual Turnover</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="annualTurnover1" value="<?php echo $year1['Annual Turnover']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <!-- <input type="text" class="form-control" name="annualTurnover2" > -->
                              <input type="text" class="form-control" name="annualTurnover2" value="<?php echo $year2['Annual Turnover']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <!-- <input type="text" class="form-control" name="annualTurnover3" > -->
                              <input type="text" class="form-control" name="annualTurnover3" value="<?php echo $year3['Annual Turnover']; ?>">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">% of Annual Turnover in Nigeria</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="perCentTurnover1" value="<?php echo  $year1['percent Turnover']; ?>">
                              <!-- <input type="text" class="form-control" name="perCentTurnover1"> -->
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="perCentTurnover2" value="<?php echo $year2['percent Turnover'];; ?>">
                             <!--  <input type="text" class="form-control" name="perCentTurnover2"> -->
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="perCentTurnover3" value="<?php  echo $year3['percent Turnover'];; ?>">
                             <!--  <input type="text" class="form-control" name="perCentTurnover3"> -->
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Profit before tax</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="profit1" value="<?php echo $year1['Profit before tax']; ?>">
                              
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="profit2" value="<?php  echo $year2['Profit before tax']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="profit3" value="<?php echo $year3['Profit before tax']; ?>">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Total Assets</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalAsset1" value="<?php echo $year1['Total Assets']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalAsset2" value="<?php echo $year2['Total Assets']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalAsset3" value="<?php echo $year3['Total Assets']; ?>">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Current Assets</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="currentAsset1" value="<?php echo $year1['Current Assets']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="currentAsset2" value="<?php echo $year2['Current Assets'];; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="currentAsset3" value="<?php echo $year3['Current Assets'];; ?>">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Total Short Term liabilities</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalLiabilty1" value="<?php echo $year1['Total Short Term liabilities']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalLiabilty2" value="<?php echo $year2['Total Short Term liabilities']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalLiabilty3" value="<?php echo $year3['Total Short Term liabilities']; ?>">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Total Net Assets</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalNetAsset1" value="<?php echo $year1['Total Net Assets']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalNetAsset2" value="<?php echo $year2['Total Net Assets']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="totalNetAsset3" value="<?php echo $year3['Total Net Assets']; ?>">
                            </div>
                          </div>
                        </td>
                      </tr><tr>
                        <th scope="row">Issued Share Capital</th>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="shareCapital1" value="<?php echo $year1['Issued Share Capital']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="shareCapital2" value="<?php echo $year2['Issued Share Capital']; ?>">
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="shareCapital3" value="<?php echo $year3['Issued Share Capital']; ?>">
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- the first table ends here -->
                  <h4><strong>Please select your Insurance Scheme</strong></h4>
                  <div class="row">
                    <div class="col-md-3">
                      <p>Workman Compensation Insurance scheme in operation (NSITF)?*</p>
                    </div>
                    <div class="col-md-9">
                      <input id="insuranceYes" type="radio" value="yes" name="workmanInsurance" <?php echo $workmanInsuranceYes ?>>Yes &nbsp;&nbsp;
                      <input id="insuranceNo" type="radio" value="no" name="workmanInsurance" <?php echo $workmanInsuranceNo ?>>No
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <p>If Yes, please provide certificate Number*</p>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input id="yes" type="text" name="insuranceNumber" class="jsHandle form-control" value="<?php echo $insuranceNumber ?>" <?php echo $disableInsurance; ?>>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <p>Value of Insurance*</p>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <input type="text" name="valueInsurance" class="jsHandle form-control" value="<?php echo $valueInsurance ?>" <?php echo $disableInsurance; ?>>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <p>Additional Information / Comments</p>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <textarea class="form-control" name="comments1"><?php echo $comments1 ?></textarea>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <!-- second section starts here -->
          	<div class="x_panel">
          		<div class="x_title">
                <h2>Other Financial Information</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
              	<div class="row">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Main Bankers</th>
                          <th>Auditors</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">Name*</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="bankerName" value="<?php echo $banker['Name']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="auditorName"  value="<?php echo $auditor['Name']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Address Line 1*</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="bankerAddress1" class="form-control" value="<?php echo $banker['Address Line 1']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="auditorAddress1" class="form-control" value="<?php echo $auditor['Address Line 1']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Address Line 2</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="bankerAddress2" class="form-control" value="<?php echo $banker['Address Line 2']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="auditorAddress2" class="form-control" value="<?php echo $auditor['Address Line 2']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Town*</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control"  name="bankerTown" value="<?php echo $banker['Town']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="auditorTown" value="<?php echo $auditor['Town']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">State / County*</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="bankerState" value="<?php echo $banker['State']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="auditorState" value="<?php echo $auditor['Town']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Post Code</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="bankerPC" value="<?php echo $banker['Post Code']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="auditorPC" value="<?php echo $auditor['Post Code']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Country*</th>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="bankerCountry" value="<?php echo $banker['Country']; ?>">
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="auditorCountry" value="<?php echo $auditor['Country']; ?>">
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- second table ends here -->
                    <div class="row">
                      <div class="col-md-3">
                        <p>Additional Information / Comments</p>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group">
                          <textarea class="form-control" name="comments2"></textarea>
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
      </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<?php echo $footer; ?>