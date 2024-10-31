<?php
/*
Plugin Name: Not Modified
Description: Prevents post modified dates from being changed when you update your posts.
Version: 1.0
Text Domain: rudr-not-modified
Author: Misha Rudrastyh
Author URI: https://rudrastyh.com

Copyright 2014-2022 Misha Rudrastyh ( https://rudrastyh.com )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

add_filter( 'wp_insert_post_data', 'rudr_do_not_change_modified_date', 10, 2 );
function rudr_do_not_change_modified_date( $data, $postarr ) {

    // return if post ID is zero

    // this indicates that a new post is being processed
    if( ((int)$postarr[ 'ID' ] === 0) || ! $postarr[ 'ID' ] ){
			return $data;
		}

    // get the post
    $post_befor_update = get_post( $postarr[ 'ID' ] );

    // return if the modified date is not set

    // this happens in revisions and can heppen in other post types

		if( ! isset( $data[ 'post_modified' ] ) || ! isset( $data[ 'post_modified_gmt' ] ) || ! isset( $post_befor_update->post_modified ) || ! isset( $post_befor_update->post_modified_gmt ) ) {
			return $data;
		}

    // change the modified date back to how it was before the update
    $data[ 'post_modified' ] = $post_befor_update->post_modified;
    $data[ 'post_modified_gmt' ] = $post_befor_update->post_modified_gmt;

    return $data;
}
