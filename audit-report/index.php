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
                    <h2>Audit Report:: <?php echo $companyName?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php echo $table; ?>
                  </div>
                  <div class="x_content">
                  	<div class="row form-group">
                      <div class="col-sm-4">
                      	<label for="">Audit Report</label>
                      </div>
                      <div class="col-sm-8">
                      	<?php echo $report; ?>
                      </div>
                    </div>
                    <div class="row form-group">
                  		<div class="col-sm-4">
                    		<label for="">Uploaded Document</label>
                   	 	</div>
                    </div>
                    <div class="row form-group">
                      <?php echo $document ?>
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
<script type="text/javascript" src=""></script>
<?php echo $footer; ?>