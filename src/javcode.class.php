<?php 
/**
*
* [ JSENDER ( JAVCODE SENDER ) VERSION 2.0 ]
*
*----------------------------------------------------------------------------------------------
* ## BUKAN BUAT NOOB USER YANG MANJA MINTA DI AJARIN DARI AWAL CARA PEMAKAIAN.
* ## SEMUA TUTORIAL SUDAH ADA DI ```README.HTML``` TOLONG BUDAYAKAN MEMBANCA SEBELUM MEMAKAI. 
* ## JIKA ADA ERROR? TANYAIN KE GRUB @see https://facebook.com/groups/jc.javcode
*----------------------------------------------------------------------------------------------
*
* @author shutdown57 ( alinko ) < indonesianpeople.shutdown57@gmail.com >
* @version 2.0 2018 Edition.
* @see https://github.com/phpmailer/phpmailer 
* @see https://github.com/alintamvanz
* @copyright (c) 2018 
*
* +---------------------------------------------------------+
* | NOTE !!! : JANGAN DI HAPUS APAPUN YANG ADA DI FILE INI  |
* +---------------------------------------------------------+
*
**/

require 'src/PHPMailerAutoload.php';
error_reporting(0);
date_default_timezone_set('Asia/Tokyo');

class JavCode{
	public $src = "src/";
	public $conf = "config/";
	public $ml = "_ML_/";
	public $detect_os;
	public $mail;
	public $racikan;
	public $letter;
	public $read;
	public function __construct()
	{
		 if(phpversion() < "7.0.0"){
           die("PHP ".phpversion()." TIDAK SUPPORT SILAHKAN UPDATE KE PHP 7\r\n");
        }
        /*if(!function_exists('curl_init')) {
            die('cURL tidak ditemukan ! silahkan install curl '.$this->d());
        }*/
		$this->detect_os  = substr(strtolower(PHP_OS),0,3);
		$this->mail = new PHPMailer();
        $this->clear();
	
	}
	
