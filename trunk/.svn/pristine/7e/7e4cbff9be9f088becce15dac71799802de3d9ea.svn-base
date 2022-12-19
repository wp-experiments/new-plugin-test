<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $val->menu_link ) ) {
	$link = "#";
} else {
	$link = $val->menu_link;
}
if ( empty( $val->title ) ) {
	$title = "Menu - " . $val->id;
} else {
	$title = $val->title;
}
if ( empty( $val->menu_id ) ) {
	$menu_id = "";
} else {
	$menu_id = 'id="' . $val->menu_id . '"';
}

if ( $val->menu_type == 'link' ) {
	echo '<a href="' . esc_url( $val->menu_link ) . '" class="wp-side-menu-item"><span>' . esc_attr( $title ) . '</span><i class="fa ' . esc_attr( $val->menu_icon ) . ' wo-icon" aria-hidden="true"></i></a>';
}
if ( $val->menu_type == 'block' ) {
	echo '<div ' . wp_kses_post( $menu_id ) . ' class="wp-side-menu-item"><span>' . esc_attr( $title ) . '</span><i class="fa ' . esc_attr( $val->menu_icon ) . ' wo-icon" aria-hidden="true"></i></div>';
}
