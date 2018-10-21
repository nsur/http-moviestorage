<?php

return  array(
	'movie\/show\/(\d+)' => 'show',
	'movie\/edit\/?(\d+)?' => 'edit',
	'movie\/delete\/(\d+)' => 'delete',
	'upload' => 'upload',
	'upload_request' => 'uploadRequest',
	'save_request' => 'saveRequest',
	'\?s=([^&]*)' => 'index',
	'' => 'index',
	'404' => 'notFound'
);