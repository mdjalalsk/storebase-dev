<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Start Level - Before the list items
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $classes = array( 'submenu' );

        // Add class for right submenus
        if (isset($args->right_submenu) && $args->right_submenu) {
            $classes[] = 'right-submenu';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = '';
        $id = apply_filters( 'nav_menu_submenu_id', $id, $args, $depth );

        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= "\n<ul$class_names$id>\n";
    }

    // Start Item - Before each menu item
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // Add active class to current item
        if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes ) ) {
            $classes[] = 'active';
        }

        // Add submenu classes if applicable
        if ( isset( $item->menu_item_parent ) && $item->menu_item_parent > 0 ) {
            $classes[] = 'submenu-item';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names .'>';

        // Add anchor tag for each menu item
        $attributes = ! empty( $item->attr_title )     ? ' title="' . esc_attr( $item->attr_title ) . '"': '';
        $attributes .= ! empty( $item->target )        ? ' target="' . esc_attr( $item->target ) . '"': '';
        $attributes .= ! empty( $item->xfn )           ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
        $attributes .= ! empty( $item->url )           ? ' href="' . esc_attr( $item->url ) . '"' : '';

        $title = apply_filters( 'the_title', $item->title, $item->ID );

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $args, $depth );
    }
}
