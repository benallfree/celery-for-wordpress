		<div class="wrap">
			<h2>Celery <?php _e( "Configuration", 'celery' ); ?></h2>
			<style>
			#celery_settings p, #celery_instructions p
			{
  			text-align:left; 
  			margin: 10px 10px; 
  			font-size: 13px; 
  			line-height: 150%
			}
			.celery_example
			{
        border: 1px solid rgb(235, 227, 33);
        padding: 3px;
        color: orangered;
        background-color: rgb(252, 252, 202);  			
        font-family: monospace;
			}
			</style>
			<div class="postbox-container" style="width:70%;">
				<div class="metabox-holder">
					<div class="meta-box-sortables">
						<form action="" method="post" id="clicky-conf" enctype="multipart/form-data">
							<?php
							wp_nonce_field( 'celery-config' );

							$content = '<p>' . sprintf( __( 'Go to your %1$sCelery Dashboard%2$s and click the product you wish to use. Paste the Product Slug below. The "slug" is the last part of the product URL.', 'celery' ), '<a href="https://www.trycelery.com/dashboard/products">', '</a>' ) . '</p>';
							$content .= '<p>Example: https://www.trycelery.com/dashboard/products/<b class="celery_example">my-first-product</b>';

							$rows   = array();
							$rows[] = array(
								'id'      => 'product_slug',
								'label'   => __( 'Celery Product Slug', 'celery' ),
								'desc'    => '',
								'content' => '<input class="text" type="text" value="' . $options['product_slug'] . '" name="product_slug" id="product_slug"/>',
							);

							$content .= ' ' . $this->form_table( $rows );
							$this->postbox( 'celery_settings', __( 'Settings', 'celery' ), $content );

							$content = file_get_contents(dirname(__FILE__)."/instructions.php");
							$this->postbox( 'celery_instructions', __( 'Instructions', 'celery' ), $content );


							?>
							<div class="submit">
								<input type="submit" class="button-primary" name="submit"
									   value="<?php _e( "Update Celery Settings", 'celery' ); ?> &raquo;"/>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="postbox-container" style="width:20%;margin-left: 5px;">
				<div class="metabox-holder">
					<div class="meta-box-sortables">
						<?php
						$this->donate();
						$this->plugin_support();
						$this->news();
						?>
					</div>
					<br/><br/><br/>
				</div>
			</div>
			
