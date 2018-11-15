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
            <div class="row">
              <div class="x_panel">
                <div class="x_title">
                  <h2><?php echo $companyName?></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                  <?php echo $response; ?>
                </div>
                <div class="x_content">
                    <div class="row">
                      <table class="table table-bordered">
                        <tr>
                          <td>Title</td>
                          <td><?php echo $title ?></td>
                        </tr>
                        <tr>
                          <td>First name</td>
                          <td><?php echo $firstName ?></td>
                        </tr>
                        <tr>
                          <td>Other names</td>
                          <td><?php echo $otherNames ?></td>
                        </tr>
                        <tr>
                          <td>Surname</td>
                          <td><?php echo $surname ?></td>
                        </tr>
                        <tr>
                          <td>Job title</td>
                          <td><?php echo $jobTitle ?></td>
                        </tr>
                        <tr>
                          <td>Address line 1</td>
                          <td><?php echo $addressLine1 ?></td>
                        </tr>
                        <tr>
                          <td>Address line 2</td>
                          <td><?php echo $addressLine2 ?></td>
                        </tr>
                        <tr>
                          <td>Town</td>
                          <td><?php echo $town ?></td>
                        </tr>
                        <tr>
                          <td>State</td>
                          <td><?php echo $state ?></td>
                        </tr>
                        <tr>
                          <td>Country</td>
                          <td><?php echo $country ?></td>
                        </tr>
                        <tr>
                          <td>Post code</td>
                          <td><?php echo $postCode ?></td>
                        </tr>
                        <tr>
                          <td>Telephone (Full international number)</td>
                          <td><?php echo $telephone ?></td>
                        </tr>
                        <tr>
                          <td>Email address</td>
                          <td><?php echo $email ?></td>
                        </tr>
                        <tr>
                          <td>Additional information/Comments</td>
                          <td><?php echo $comment ?></td>
                        </tr>
                        <tr>
                          <td>Executive</td>
                          <td><?php echo $executives ?></td>
                        </tr>
                      </table>
                    </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Employee</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="form-group">
                      <table class="table table-bordered">
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
                          <td><?php echo $currentYear['Number of staff'] ?></td>
                          <td><?php echo $previousYear['Number of staff'] ?></td>
                          <td><?php echo $lastTwoYears['Number of staff'] ?></td>
                        </tr>
                        <tr>
                          <td>
                            Number of professional staff
                          </td>
                          <td><?php echo $currentYear['Number of professional staff'] ?></td>
                          <td><?php echo $previousYear['Number of professional staff'] ?></td>
                          <td><?php echo $lastTwoYears['Number of professional staff'] ?></td>
                        </tr>
                        <tr>
                          <td>
                            Number of non-professional staff
                          </td>
                          <td><?php echo $currentYear['Number of non-professional staff'] ?></td>
                          <td><?php echo $previousYear['Number of non-professional staff'] ?></td>
                          <td><?php echo $lastTwoYears['Number of non-professional staff'] ?></td>
                        </tr>
                        <tr>
                          <td>
                            Number of permanent staff
                          </td>
                          <td><?php echo $currentYear['Number of permanent staff'] ?></td>
                          <td><?php echo $previousYear['Number of permanent staff'] ?></td>
                          <td><?php echo $lastTwoYears['Number of permanent staff'] ?></td>
                        </tr>
                        <tr>
                          <td>
                            Number of contract staff
                          </td>
                          <td><?php echo $currentYear['Number of contract staff'] ?></td>
                          <td><?php echo $previousYear['Number of contract staff'] ?></td>
                          <td><?php echo $lastTwoYears['Number of contract staff'] ?></td>
                        </tr>
                        <tr>
                          <td>
                            Number of expatriate staff
                          </td>
                          <td><?php echo $currentYear['Number of expatriate staff'] ?></td>
                          <td><?php echo $previousYear['Number of expatriate staff'] ?></td>
                          <td><?php echo $lastTwoYears['Number of expatriate staff'] ?></td>
                        </tr>
                        <tr>
                          <td>
                            Additional information/Comments
                          </td>
                          <td><?php echo $currentYear['Additional information/Comments'] ?></td>
                          <td><?php echo $lastTwoYears['Additional information/Comments'] ?></td>
                          <td><?php echo $lastTwoYears['Additional information/Comments'] ?></td>
                        </tr>
                      </table>
                    </div>
                    <?php echo $questionnaireMenu; ?>
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
<?php echo $footer; ?>