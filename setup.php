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
* @copyright (c) 2018 
*
**/

require 'src/javcode.class.php';
$o = "";
function returnFunc($jc)
{
	echo "[?] Apakah anda ingin kembali ke menu awal ? [Y/n] "; $re = trim(fgets(STDIN));
	if($re == "Y" || $re == "y" || $re == "")
	{
		SetupFunc($jc);
	}else{
		echo "\n\n\n\n";
		echo "[!][!] EXITING PROGRAM .... \n";
		exit;
	}
}

function SetupFunc($jc){
$jc->J_Banner();

$opt = array(1 => "Setting Up Jsender",
			 2 => "Reset Configuration",
			 3 => "Create Auto Run [Ez run jsender]",
			 4 => "Get WebVersion",
			 0 => "Bantuan / Contact",
			 );
foreach($opt as $num=>$val)
{
	echo "  [ ".$num." ] ".$val."\n";
}
$jc->J_ask('JsenderSetup','SelectOptions');
$o = $jc->read;

if($o == 1)
{
	$jc->clear();
	$jc->J_Banner();
	$opt = array(1 => "Setting SMTP",
				 2 => "Setting Racikan & Mailist & Delay");
	foreach($opt as $np =>$val)
	{
		echo " [ ".$np." ] ".$val." \n"; 
	}
	$jc->J_ask('JsenderSetup','SelectOptionsII');
	$u = $jc->read;
	if($u == 1){
		$jc->runline();
		$jc->J_ask('JsenderSetup','SMTP_Hostname');
		$host = $jc->read;
		echo "\nSMTP : Hostname SetUp to ".$host." ! \n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','SMTP_Port    ');
		$port = $jc->read;
		echo "\nSMTP : Port SetUp to ".$port." ! \n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','SMTP_Username');
		$user = $jc->read;
		echo "\nSMTP : Username SetUp to ".$user." !\n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','SMTP_Password');
		$pass = $jc->read;
		echo "\nSMTP : Password SetUp to ".$user." !\n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','Priority [1=high,3=normal,5=low]');
		$prio = $jc->read;
		echo "\nSMTP : Priority : $prio \n";
		$jc->runline(); 
		$jc->J_ask('JsenderSetup','encrypt base64 [y/n]');
		$enc = ($jc->read == 'y') ? "base64" : "8bit"; 
		echo "\nSMTP : encryption to base64 ( $enc ) \n";
		echo "[====================================]\n\n";
		echo "[i] Saving your Configuration files ... \n";
		if($jc->J_smtp(array($host,$port,$user,$pass,$prio,$enc)))
		{
			echo "[+] Successfully saved your Configuration ! :D \n";
		}else{
			die("Can't save Configuration :(\n");
		}
		returnFunc($jc);
	}elseif($u == 2)
	{
		echo "\n===[ Pilih Letter & Maillist , masukan angka dari file ]===\n";
		$jc->J_scan();
		$jc->J_ask('JsenderSetup','Letter');
		$letter = $jc->J_ml($jc->read);
		echo "\nLetter file setUp to ".$letter." \n\n";
		$jc->J_ask('JsenderSetup','Maillist');
		$mailist = $jc->J_ml($jc->read);
		echo "\nMailist file setUp to  ".$mailist." \n";
		echo "\n===[ ================================================= ]===\n";
		sleep(1);
		echo "\n\n";
		echo "NB : Kosongkan jika menggunakan fitur random \n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','SenderName');
		$sendername = $jc->_rr_($jc->read);
		echo "\n Sendername setUp to $sendername \n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','SenderMail');
		$sendermail = $jc->_rr_($jc->read);
		echo "\n SenderMail setUp to $sendermail \n";
		$jc->runline();
		$jc->J_ask('JsenderSetup','Subject');
		$subject    = $jc->_rr_($jc->read);
		echo "\n SenderSubject setUp to $subject \n";
		echo "[=====================================]\n\n";
		echo "\n\n===[ ================================================== ]===\n";
		echo " SETTING DELAY \n\n";
		$jc->J_ask('JsenderSetup','Setiap berapa send ?');
		$limits = $jc->read;
		$jc->J_ask('JsenderSetup','Akan di delay [second] ?');
		$delays = $jc->read;
		$jc->J_ask('JsenderSetup','Setiap 1 send, akan di delay [second] ?');
		$delay = $jc->read;
		echo ".......... setting up .......\n\n";
		sleep(1);
		echo "Jsender akan bekerja :: Sesuai settingan kamu :*\n\n";
		echo "setiap ".$limits."x mengirim email akan di pause/delay selama $delays detik\n\n";
		echo "Dan setiap 1x megirim email akan di pause/delay selama $delay detik. \n\n";
		echo "[i] apakah anda sudah paham dan ingin menyimpan settingan di atas? [Y/n] ";
		$yn=trim(fgets(STDIN));
		$data = array('letter' => $letter,
					  'mailist' => $mailist,
					  'sendername' => $sendername,
					  'sendermail' => $sendermail,
					  'subject' => $subject,
					  'limits' => $limits,
					  'delay' => $delay,
					  'delays' => $delays);
		if($yn == "Y" || $yn == "y" || $yn == "")
		{
			if($jc->J_base($data))
			{
				echo "[+] Successfully saved your Configuration ! :D \n";
			}else{
				die("Can't save Configuration :( \n");
			}
		}else{
			SetupFunc($jc);
		}
		returnFunc($jc);
	}else{
		SetupFunc($jc);
	}

}elseif($o == 2){
echo "[!] Cleaning ... \n";
sleep(1);
echo "[i] Scanning file Configuration in 'config/' directories .. \n";
$s = scandir('config');
foreach($s as $ml)
{if($ml == '.'||$ml == '..' || $ml == 'token.javcode.conf' || $ml == 'javcode.conf') continue;
echo "[+] Deleting : config/$ml ... ";
	usleep(10000);
if(unlink('config/'.$ml))
{
	echo " [SUCCESS] \n";
	usleep(10000);
}else{
	echo "[FAILED] \n";
	usleep(10000);
}
}
returnFunc($jc);
}elseif($o == 0)
{
print 
"
+----------------------------------------------------+
||||    JavCode Project (c) 2017 - 2018              |
||||=================================================|
||||    Author :: shutdown57                         |
||||    HP/WA  :: 085225510000                       |
||||    Line ID:: kinayayume                         |
||||    Email  :: alinkokomansuby@gmail.com          |
||||    FB     :: https://facebook.com/alinko.jp     |
+----------------------------------------------------+
";
sleep(5);
returnFunc($jc);
}elseif($o == 3)
{

	echo "[i] Checking Operating system .. \n";
	if($jc->detect_os == 'lin')
	{
		echo "[-] Detected Linux system !  \n";
		echo "Save to [ ".getcwd()." ] ::"; $np = trim(fgets(STDIN));
		$np = (empty($np)) ? getcwd() : $np;
		if($jc->J_cauto('src/.autorun-linux',$np))
		{
			echo "[ DONE ]";$jc->runline();

		}else{
			echo "[ FAIL ]";$jc->runline();
		}
		returnFunc($jc);
	}elseif($jc->detect_os == 'win'){
		echo "[-] Detected Windows system ! \n";
		echo "Save to [ ".getcwd()." ] ::"; $np = trim(fgets(STDIN));
		$np = (empty($np)) ? getcwd() : $np;
		if($jc->J_cauto('src/.autorun-windows',$np))
		{
			echo "[ DONE ]";$jc->runline();
		}else{
			echo "[ FAIL ]";$jc->runline();
		}
	}else{
		echo "[-] System unknown :'3 \n";
		echo "Failed to create autorun \n";
	}
	returnFunc($jc);
}elseif($o == 4){
	echo "[i] Checking integrity to the server //// \n";
	echo "[i] It's coming soon ! :D in v2.3 \n";
}else{
SetupFunc($jc);
}

}

SetupFunc($jc);