	public function J_ml($num)
	{
		$s = scandir('_ML_');
		return $s[$num];
	}
	    public function d(){
    	$cekos = substr(strtolower(PHP_OS),0,3);
    	if($cekos == 'win'){
    		return "\r\n";
    	}elseif($cekos == 'nix'){
    		return "\n";
    	}else{
    		return PHP_EOL;
    	}
    }
	public function J_scan(){
		echo "\n[i] Scanning file in '_ML_/' ... \n".$this->d();
		sleep(1);
		$s = scandir('_ML_');
		$count = count($s)-1;
		for($i=0;$i<=$count;$i++){
			if($s[$i] == '.' || $s[$i] == '..'){
				echo "[ ".$i." ] ".$s[$i]." => ga bisa di pilih ".$this->d();
			}else{
			echo "[ ".$i." ] ".$s[$i]."".$this->d();
		}
		}
		echo "\n-------------[ Pilih file nomer 2-".$count." ]-------------".$this->d();
	}
	public function clear()
	{
		if($this->detect_os == 'nix'){
        return @system('clear');
    	}elseif($this->detect_os == 'win'){
        return @system('cls');
    	}else{
    	return @system('clear');
    	}
	}
	public function J_smtp($text = array())
    {
    	$isi = "// Jsender v2 | powered by : JavCode project 2018 \n".$this->d();
		$isi.= "@javcode_smtphost = '".$text[0]."'; ".$this->d();
		$isi.= "@javcode_smtpport = '".$text[1]."'; ".$this->d();
		$isi.= "@javcode_smtpuser = '".$text[2]."'; ".$this->d();
		$isi.= "@javcode_smtppass = '".$text[3]."'; ".$this->d();
		$isi.= "@javcode_priority = '".$text[4]."'; ".$this->d();
		$isi.= "@javcode_encoding = '".$text[5]."'; ".$this->d();
		return $this->J_save($this->conf.'/smtp.javcode.conf',$isi);
    }
    public function J_base($np = array())
    {
    	$isi = "// Jsender v2 | powered by : JavCode project 2018 \n".$this->d();
    	$isi.= "@javcode_mailist = '".$np['mailist']."';".$this->d();
		$isi.= "@javcode_letter  = '".$np['letter']."';".$this->d();
    	$isi.= "@javcode_sendername = '".$np['sendername']."';".$this->d();
		$isi.= "@javcode_sendermail = '".$np['sendermail']."';".$this->d();
		$isi.= "@javcode_subject = '".$np['subject']."';\n".$this->d();
		$isi.= "//===== [ delay setting ] ==== //".$this->d();
		$isi.= "@javcode_delay   = '".$np['delay']."';".$this->d();
		$isi.= "@javcode_pause   = '".$np['limits']."';".$this->d();
		$isi.= "@javcode_delayp  = '".$np['delays']."';".$this->d();
		return $this->J_save($this->conf.'setting.javcode.conf',$isi);
    }
	public function J_save($fn,$tt){
    	$fp = fopen($fn,'w');
    	return fwrite($fp,$tt);
    	fclose($fp);
    }
	public function J_ucapanselamat()
	{
		$now = date('H');
		if($now < 15)
		{
			$r = "Selamat pagi";
		}elseif($now < 19)
		{
			$r = "Selamat sore";
		}elseif($now < 23)
		{
			$r = "Selamat malam";
		}else{
			$r = "Selamat datang";
		}
		return $r;
	}
	 public function J_logError($email,$error,$date)
    {
        $file = fopen("error_log.txt","a");
        fwrite($file,"error[] = ['Jsender','".date('D, d m Y H:i:s')."','".$email."','".$error."'];\n");
        fclose($file);
    }
	public function J_ask($host,$dir)
	{
		$h = str_replace(" ","",strtolower(substr($host,0,7)));
		echo "[".$h."][JavCode]::".$dir." >>"; $this->read = trim(fgets(STDIN));
	}
	public function J_getConfig($conf)
	{
		$pn = file_get_contents($conf);
		$np = str_replace("@javcode_","\$",$pn);
		return $np;
	}
	public function J_replace($np,$lt){
		$letter = file_get_contents($lt);
		foreach ($np as $key => $value) {
			$letter = str_replace($key, $value, $letter);
		}
		return $letter;
	}
	public function J_letter($lt,$email)
	{
		$array = array(
			'##email##' => $email,
			'##ip##' => $this->J_random('ip'),
			'##browser##' => $this->J_getRandom('browser'),
			'##os##' => $this->J_getRandom('os'),
			'##country##' => $this->J_getRandom('country'),
			'##date##' => date('D, d M Y'),
			'##subject##' => $this->J_getRandom('subject'),
			'##sendermail##' => $this->J_getRandom('sendermail'),
			'##sendername##' => $this->J_getRandom('sendername'),
			'##shortlink##' => $this->J_getRandom('shortlink'));
		return $this->J_replace($array,$lt);
	}
	public function _rr_($l)
	{
		if(empty($l))
		{
			$c = 'random';
		}else{
			$c = $l;
		}
		return $c;
	}
	public function J_getFile($file)
    {
    	if(function_exists('file_get_contents'))
    	{
    		$r = file_get_contents($file);
    	}else{
    		$r = file($file);
    	}
    	return $r;
    }
	public function J_cek_token($pusatData){
	$c = curl_init();
	$setopt = array(CURLOPT_URL=>$pusatData,
					CURLOPT_RETURNTRANSFER=>true,
					CURLOPT_SSL_VERIFYPEER=>true);
	curl_setopt_array($c,$setopt);
	return curl_exec($c);
	curl_close($c);
	}
	public function J_header($min,$max,$email)
	{
		$date = date('H:i:s');
		echo "[Jsender][$date][$min/$max]";
		$this->runlineII();
		echo $email;
	}
	public function y()
	{
    list($usec, $sec) = explode(" ", microtime());
    return ((int)$usec + (int)$sec);
	}
	public function J_footer($np,$s =true){
		echo " :: 1send/".$np." sec. [";
		if($s == true){
			echo " SENT ";
		}else{
			echo " FAIL ";
		}
		echo "]".$this->d();
	}
	public function J_ambilLimit($limit)
    {
    	if(strpos($limit,"-") !== false)
    	{
    		$result = explode("-",$limit);
    	}else{
    		echo "Format $limit not valid !  ".$this->d();
    		exit;
    	}
    	return $result;
    }
     public function J_random($jenis = 'str',$max = null)
	{
		if($jenis == 'str')
		{
			$char = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM";
			for ($i=0; $i <= $max; $i++) { 
				$get = rand(0,strlen($char)-1);
				@$ret.=$char[$get];
			}
		}elseif($jenis == 'num')
		{
			$char = "1234567890";
			for ($i=0; $i <= $max ; $i++) { 
				$get = rand(0,strlen($char)-1);
				@$ret.=$char[$get];
			}
		}elseif($jenis == 'mix'){
			$char = "1234567890poiuytrewqazxsdcvfgbnhjmklQAZXSWEDCVFRTGBNHYUJMKIOLP";
			for ($i=0; $i <= $max; $i++) { 
				$get = rand(0,strlen($char)-1);
				@$ret.=$char[$get];
			}
		}elseif($jenis == 'ip'){
			$ret = rand(10,255).".".rand(10,255).".".rand(10,255).".".rand(10,255);
		}

		return $ret;
	}

