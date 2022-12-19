<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<table>
    <thead>
    <tr>
        <th><u>Order</u></th>
        <th><u>Menu Item</u></th>
        <th><u>Type</u></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
	<?php
	if ( $resultat ) {
		$i = 0;
		foreach ( $resultat as $key => $value ) {
			$i ++;
			$id         = $value->id;
			$order      = $value->menu_order;
			$title      = $value->title;
			$menu_type  = $value->menu_type;
			$edit_url   = admin_url( 'admin.php' ) . '?page=' . esc_attr( $this->pluginname ) . '&tool=add&act=update&id=' . absint( $id );
			$delete_url = admin_url( 'admin.php' ) . '?page=' . esc_attr( $this->pluginname ) . '&info=del&did=' . absint( $id );
			?>
            <tr>
                <td><?php echo esc_attr( $order ); ?></td>
                <td><?php echo esc_attr( $title ); ?></td>
                <td><?php echo esc_attr( $menu_type ); ?></td>
                <td>
                    <u><a href="<?php echo esc_url( $edit_url ); ?>"><?php esc_attr_e( "Edit", "wow-marketings" ) ?></a></u>
                </td>
                <td>
                    <u><a href="<?php echo esc_url( wp_nonce_url( $delete_url, 'wow_side_menu_del' ) ); ?>"><?php esc_attr_e( "Delete", "wow-marketings" ) ?></a></u>
                </td>
            </tr>
			<?php
		}
	}
	?>
    </tbody>
</table>