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
          <div class="col-sm-6">
            <div class="row">
              <form action="<?php echo htmlentities("processor.php"); ?>" method="post" enctype="multipart/form-data">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product and Services</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    <div class="row">
                       <div class="col-md-3">
                         <p>Product Category</p>
                       </div>
                       <div class="col-md-7">
                         <div class="form-group">
                          <select name="productCategory0" class="form-control" id="productCategory0">
                            <option value="">Choose product category</option>
                            <option><?php echo $categories['category1']; ?></option>
                            <option><?php echo $categories['category2']; ?></option>
                            <option><?php echo $categories['category3']; ?></option>
                          </select>
                         </div>
                       </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-3">
                         <p>Product Code</p>
                       </div>
                       <div class="col-sm-7">
                         <div class="form-group">
                          <select name="productCode0" class="form-control" id="productCode0"></select>
                         </div>
                       </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <p>DPR Certificate</p>
                      </div>
                      <div class="col-md-7">
                        <div class="form-group">
                          <input type="file" name="dprCertificate0" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <!-- <button type="button" class="btn btn-danger">+</button> -->
                        </div>
                      </div>
                    </div>
                </div>             
              </div>   
              <!-- save button panel -->
              <div class="x_panel">
                <div class="x_content">
                  <button <?php echo $disableSave; ?> type="submit" name="action" value="create" class="btn btn-success">Save</button>
                </div>
              </div>           
              </form>
            </div>
          </div>
        </div>
          <div class="col-sm-6">
            <div class="row">
              <form action="<?php echo htmlentities("processor.php"); ?>" method="post">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product and Services</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                    <?php echo $table; ?>
                  </div>             
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo "<script>
    let categoryOne = [$serviceOne[0]];
    let categoryOneCode = [$serviceOne[1]];
    let categoryTwo = [$serviceTwo[0]];
    let categoryTwoCode = [$serviceTwo[1]];

    let productCategory =  document.getElementById('productCategory0');
    function productServices(productList, productCode) {
     let productService = '';
     for (var i = 0; i < productList.length; i++) {
       productService += '<option value='+productCode[i]+'>'+productList[i]+'</option>';
     }
     return productService;
    }
    productCategory.addEventListener('change', function () {
     let productCode0 =  document.getElementById('productCode0');
     productCode0.innerHTML = '';
     if (productCategory.value == '{$categories['category1']}') {
       productCode0.innerHTML = productServices(categoryOne, categoryOneCode);
     }else if(productCategory.value == '{$categories['category2']}'){
       productCode0.innerHTML = productServices(categoryTwo, categoryTwoCode);
     }else if (productCategory.value == '{$categories['category1']}') {
       productCode0.innerHTML = productServices(categoryThree);
     }
    }, false);
  </script>" ?>
    <!-- /page content -->

    <!-- footer content -->
    <?php echo $slogan; ?>
    <!-- /footer content -->
  </div>
</div>
<?php echo $footer; ?>
