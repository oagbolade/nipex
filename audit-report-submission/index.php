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
              <div class="row">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $companyName?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php echo $table; ?>
                  </div>
                  <div class="x_content">
                    <form method="post" action="processor.php" <?php echo $disable ?> enctype="multipart/form-data" class="form-vertical">
                    	<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    	<input type="hidden" name="auditID" value="<?php echo $auditID; ?>" />
                    	<div class="row form-group">
                        <div class="col-sm-4">
                        	<label for="">Audit Report <span class="">*</span></label>
                        </div>
                        <div class="col-sm-8">
                        	<textarea <?php echo $disable ?> required name="report" class="form-control" style="min-height: 250px;"></textarea>
                        </div>
                      </div>
                      <div class="row">
                      	<div class="col-sm-12 text-center">
                      		<small><em>all uploaded file should be in .pdf format and be less than 10MB in size</em></small>
                      	</div>
                      </div>
                      <div class="row form-group">
                        <div class="col-sm-4">
                        	<input class="form-control document" name="document[]" id="document0" type="text" placeholder="name of document" />
                        </div>
                        <div class="col-sm-8">
                        	<input class="form-control upload" name="upload[]" type="file" id="upload0" />
                        </div>
                      </div>
                      <div id="newRow"></div>
                      <div id="createUploadDiv" class="row form-group">
                        <div class="col-sm-1">
                       		<button <?php echo $disable ?> type="button" id="createUpload" class="btn btn-primary">+</button>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-sm-4">
                        	<button <?php echo $disable ?> type="submit" class="btn btn-success">Submit Report</button>
                        </div>
                      </div>
                    </form>
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
<script type="text/javascript" src=""></script>
<?php echo $footer; ?>