<?php

require_once 'comments.json.php';

if ( ! empty( $_POST ) ) {
	require_once 'addcomment.php';
}

@header( 'Content-Type: application/json; charset=utf8' );
echo json_encode( $GLOBALS['comments'] );
exit();
