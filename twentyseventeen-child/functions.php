<?php

add_filter( 'post_class', 'prefix_post_class', 21 );
function prefix_post_class( $classes ) {
    if ( 'product' == get_post_type() ) {
        $classes = array_diff( $classes, array( 'first', 'last' ) );
    }
    return $classes;
}

