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
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
            <div class="row">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Company Contact Personnel</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                  <?php echo $response; ?>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="title">Title<span class="">*</span>
                        </label>
                          <input type="text" id="title" class="form-control" name="title" value="<?php echo $title ?>" >
                      </div>
                      <div class="form-group">
                        <label for="first-name">First name<span class="">*</span>
                        </label>
                          <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $firstName ?>" >
                      </div>
                      <div class="form-group">
                        <label for="other-names">Other names</label>
                          <input id="otherNames" class="form-control" type="text" name="otherNames" value="<?php echo $otherNames ?>">
                      </div>
                      <div class="form-group">
                        <label for="surname" class="control-label">Surname<span class="">*</span></label>
                          <input id="surname" class="form-control" type="text" name="surname" value="<?php echo $surname ?>" >
                      </div>
                      <div class="form-group">
                        <label for="jobTitle" class="control-label">Job title<span class="">*</span></label>
                          <input id="jobTitle" class="form-control" type="text" name="jobTitle" value="<?php echo $jobTitle ?>" >
                      </div>
                      <div class="form-group">
                        <label for="address-line1">Address line 1<span class="">*</span></label>
                          <textarea id="address-line1" class="form-control" name="addressLine1" ><?php echo $addressLine1 ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="addressLine2">Address line 2</label>
                          <textarea id="addressLine2" class="form-control" name="addressLine2"><?php echo $firstName ?></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      
                      <div class="form-group">
                        <label for="town">Town<span class="">*</span></label>
                          <input type="text" id="town" class="form-control" name="town" value="<?php echo $town ?>" >
                      </div>
                      <div class="form-group">
                        <label for="state">State<span class="">*</span></label>
                          <input type="text" id="state" class="form-control" name="state" value="<?php echo $state ?>">
                      </div>
                      <div class="form-group">
                        <label for="country">Country<span class="">*</span></label>
                        <select class="form-control" name="country" id="country" >
                          <?php echo $countriesOption ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="postCode">Post code</label>
                          <input type="text" id="postCode" class="form-control" name="postCode" value="<?php echo $postCode ?>">
                      </div>
                      <div class="form-group">
                        <label for="telephone">Telephone (Full international number)<span class="">*</span></label>
                          <input type="text" id="telephone" class="form-control" name="telephone" value="<?php echo $telephone ?>" >
                      </div>
                      <div class="form-group">
                        <label for="emailAddress">Email address<span class="">*</span></label>
                          <input type="text" id="emailAddress" class="form-control" name="email" value="<?php echo $email ?>" >
                      </div>
                      <div class="form-group">
                        <label for="additionalInformation">Additional information/Comments</label>
                          <textarea id="additionalInformation" class="form-control" name="comment"><?php echo $comment ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row" id="companyExecutives">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Executive Personnel</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                      <table class="table">
                      	<thead>
	                        <tr>
	                          <td>
	                            Position
	                          </td>
	                          <td>
	                            Title
	                          </td>
	                          <td>
	                            First name
	                          </td>
	                          <td>
	                            Other name(s)
	                          </td>
	                          <td>
	                            Surname
	                          </td>
	                          <td>
	                            Email
	                          </td>
	                          <td>
	                            Nationality
	                          </td>
	                        </tr>
                        </thead>
                        <tbody class="al_op_executive">
                        	<?php if(isset($executives)) echo $executives; ?>
                        </tbody>
                      </table>
                      <button <?php echo $disableSave; ?> type='button' class='btn btn-sm btn-primary' id='al_op_executive_btn'>+</button>
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Employees</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                      <table class="table">
                        <tr>
                          <td>
                            Calendar
                          </td>
                          <td>
                            Current year (<?php echo date("Y") ?>)
                          </td>
                          <td>
                            Previous year (<?php echo date("Y", strtotime("-1 year")); ?>)
                          </td>
                          <td>
                            Two years ago (<?php echo date("Y", strtotime("-2 year")) ?>)
                          </td>
                        </tr>
                        <tr>
                          <td>
                            Number of staff<span class="">*</span>
                          </td>
                          <td><input type="number" class="form-control" name="currentStaff" value="<?php echo $currentYear['Number of staff'] ?>" ></td>
                          <td><input type="number" class="form-control" name="prevStaff" value="<?php echo $previousYear['Number of staff'] ?>" ></td>
                          <td><input type="number" class="form-control" name="pastTwoYearStaff" value="<?php echo $lastTwoYears['Number of staff'] ?>" ></td>
                        </tr>
                        <tr>
                          <td>
                            Number of professional staff
                          </td>
                          <td><input type="number" class="form-control" name="currentProStaff" value="<?php echo $currentYear['Number of professional staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="prevProStaff" value="<?php echo $previousYear['Number of professional staff'] ?>" ></td>
                          <td><input type="number" class="form-control" name="pastTwoYearProStaff" value="<?php echo $lastTwoYears['Number of professional staff'] ?>" ></td>
                        </tr>
                        <tr>
                          <td>
                            Number of non-professional staff
                          </td>
                          <td><input type="number" class="form-control" name="currentNProStaff" value="<?php echo $currentYear['Number of non-professional staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="prevNProStaff" value="<?php echo $previousYear['Number of non-professional staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="pastTwoYearNProStaff" value="<?php echo $lastTwoYears['Number of non-professional staff'] ?>"></td>
                        </tr>
                        <tr>
                          <td>
                            Number of permanent staff
                          </td>
                          <td><input type="number" class="form-control" name="currentPermanentStaff" value="<?php echo $currentYear['Number of permanent staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="prevPermanentStaff"  value="<?php echo $previousYear['Number of permanent staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="pastTwoYearPermanentStaff"  value="<?php echo $lastTwoYears['Number of permanent staff'] ?>"></td>
                        </tr>
                        <tr>
                          <td>
                            Number of contract staff
                          </td>
                          <td><input type="number" class="form-control" name="currentContractStaff" value="<?php echo $currentYear['Number of contract staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="prevContractStaff" value="<?php echo $previousYear['Number of contract staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="pastTwoYearContractStaff" value="<?php echo $lastTwoYears['Number of contract staff'] ?>"></td>
                        </tr>
                        <tr>
                          <td>
                            Number of expatriate staff
                          </td>
                          <td><input type="number" class="form-control" name="currentExpatriateStaff" value="<?php echo $currentYear['Number of expatriate staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="prevExpatriateStaff" value="<?php echo $previousYear['Number of expatriate staff'] ?>"></td>
                          <td><input type="number" class="form-control" name="pastTwoYearExpatriateStaff" value="<?php echo $lastTwoYears['Number of expatriate staff'] ?>"></td>
                        </tr>
                        <tr>
                          <td>
                            Additional information/Comments
                          </td>
                          <td><textarea  class="form-control" name="currentCommentsStaff"><?php echo $currentYear['Additional information/Comments'] ?></textarea></td>
                          <td><textarea type="number" class="form-control" name="prevCommentStaff"><?php echo $lastTwoYears['Additional information/Comments'] ?></textarea></td>
                          <td><textarea type="number" class="form-control" name="pastTwoYearCommentsStaff"><?php echo $lastTwoYears['Additional information/Comments'] ?></textarea></td>
                        </tr>
                      </table>
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