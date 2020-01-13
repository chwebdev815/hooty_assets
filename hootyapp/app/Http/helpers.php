<?php
	
function notificationMsg($type, $message){
	\Session::put($type, $message);
}

function get_user_id()
{
	$user_id = auth()->guard('web')->user()->id;
	return $user_id;
}
