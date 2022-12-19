<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wpdb;
$data = $wpdb->prefix . "sidemenu";
$info = ( isset( $_GET["info"] ) ) ? sanitize_text_field( $_GET["info"] ) : '';
if ( $info === "saved" ) {
	echo "<div class='updated' id='message'><p><strong>Record Added</strong>.</p></div>";
}
if ( $info === "update" ) {
	echo "<div class='updated' id='message'><p><strong>Record Updated</strong>.</p></div>";
}
if ( $info === "del" && isset( $_GET["did"] ) ) {
	$delid = absint( $_GET["did"] );
	$wpdb->delete( $data, [ 'id' => $delid ], [ '%d' ] );
	echo "<div class='updated' id='message'><p><strong>Record Deleted</strong>.</p></div>";
}
$resultat = $wpdb->get_results( "SELECT * FROM " . $data . " order by id asc" );
$count    = count( $resultat );
$tool     = ( isset( $_GET["tool"] ) ) ? sanitize_text_field( $_GET["tool"] ) : 'list';
$tabs     = array(
	'list'    => array( 'List', 'fa-list' ),
	'add'     => array( 'Add new', 'fa-plus' ),
	'style'   => array( 'Style', 'fa-css3' ),
	'pro'     => array( 'Pro version', 'fa-external-link' ),
	'support' => array( 'Support', 'fa-life-ring' ),
);
?>
<div class="wow">
    <span class="wow-plugin-title"><?php echo esc_attr( $name ); ?></span> <span
            class="wow-plugin-version">(version <?php echo esc_attr( $version ); ?>)</span>
	<?php echo '<ul class="wow-admin-menu">';
	foreach ( $tabs as $tab => $tab_name ) {
		$class = ( $tab == $tool ) ? 'active' : '';
		$url   = admin_url( 'admin.php' ) . '?page=' . esc_attr( $pluginname ) . '&tool=' . esc_attr( $tab );
		echo '<li><a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_attr( $tab_name[0] ) . ' <i class="fa ' . esc_attr( $tab_name[1] ) . '"></i></a></li> ';
	}
	echo '</ul>';
	echo '<p style="padding-bottom: 5px;margin-bottom:30px;"><span class="dashicons dashicons-megaphone" style="color:red;"></span>&nbsp;&nbsp; Try using a more flexible plugin <a href="https://wordpress.org/plugins/side-menu-lite/" target="_blank">Side Menu Pro</a>!</p>';

	switch ( $tool ) {
		case 'add':
			include_once( 'add.php' );
			break;
		case 'style':
			include_once( 'style.php' );
			break;
		case 'pro':
			include_once( 'pro.php' );
			break;
		case 'support':
			include_once( 'support.php' );
			break;
		default:
			include_once( 'list.php' );
			break;

	}
	?>
</div>
