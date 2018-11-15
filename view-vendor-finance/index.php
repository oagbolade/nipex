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
                <?php echo $response; ?>
              </div>
              <div class="x_content">
                  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>"/>
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
                          <?php echo $year1["Audited Accounts"]; ?>
                        </td>
                        <td>
                          <?php echo $year2["Audited Accounts"]; ?>
                        </td>
                        <td>
                          <?php echo $year3["Audited Accounts"]; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Reporting Currency</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Reporting Currency"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Reporting Currency"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Reporting Currency"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Year Ending Month</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Year Ending Month"]; ?>
                            </div>
                        </td>
                        <td>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Year Ending Month"]; ?>
                          </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Year Ending Month"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Audited Accounts</th>
                        <td>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year1["Audited Accounts"]; ?>
                          </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Audited Accounts"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Audited Accounts"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Annual Turnover</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Annual Turnover"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Annual Turnover"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Annual Turnover"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">% of Annual Turnover in Nigeria</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["percent Turnover"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["percent Turnover"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["percent Turnover"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Profit before tax</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Profit before tax"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Profit before tax"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Profit before tax"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Total Assets</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Total Assets"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Total Assets"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Total Assets"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Current Assets</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Current Assets"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Current Assets"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Current Assets"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Total Short Term liabilities</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year1["Total Short Term liabilities"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year2["Total Short Term liabilities"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $year3["Total Short Term liabilities"]; ?>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Total Net Assets</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year1['Total Net Assets']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year2['Total Net Assets']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year3['Total Net Assets']; ?>
                            </div>
                        </td>
                      </tr><tr>
                        <th scope="row">Issued Share Capital</th>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year1['Issued Share Capital']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year2['Issued Share Capital']; ?>
                            </div>
                        </td>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <?php echo $year3['Issued Share Capital']; ?>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- the first table ends here -->
                  <h3>Insurance Scheme</h3>
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td>Workman Compensation Insurance scheme in operation (NSITF)?*
                        </td>
                        <td>
                          <?php echo $workmanInsuranceYes ?>
                          <?php echo $workmanInsuranceNo ?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          If Yes, please provide certificate Number*
                        </td>
                        <td>
                          <?php echo $insuranceNumber ?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Value of Insurance*
                        </td>
                        <td>
                          <?php echo $valueInsurance ?>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Additional Information / Comments
                        </td>
                        <td>
                          <?php echo $comments1 ?>
                        </td>
                      </tr>
                      
                    </tbody>
                  </table>
               
                  <div class="row">
                    <div>
                      <h3>Other Financial Information</h3><hr style="margin-top: 0;">
                    </div>
                    <!-- second table starts here -->
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
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['Name']; ?>
                              </div>
                          </td>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $auditor['Name']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Address Line 1*</th>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['Address Line 1']; ?>
                              </div>
                          </td>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $auditor['Address Line 1']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Address Line 2</th>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['Address Line 2']; ?>
                              </div>
                          </td>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $auditor['Address Line 2']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Town*</th>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['Town']; ?>
                              </div>
                          </td>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $auditor['Town']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">State / Country*</th>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['State']; ?>
                              </div>
                          </td>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                               <?php echo $auditor['Town']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Post Code</th>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['Post Code']; ?>
                              </div>
                          </td>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $auditor['Post Code']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Country*</th>
                          <td>
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $banker['Country']; ?>
                              </div>
                          </td>
                          <td>
                            <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php echo $auditor['Country']; ?>
                              </div>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">Additional Information / Comments</th>
                          <td colspan="2">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                               <!-- <?php echo $banker['Country']; ?>-->
                              </div>
                          </td>
                          <!-- <td></td> -->
                        </tr>
                      </tbody>
                    </table>
                    <!-- second table ends here -->
                    <?php echo $questionnaireMenu; ?>
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
<?php echo $footer; ?>