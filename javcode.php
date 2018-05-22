<?php 
/**
*
* [ JSENDER ( JAVCODE SENDER ) VERSION 2.0 ]
*
*----------------------------------------------------------------------------------------------
* ## BUKAN BUAT NOOB USER YANG MANJA MINTA DI AJARIN DARI AWAL CARA PEMAKAIAN.
* ## SEMUA TUTORIAL SUDAH ADA DI ```README.HTML``` TOLONG BUDAYAKAN MEMBACA SEBELUM MEMAKAI. 
* ## JIKA ADA ERROR? TANYAIN KE GRUB @see https://facebook.com/jc.javcode
*----------------------------------------------------------------------------------------------
*
* @author shutdown57 ( alinko ) < indonesianpeople.shutdown57@gmail.com >
* @version 2.0 2018 Edition.
* @link https://github.com/phpmailer/phpmailer 
* @see https://github.com/alintamvanz
* @link facebook : https://facebook.com/jc.javcode
* @copyright (c) 2018 
*
**/

require 'src/javcode.class.php';

function JsenderRun($jc){
    
$jc->J_Banner();
if(!file_exists($jc->conf.'smtp.javcode.conf') || !file_exists($jc->conf.'setting.javcode.conf'))
{
	die("Jsender blom terkonfigurasi dengan benar ! \nKamu harus setting dulu :D\n");
}

@eval($jc->J_getFile($jc->conf.'javcode.conf')); // Get Configuration [Jsender]

$js=$jc->J_getFile($jc->conf.'user.javcode.conf'); // Get User [Jsender]
$js=json_decode($js); // Decode json data for get user files [Jsender]

$ml = explode($jc->d(),$jc->J_getFile($jc->ml.$mailist)); // Get Mailist [Jsender]
$lsss = count($ml);
$lsx=$lsss-1;
$jc->J_ask($js->username,'LimitSend [ '.$lsss.' | 0-'.$lsx.' ] '); 
$ls = (empty($jc->read)) ? JsenderRun($jc) : $jc->read;
$lim = $jc->J_ambilLimit($ls);
$jc->J_ask($js->username,'Duplicate Email [y/n]');
if($jc->read == 'n' || $jc->read == 'N')
{
    $ml=array_unique($ml);
}


	$settan = array(
				array('host' => $smtphost,
					  'user' => $smtpuser,
					  'pass' => $smtppass,
					  'port' => $smtpport,
					  'priority' => $priority,
					  'encoding' => $encoding,
					)
	        );
foreach($settan as $key => $set)
{
    if($lim[1] > count($ml)-1){ $max=count($ml)-1;}else{$max=$lim[1];}
	for($np=$lim[0];$np<=$max;$np++){
		$imel =$ml[$np];
		$time_start = $jc->y();
		$fuck = array('sendername' => $jc->rnd($sendername,'sendername'),
					  'sendermail' => $jc->rnd($sendermail,'sendermail'),
					  'subject' => $jc->rnd($subject,'subject'));
	$letters = $jc->J_letter($jc->ml.$letter,$imel);
	$jsendermail = new PHPMailer();
	$jsendermail->SMTPDebug = 0;                                 
    $jsendermail->isSMTP();                                      
    $jsendermail->Host = $set['host'];
    $jsendermail->SMTPAuth = true;                               
    $jsendermail->Username = $set['user'];         
    $jsendermail->Password = $set['pass'];                          
    $jsendermail->SMTPSecure = 'tls';
    $jsendermail->KeepAlive = true;                           
    $jsendermail->Port = $set['port'];
    $jsendermail->Priority = $set['priority'];                                  
    $jsendermail->SingleTo = true;
    $jsendermail->setFrom($fuck['sendermail'],$fuck['sendername']);
    $jsendermail->isHTML(true);                            
    $jsendermail->Subject = $fuck['subject'];
    $jsendermail->MsgHTML($letters);
    $jsendermail->Encoding = $set['encoding'];
    $jsendermail->addAddress($imel);
    $jc->J_header($np,$max,$imel);
    if($jsendermail->send())
    {
    	$time_end = $jc->y();
    	$timez = ($time_end - $time_start);
    	$jc->J_footer($timez,true);
    }else{
    	$time_end = $jc->y();
    	$timez = ($time_end - $time_start);
    	$jc->J_footer($timez,false);
    	$jc->J_logError($imel,$jsendermail->ErrorInfo,date('d-m-Y H:i:s'));
    }
    unset($ml[$np]);
    sleep($delay);
    if($pause != "" || $pause != "null")
    {
    	if($np%$pause == 0)
    	{
    		
    		$jc->pause($delayp);
    	}
    }
	}
}
}

JsenderRun($jc);