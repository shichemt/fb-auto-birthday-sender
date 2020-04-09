<?php
const FACEBOOK_UID = ""; // Facebook User ID
const FACEBOOK_XS = ""; // Get Your Facebook XS from your cookies

class FacebookAccount { 
            
	private $url = "https://m.facebook.com/home.php?sk=h_chr";
	private $cuser;
	private $xs;
	private $birthday_url = "https://m.facebook.com/browse/birthdays/";
    
	public function __construct ($cuser, $xs) {
		$this->cuser = $cuser;
		$this->xs = $xs;
	}
	
	public function getBirthdays () {
		
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, $this->birthday_url);  
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_COOKIE, 'c_user='.$this->cuser.'; xs='.$this->xs.'; path=/');  
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0');
		curl_setopt($ch, CURLOPT_FILETIME, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_REFERER, $this->birthday_url);  
		$content = curl_exec( $ch );
		$response = curl_getinfo( $ch );
		curl_close ( $ch );
		return $content;
	}
	
	public function getUserId ($userProfile) {
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, "https://m.facebook.com/".$userProfile);  
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_COOKIE, 'c_user='.$this->cuser.'; xs='.$this->xs.'; path=/');  
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0');
		curl_setopt($ch, CURLOPT_FILETIME, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_REFERER, "https://m.facebook.com/".$userProfile);  
		
		
		$content = curl_exec( $ch );

		$response = curl_getinfo( $ch );
		curl_close ( $ch );
		
		
		if (preg_match("/(\<a href=\"\/messages\/thread\/)([0-9]{1,20})/is", $content, $matches)) {
			return $matches[2];	
		}
		
	}
	
	
	
	public function sendMessage ($userID, $message="Happy Birthday 😊") {
		$ch = curl_init();  
		curl_setopt($ch, CURLOPT_URL, "https://mbasic.facebook.com/messages/compose/?ids=".$userID."");  
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_COOKIE, 'c_user='.$this->cuser.'; xs='.$this->xs.'; path=/');  
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0');
		curl_setopt($ch, CURLOPT_FILETIME, 1);  
		curl_setopt($ch, CURLOPT_TIMEOUT, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_REFERER, "https://m.facebook.com/messages/read/?fbid=".$userID."&_rdr");  
		$content = curl_exec( $ch );
		$response = curl_getinfo( $ch );
		curl_close ( $ch );
		
		$post_fields = "";
		
		if (preg_match('/\<form method=\"post\" action=\"\/messages\/send\/\?icm=1"(.*)\<\/form>/iU', $content, $formMatches) == 1) {
			
			$formHTML = $formMatches[0];
			unset($formMatches);
			
			if (preg_match_all('/\<input type=\"hidden\" name=\"(.*)\" value=\"(.*)\"/iU', $formHTML, $formMatches) > 0) {
				
				for ($fieldCounter = 0; $fieldCounter<count($formMatches[1]); $fieldCounter++) {
					 $post_fields .= $formMatches[1][$fieldCounter] . "=" . rawurlencode($formMatches[2][$fieldCounter]) . "&";
				}
				
				$post_fields .= "body=".rawurlencode($message); 
				$post_fields .= "&send=Send"; 
				
			}
			
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://m.facebook.com/messages/send/?icm=1&amp;refid=12");  
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			curl_setopt($ch, CURLOPT_COOKIE, 'c_user='.$this->cuser.'; xs='.$this->xs.'; path=/');  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
			curl_setopt($ch, CURLOPT_POST, 1);  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);  
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0');
			curl_setopt($ch, CURLOPT_FILETIME, 1);  
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
			curl_setopt($ch, CURLOPT_REFERER, "https://m.facebook.com/messages/send/?icm=1&amp;refid=12");  
			$content = curl_exec( $ch );
			$response = curl_getinfo( $ch );
			curl_close ( $ch );
			
			if (strpos(strip_tags($content), $message . "Just now") != false) {
				return true;
			}
			
			
			return false;
		
		}
		
		
					
		
		
		
	}
	
	public function sendBirthdays () {
		
		$content = $this->getBirthdays();
		$regex = "/\<h3\>(\<a(.*)href=\")(.*)(\">)(.*)\<\/h3\>/iUs";
		
		
		
		if (preg_match_all($regex, $content, $matches)) {
			
			foreach ($matches[3] as $userProfile) {
				$this->sendMessage($this->getUserId($userProfile));
			}
		}

	}

}


	$myAccount = new FacebookAccount(FACEBOOK_UID, FACEBOOK_XS);
	$myAccount->sendBirthdays();

?>
