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
        <form method="post" action="processor.php" class="form-vertical">
         <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Declarations</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-12">
                          <table class="table">
                            <tr>
                              <td></td>
                              <th>Name</th>
                              <th>Position</th>
                              <th>Date</th>
                              <th>Telephone Number</th>
                            </tr>
                            <tr>
                              <th><label>Completed by<span class="">*</span></label></th>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" name="completedName" value="<?php if(isset($completedBy['Name'])) echo $completedBy['Name']; ?>" >
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" name="completedPosition" value="<?php if(isset($completedBy['Position'])) echo $completedBy['Position']; ?>" >
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="date" class="form-control" name="completedDate" value="<?php if(isset($completedBy['Date'])) echo $completedBy['Date']; ?>" >
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" name="completedNumber" value="<?php if(isset($completedBy['Phone Number'])) echo $completedBy['Phone Number']; ?>" >
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th><label>Last changed by<span class="">*</span></label></th>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" name="lastChangedName" value="<?php if(isset($lastChangedBy['Name'])) echo $lastChangedBy['Name']; ?>" >
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" name="lastChangedPosition" value="<?php if(isset($lastChangedBy['Position'])) echo $lastChangedBy['Position']; ?>" >
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="date" class="form-control" value="<?php if(isset($lastChangedBy['Date'])) echo $lastChangedBy['Date']; ?>" name="lastChangedDate" >
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" name="lastChangedNumber" value="<?php if(isset($lastChangedBy['Phone Number'])) echo $lastChangedBy['Phone Number']; ?>" >
                                </div>
                              </td>
                            </tr>
                          </table>
                        </div>
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
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<script type="text/javascript" src=""></script>
<?php echo $footer; ?>