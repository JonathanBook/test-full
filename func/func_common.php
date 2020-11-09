<?php

function isiPhone(){
	if (stristr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||	stristr($_SERVER['HTTP_USER_AGENT'],'iPod') ||	stristr($_SERVER['HTTP_USER_AGENT'],'iPad')){
		return true;	
	}else{
		return false;
	}
}

function isSafari(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (stripos( $user_agent, 'Chrome') !== false){
       return false;
    }elseif (stripos( $user_agent, 'Safari') !== false){
        return true;
    }
    return false;
}

function isMobile(){
	if (stristr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||	stristr($_SERVER['HTTP_USER_AGENT'],'iPod') ||
        stristr($_SERVER['HTTP_USER_AGENT'],'android') || stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ||
        stristr($_SERVER['HTTP_USER_AGENT'],'Windows Phone') || stristr($_SERVER['HTTP_USER_AGENT'],'symbian') ||
        stristr($_SERVER['HTTP_USER_AGENT'],'series60') || stristr($_SERVER['HTTP_USER_AGENT'],'palm')){
		return true;	
	}else{
		return false;
	}
}

function build_alert(){
	
	$html = '<div class="jqmAlert" id="alert">';
	$html.= '	<div id="ex3b" class="jqmAlertWindow">';
    $html.= '		<div class="jqmAlertTitle clearfix">';
    $html.= '			<h1>Information</h1><a href="#" class="jqmClose"><em>Close</em></a>';
	$html.= '		</div>';
	$html.= '		<div class="jqmAlertContent"></div>';
	$html.= '	</div>';
	$html.= '</div>';
	
	return $html;
}

function generatePassword ($length = 6){

  // start with a blank password
  $password = "";

  // define possible characters
  $possible = "0123456789abcdfghjkmnpqrstvwxyz@"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  // done!
  return $password;

}


function jump_to_location($getvar_to_trunc=FALSE){
	if($getvar_to_trunc)
		header("Location: ".html_entity_decode(trunc_get($getvar_to_trunc)));
	else
		header("Location: ".html_entity_decode(URLSELF));
    exit();
}
	
function build_valid_url($url) {
	$url = urldecode($url);
	$url = str_replace(" ","",$url);
	if (strncmp($url, "http://", 7) != 0 && strncmp($url, "https://", 8) != 0) {
		return "http://".$url;
	}
	return $url; 
}

function formatNombre($nb) {
	return number_format($nb, 2, '.', ' ');
}		
		
function sp2nbsp($string){
	return str_replace(' ','&nbsp;',trim($string));
}

function get_rnd_iv($iv_len){
    $iv = '';
    while ($iv_len-- > 0) {
        $iv .= chr(mt_rand() & 0xff);
    }
    return $iv;
}

function daysBetweenDates($beginDate,$endDate,$countNoWorkDay=true,$countWeekEnd=true){
	global $f_ohd_noworkDay;
	
	$daysBetweenDates = 0;
	
	if( $endDate<$beginDate ){
		$tmpDate = $beginDate;
		$beginDate = $endDate;
		$endDate = $tmpDate;
	}
	
	// Convertion at 3:00am
	$beginDate = mktime(3,0,0,date('m',$beginDate),date('d',$beginDate),date('Y',$beginDate));
	$endDate = mktime(3,0,0,date('m',$endDate),date('d',$endDate),date('Y',$endDate));
	
	$daysInSeconds = $endDate-$beginDate;
	$daysBetweenDates = ceil($daysInSeconds/(3600*24));
	
	if( !$countNoWorkDay||!$countWeekEnd ){
		$noWorkDay = getColParam(T_OHD_NOWORKDAY, $f_ohd_noworkDay[4], $f_ohd_noworkDay[0]);
		foreach( $noWorkDay as $key=>$timestamp ){
			$noWorkDay[$key] = date('dm',$timestamp);
		}
		
		for($current_day=$beginDate ; $current_day<=$endDate+3600 ; $current_day+=3600*24 ){
			$number_JourSemaine = date('N',$current_day);	// Lundi: 1 ; Dimanche: 7
			if( !$countNoWorkDay&&in_array(date('dm',$current_day),$noWorkDay)||!$countWeekEnd&&$number_JourSemaine>5 ){
				$daysBetweenDates--;
			}
		}
	}
	
	return $daysBetweenDates;
}

function mktimeDayStart($timestamp=''){
	if(empty($timestamp))
		$timestamp = time();
		
	return mktime(0,0,0,date('m', $timestamp), date('d', $timestamp), date('y', $timestamp));
}

function mktimeDayEnd($timestamp=''){
	if(empty($timestamp))
		$timestamp = time();
		
	return mktime(23,59,59,date('m', $timestamp), date('d', $timestamp), date('y', $timestamp));
}

function getSiteParam($code){
	global $g_parametre;
	
	$value = squery("SELECT {$g_parametre['value']} FROM ".T_PARAMETRE." WHERE {$g_parametre['code']}='".$code."' LIMIT 1");
	if($value)
		return stripslashes($value);
	else
		return '';
}

function stripAccents($string){
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r'
    );
    
    return strtr($string, $table);
}

function clean_url_rewriting($string){
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '.'=>'_', '?'=>'_', '!'=>'_', '°'=>'_', ' '=>'_', '-'=>'_', '"'=>'_',
    	 "'"=>'_'
    );
    
    return strtr($string, $table);
}
?>