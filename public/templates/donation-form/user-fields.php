<?php
/**
 * The template used to display the login fields.
 *
 * @author 	Studio 164a
 * @since 	1.0.0
 * @version 1.0.0
 */

$form 			= charitable_get_current_donation_form();
$user_fields 	= $form->get_user_fields();
$user 			= wp_get_current_user();

if ( empty( $user_fields ) ) {
	return;
}
?>
<h3 class="charitable-form-header"><?php _e( 'Your Details', 'charitable' ) ?></h3>
<?php
/**
 * If the user is not logged in, show a login form at the top of the page. 
 */
if ( 0 === $user->ID ) :

	/**
	 * Add a login form to the top of the page.
	 *
	 * @hook 	charitable_login_form
	 */
	do_action( 'charitable_login_form', $form ); 

endif 
?>
<div class="charitable-user-details">

	<?php if ( $user->ID ) : 

		/**
		 * @hook 	charitable_donor_details
		 */
		do_action( 'charitable_donor_details', $form );
		?>
		<p class="charitable-change-user-details"><a href="#" data-charitable-toggle="charitable-user-fields"><?php _e( 'Update your details', 'charitable' ) ?></a>

		<div id="charitable-user-fields" class="charitable-hidden">

	<?php endif ?>

		<?php do_action( 'charitable_donation_form_before_user_fields', $form ) ?>

		<?php foreach ( $user_fields as $key => $field ) : ?>

			<?php do_action( 'charitable_donation_form_user_field', $field, $key, $form ) ?>

		<?php endforeach ?>

		<?php do_action( 'charitable_donation_form_after_user_fields', $form ) ?>

	<?php if ( $user->ID ) : ?>

	</div>

<?php endif ?>

</div>