	public function J_esputer($file)
	{
		 $randtext = file_get_contents("random/text.javcode.txt");
		 $randtext = explode(PHP_EOL,$randtext);
		 $randtext = $randtext[array_rand($randtext)];

		 $str = array('[rand_str]','[rand_num]','[rand_mix]','[rand_ip]','[rand_text]');
		 $rpl = array($this->J_random('str',8),$this->J_random('num',8),$this->J_random('mix',8),$this->J_random('ip',8),$randtext);
		 $f = file_get_contents($file);
		 $f = explode(PHP_EOL,$f);
		 $a = array();
		 foreach($f as $v)
		 {
		 		$v = str_replace($str,$rpl,$v);
		  		array_push($a,$v);
		 }
		 shuffle($a);
		 return array_shift($a);
	}
	public function J_getRandom($type)
	{
		$fsubject = "random/subject.javcode.txt";
		$fsendername = "random/sendername.javcode.txt";
		$fsendermail = "random/sendermail.javcode.txt";
		$fos = "random/os.javcode.txt";
		$fbrowser = "random/browser.javcode.txt";
		$fcountry = "random/country.javcode.txt";
		$fshortlink = "random/shortlink.javcode.txt";
		$ftext = "random/text.javcode.txt";
		
		if(file_exists($fsubject) && file_exists($fsendername) && file_exists($fsendermail))
		{
		  if($type == 'subject')
		 {
		  	$r =$this->J_esputer($fsubject);
		 	
		}elseif($type == 'sendermail')
		{
			$r =$this->J_esputer($fsendermail);
		}elseif($type == 'sendername')
		{
			$r =$this->J_esputer($fsendername);
		}elseif($type == 'os')
		{
			$r =$this->J_esputer($fos);
		}elseif($type == 'country')
		{
			$r =$this->J_esputer($fcountry);
		}elseif($type == 'browser')
		{
			$r =$this->J_esputer($fbrowser);
		}elseif($type == 'shortlink')
		{
			$r = $this->J_esputer($fshortlink);
		}elseif($type == 'text')
		{
			$r = $this->J_esputer($ftext);
		}
		}
		return $r;
	}
	public function rnd($ap,$n)
	{
		if($ap == 'random')
		{
			$npy = $this->J_getRandom($n);
		}else{
			$npy = $ap;
		}
		return $npy;
	}
	public function runline($max=40,$eol=PHP_EOL)
	{
	echo "[";usleep(10000);
	for($i=0;$i<=$max;$i++)
	{
		echo "=";
		usleep(10000);
	}
	echo "]".$eol;
	}
	public function pause($del)
	{
		$time = (int)$del*1000000/10;
        $st=$this->y();
        echo "[Jsender][PAUSE][".$del." Seconds] [";
        for($i=0;$i<=10;$i++)
        {
        	echo "==";
        	usleep($time);
        }
        $en=$this->y();
        $p=($en-$st);
        echo "] $p Second elapsed. \n";
	}
	public function runlineII()
	{
		$kata = array(' ','S','E','N','D',' ','T','O',' :: ');
		foreach($kata as $load)
		{
			echo $load;
			usleep(60000);
		}
	}
	public function J_cauto($file,$des)
	{
		$f = file_get_contents($file);
		$r = array("#PathJsender#");
		$p = array(getcwd());
		$rr = str_replace($r,$p,$f);
		return $this->J_save($des.'/jsender.desktop',$rr);
	}
	public function J_Banner()
	{$this->clear();
		$template = array();
		$template[0]  = "
	     ??         
            ????
             ??
   ??????   ???????????? 
   ??????   ????????????  === ===== ===== = = = = = == = = ==== = = 
   ???      ???      ???     Jsender | JavCode Project (c) 2018 
   ???      ???      ???  == == == == == == ======   ======  === ==        
            ???                   __                    __         
            ???                  / /_______  ____  ____/ /__  _____
   ???      ???      ???    __  / / ___/ _ \/ __ \/ __  / _ \/ ___/
   ???      ???      ???   / /_/ (__  )  __/ / / / /_/ /  __/ /    
   ?????????????????????   \____/____/\___/_/ /_/\__,_/\___/_/  v2
   ?????????????????????  == ==  ===  === =====  ===== ==  = == ===

";
       $template[1] = "
 .____       ____.         ____. +===============================
 |   _|     |    | ______ |_   | | -- - Jsender v2  .---  -  - -|
 |  |       |    |/  ___/   |  | | Jsender v2 . ----------------|
 |  |   /\__|    |\___ \    |  | |==================== = =======|
 |  |_  \________/____  >  _|  | |   JavCode project (c) 2018   |
 |____|               \/  |____| +===============================

";
	   $template[2] = "
JembutJaranJan_ ____tJaranJancokJem _ utJaranJancokJembutJ
JembutJaranJa| / ___|  ___ _ __   __| | ___ _ __ okJembutJ
JembutJara_Ja| \___ \ / _ \ '_ \ / _` |/ _ \ '__|okJembutJ
JembutJar| |_| |___) |  __/ | | | (_| |  __/ |ancokJembutJ
JembutJara\___/|____/ \___|_| |_|\__,_|\___|_|ancokJembutJ
JembutJaranJancokJembutJaranJancokJembutJaranJancokJembutJ
JembutJ[ TIME TO WORK DUDE : ".date('H:i:s,d M Y')." ]JembutJ
JembutJaranJancokJembutJaranJancokJembutJaranJancokJembutJ

";
		$template[3] = "
+---------------------------------------------------------+
|        #  #####                                         |\  
|        # #     # ###### #    # #####  ###### #####      | \ 
|        # #       #      ##   # #    # #      #    #     | |  
|        #  #####  #####  # #  # #    # #####  #    #     | |  
|  #     #       # #      #  # # #    # #      #####      | |  
|  #     # #     # #      #   ## #    # #      #   #      | |  
|   #####   #####  ###### #    # #####  ###### #    #     | |  
+---------------------------------------------------------+ |
\__________________________________________________________\|

";
       
       print $template[rand(0,count($template)-1)];

	}
	
}

$jc = new JavCode;



?>