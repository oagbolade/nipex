<?php 
	require_once 'controller.php'; 
	echo $head;
?>
<div>
  <a class="hiddenanchor" id="signup"></a>
  <a class="hiddenanchor" id="signin"></a>
  <div class="login_wrapper">
    <div class="animate form login_form al-home-form">
      <section class="login_content">
        <?php echo $pageHeader ?>
        <?php echo $response; ?>
        <?php echo $form; ?>
      </section>
    </div>
  </div>
</div>
<?php echo $footer; ?>
