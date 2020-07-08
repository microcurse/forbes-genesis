<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' );

$et_info = '';
$result  = '';

ob_start();
    $system = new Etheme_System_Requirements();
    $system->html();
    $result = $system->result();
$system = ob_get_clean();

ob_start();
    $version = new ETheme_Version_Check();
    $version->activation_page();?>

    <h4 class="text-uppercase"><?php esc_html_e('Where can I find my purchase code?', 'woopress'); ?></h4>

    <ul>
        <li>1. <?php esc_html_e('Please enter your Envato account and find ', 'woopress'); ?> <a href="https://themeforest.net/downloads"><?php esc_html_e('Downloads tab', 'woopress'); ?></a></li>
        <li>2. <?php esc_html_e('Find WooPress theme in the list and click on the opposite', 'woopress');?> <span><?php echo esc_html__('Download', 'woopress'); ?></span> <?php esc_html_e('button', 'woopress'); ?></li>
        <li>3. <?php esc_html_e('Select', 'woopress'); ?> <span><?php echo esc_html__('License Certificate & Purchase code', 'woopress'); ?></span> <?php esc_html_e('for download', 'woopress'); ?></li>
        <li>4. <?php esc_html_e('Copy the', 'woopress'); ?> <span><?php esc_html_e('Item Purchase Code', 'woopress'); ?> </span><?php esc_html_e('from the downloaded document', 'woopress'); ?></li>
    </ul>
    <br/>

    <h3><?php esc_html_e('Buy license', 'woopress'); ?></h3>

    <p><?php esc_html_e('If you don\'t have a license or need another one for a new website, click on a Buy button. Interested in multiple licenses? Contact us in a Live chat for more details about discounts for you.', 'woopress'); ?></p>

    <a href="https://themeforest.net/item/woopress-multipurpose-wordpress-theme/9751050?utm_source=royalcta?utm_source=royalncta&ref=8theme&license=regular&open_purchase_for_item_id=9751050&purchasable=source" class="et-button et-button-green last-button no-loader"><?php esc_html_e('Purchase now', 'woopress'); ?></a>

<?php $version = ob_get_clean();

if ( ! class_exists( 'Redux' ) ) {
	$et_info = '<p class="et-message et-error">' . esc_html__('The following required plugin is currently inactive: ', 'woopress') . '<a href="'.admin_url( 'plugins.php' ).'" target="_blank">'.esc_html__('Redux Framework', 'woopress').'</a></p>';
}
if ( ! class_exists('ETheme_Import') ) {
	$et_info = '<p class="et-message et-error">' . esc_html__('The following required plugin is currently inactive: ', 'woopress') . '<a href="'.admin_url( 'plugins.php' ).'" target="_blank">'.esc_html__('WooPress Core', 'woopress').'</a></p>';
}
echo '
<div class="et-col-7 etheme-registration">
	'.$et_info.'
	<h3>' . esc_html__( 'Theme Registration', 'woopress' ) . '</h3>
	' . $version . '
</div>
';
echo '
	<div class="et-col-5 etheme-system et-sidebar">
		<h3>' . esc_html__( 'System Requirements', 'woopress' ) . '</h3>
		' . $system . '
		<div class="text-center"><a href="" class="et-button et-button-grey last-button et-loader-on">
		<span class="et-loader">
                <svg class="loader-circular" viewBox="25 25 50 50"><circle class="loader-path" cx="50" cy="50" r="12" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg>
            </span>' . esc_html__( 'Check again', 'woopress' ) . '</a></div>';
		if ( ! $result ) {
			echo '<p class="et-message et-error">'.esc_html__( 'Your system does not meet the server requirements. For more efficient result, we strongly recommend to contact your host provider and check the necessary settings.', 'woopress' ).'<p>';
		}

echo '</div>';