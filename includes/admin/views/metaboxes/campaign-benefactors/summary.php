<?php 
/**
 * Renders the campaign benefactors form.
 *
 * @since 		1.0.0
 * @author 		Eric Daams
 * @copyright 	Copyright (c) 2015, Studio 164a 
 */

$benefactor = $view_args[ 'benefactor' ]; 
$summary = $benefactor->is_active() ? $benefactor : sprintf( '<span>%s</span>%s', __( 'Expired', 'charitable' ), $benefactor ); 

?>
<div class="charitable-benefactor-summary">
	<span class="summary"><?php echo $summary ?></span>
	<span class="alignright">
		<a href="#" data-charitable-toggle="campaign_benefactor_<?php echo $benefactor->campaign_benefactor_id  ?>" data-charitable-toggle-text="<?php _e( 'Close', 'charitable' ) ?>"><?php _e( 'Edit', 'charitable' ) ?></a>&nbsp;&nbsp;&nbsp;
		<a href="#" data-campaign-benefactor-delete="<?php echo $benefactor->campaign_benefactor_id  ?>" data-nonce="<?php echo wp_create_nonce( 'charitable-deactivate-benefactor' ); ?>"><?php _e( 'Delete', 'charitable' ) ?></a>
	</span>
</div>