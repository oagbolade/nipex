<?php 
	require_once 'controller.php'; 
	echo $head;
?>
<div>
	<?php echo $style; ?>
  <div class="login_wrapper">
    <div id="register" class="animate form al-home-form">
      <section class="login_content">
        <?php echo $pageHeader ?>
        <h2>Payment Updating</h2>
        <?php echo $responseMsg; ?>
        <div class="separator">
          <div class="clearfix"></div>
          <br />
        </div>
      </section>
    </div>
  </div>
</div>
<?php echo $footer; ?>