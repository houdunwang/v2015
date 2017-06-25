<?php
//表名加前缀
if ( ! function_exists( 'tablename' ) ) {
	function tablename( $table ) {
		return c( 'database.prefix' ) . $table;
	}
}