<?php
$data = [
	[ 'aid' => 1, 'cid' => 1, 'title' => '后盾人', 'thumb' => 'web/images/2.jpg', 'content' => '后盾网人人做后盾1' ],
	[ 'aid' => 2, 'cid' => 1, 'title' => '腾讯新闻', 'thumb' => 'web/images/2.jpg', 'content' => '后盾网人人做后盾2' ],
	[ 'aid' => 3, 'cid' => 2, 'title' => '后盾网论坛', 'thumb' => 'web/images/2.jpg', 'content' => '后盾网人人做后盾3' ]
];
if ( isset( $_GET['aid'] ) ) {
	foreach ( $data as $d ) {
		if ( $d['aid'] == $_GET['aid'] ) {
			echo json_encode( $d );
		}
	}
} else {
	$res = [ ];
	foreach ( $data as $d ) {
		if ( $d['cid'] == $_GET['cid'] ) {
			$res[] = $d;
		}
	}
	echo json_encode( $res );
}