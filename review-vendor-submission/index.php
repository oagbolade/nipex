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
         <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
	       <div class="row">
	         <div class="col-md-12 col-sm-12 col-xs-12">
	            <div class="row">
	              <div class="x_panel">
	                <div class="x_title">
	                  <h2><?php echo $companyName?></h2>
	                  <ul class="nav navbar-right panel_toolbox">
	                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	                    </li></li>
	                  </ul>
	                  <div class="clearfix"></div>
	                </div>
	                <div class="x_content">
	                  <div class="row">
	                    <div class="col-sm-12">
	                  		<form method="post" action="processor.php" class="form-vertical" <?php echo $disabled;?> >
	                  			<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    			<input type="hidden" name="reviewID" value="<?php echo $reviewID; ?>" />
                    			<input type="hidden" name="vendorID" value="<?php echo $review['vendor_id'];?>"/>
	                  			<div class="row form-group">
	                  				<div class="col-sm-2">
	                  					<label>Approve</label>
	                  				</div>
	                  				<div class="col-sm-1">
	                  					<input type="radio" name="approval" value="approve" id='approveBtn' class="button"/>
	                  				</div>
	                  			</div>
	                  			<br/>
	                  			<div class="row form-group">
	                  				<div class="col-sm-2">
	                  					<label>Disapprove</label>
	                  				</div>
	                  				<div class="col-sm-1">
	                  					<input required type="radio" name="approval" value="disapprove" id='disapproveBtn' class="button"/>
	                  				</div>
	                  				<div class="col-sm-6">
	                  					<textarea id="reason" disabled name="reason" class="form-control" style="height: 150px;"></textarea>
	                  				</div>
	                  			</div>
	                  			<div class="row form-group">
	                  				<div class="col-sm-4">
	                  					<button type="submit" class="btn btn-primary" <?php echo $disabled;?>>Send Review</button>
	                  				</div>
	                  			</div>
	                  			<br/>
	                  		</form>    
	                    </div>
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