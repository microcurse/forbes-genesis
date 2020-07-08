<?php if ( ! defined( 'ABSPATH' ) ) exit( 'No direct script access allowed' ); ?>

<div class="format-setting type-backup et-col-12">

<?php
    $vers_cats = array(
        'simple' => 'Simple page',
        'one_page' => 'One page',
        'landing' => 'Landing page'
    );


    $versions = require apply_filters('etheme_file_url', ETHEME_CODE_DIR . '/theme-versions.php');

    $demo_data_installed = get_option('demo_data_installed');

    $button_label = esc_html__('Install base demo content', 'woopress');

    ?>
 
    <?php if ( $demo_data_installed != 'yes' ): ?>
        <a href="javascript:void(0)" class="option-tree-ui-button et-button" id="install_demo_pages" ><?php echo esc_html( $button_label ); ?></a>
        <div class="install-base-first">
            <h1><?php esc_html_e('No access!', 'woopress'); ?></h1>
            <p><?php esc_html_e('Please, install Base demo content before, to access the collection of our Home Pages.', 'woopress') ?></p>
        </div>
    <?php else: ?>
        <p class="et-message et-info"><strong><?php esc_html_e('Note:', 'woopress' ); ?> </strong><?php esc_html_e('You have already installed base demo content.', 'woopress') ?></p>

        <div class="format-setting-label"><h3 class="label"><?php esc_html_e('Set up one of our theme versions', 'woopress'); ?></h3></div>

        <div class="ver-install-result et-message et-info"></div>
        

        <ul class="versions-filters">
            <li>
                <a href="#" data-filter="*" class="btn active"><?php esc_html_e('All', 'woopress'); ?></a>
            </li>
            <?php foreach($vers_cats as $slug => $name): ?>
                <li>
                    <a href="#" data-filter=".sort-<?php echo esc_attr( $slug ) ?>" class="btn"><?php echo esc_html( $name ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="et-theme-versions import-demos">
            <?php foreach($versions as $key => $value): ?>
                <div class="theme-ver sort-<?php echo esc_attr( $value['cat'] ); ?>">
                    <div class="image-wrapper-preview">
                        <img src="<?php echo ETHEME_CODE_IMAGES_URL.'/vers/v_'.$key.'.jpg'; ?>">
                    </div>
                    <button class="option-tree-ui-button blue install-ver" data-ver="<?php echo esc_attr( $key ); ?>" data-home_id="<?php echo esc_attr( $value['home_id'] ); ?>"><?php esc_html_e('Install version', 'woopress' ); ?></button>
                    <h4><?php echo esc_html( $vers_cats[$value['cat']] ); ?></h4>
                    <h2><?php echo esc_html( $value['title'] ); ?></h2>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>