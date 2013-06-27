<div id='celerywarning' class='updated fade'>
  <p>
    <strong>  
      <?=_e( 'Celery is almost ready. ', 'celery' )?>
    </strong>  
    <? printf( __( 'You must %1senter your Celery Product Slug%2s.', 'celery' ), "<a href='" . admin_url( 'options-general.php?page=celery' ) . "'>", "</a>" ); ?>
  </p>
</div>  
<script type="text/javascript">
  setTimeout(function() {
    jQuery('#celerywarning').hide('slow');
  }, 10000);
</script>  
