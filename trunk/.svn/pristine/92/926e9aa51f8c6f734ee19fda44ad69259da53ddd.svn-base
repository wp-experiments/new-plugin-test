<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="wow">
    <span class="wow-plugin-title"><?php echo esc_attr( $this->name ); ?></span> <span class="wow-plugin-version">(Make Your Website Legendary)</span>

	<?php
	$current = ( isset( $_GET['tab'] ) ) ? sanitize_text_field( $_GET['tab'] ) : 'items';
	$tabs    = array( 'items' => array( 'Items', 'fa-plug' ) );
	echo '<ul class="wow-admin-menu">';
	foreach ( $tabs as $tab => $name ) {
		$class = ( $tab == $current ) ? 'active' : '';
		echo '<li><a class="' . esc_attr( $class ) . '" href="?page=wow-company&tab=$tab">' . esc_attr( $name[0] ) . ' <i class="fa ' . esc_attr( $name[1] ) . '"></i></a></li> ';
	}
	echo '</ul>';

	?>


	<?php include_once( esc_attr( $current ) . '.php' ); ?>

</div>
