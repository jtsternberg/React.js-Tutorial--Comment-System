<?php

function update_comment_file( $updated_comment_data ) {
	$php = '$GLOBALS[\'comments\'] = '. str_replace(
		array(
			'stdClass::__set_state',
			'array (',
			"=> \n ",
			"=> \r "
		), array(
			'(object) ',
			'array(',
			'=>',
			'=>'
		), var_export( $updated_comment_data, true ) ) .';'."\n\n";
	$php = preg_replace( '/([0-9]) => /', '', $php );

	return file_put_contents( 'comments.json.php', sprintf( '<?php%s%s', "\n\n", $php ) );
}

// clean up that data
array_walk( $_POST, function( &$key, &$value ) {
	$key   = strip_tags( trim( $key ) );
	$value = strip_tags( trim( $value ) );
} );

// Add the comments to our comment array
$GLOBALS['comments'] = array_merge( $GLOBALS['comments'], array( $_POST ) );

// Update the file if we have 200 or fewer comments
if ( 200 >= count( $GLOBALS['comments'] ) ) {
	update_comment_file( $GLOBALS['comments'] );
}
