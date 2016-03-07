<?php
$ua=$_SERVER['HTTP_USER_AGENT'];

if((strpos($ua,'iPhone') == false)){
	header('Location:https://play.google.com/store/apps/details?id=jp.co.yahoo.gyao.android.app&hl=ja');
	

}else{
	
	header('Location:https://itunes.apple.com/jp/app/wu-liao-dong-hua-gyao!/id288091002?mt=8');
	

}