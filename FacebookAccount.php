<?php
	
	const FACEBOOK_UID = ""; // Facebook User ID
	const FACEBOOK_XS = ""; // Get Your Facebook XS from your cookies
	
	
	define ("ENCODE_TAG", '<meta http-equiv="content-type" content="text/html; charset=utf-8">');
	define ("TUNISIE", "10201593719587610");
	
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
			curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0');
			curl_setopt($ch, CURLOPT_FILETIME, 1);  
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
			curl_setopt($ch, CURLOPT_REFERER, "https://m.facebook.com/".$userProfile);  
			
			$content = curl_exec( $ch );
			$response = curl_getinfo( $ch );
			curl_close ( $ch );
			
			
			if (preg_match("/\<input type=\"hidden\" name=\"id\" value=\"(\d{1,})\" \/>/iUs", $content, $matches)) {
				return $matches[1];
			}
			
			
			
			
			
		}
		
		
		
		public function sendMessage ($userID, $message="Happy Birthday ðŸ˜Š") {
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, "https://m.facebook.com/messages/read/?fbid=".$userID."&_rdr");  
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
			curl_setopt($ch, CURLOPT_REFERER, "https://m.facebook.com/messages/read/?fbid=".$userID."&_rdr");  
			
			$content = curl_exec( $ch );
			$response = curl_getinfo( $ch );
			curl_close ( $ch );
			
			
			
			$post_fields = "";
			
			if (preg_match_all ("/\<form method=\"post\" class=\"(.*)\" id=\"composer_form\" action=\"\/messages\/send\/\?icm=1&amp;refid=12\"\>(.*)\<\/form\>/iUs", $content, $forms) ) {
				
				
				
				if (preg_match_all("/\<input(.*)\/>/iUs", $forms[0][0], $inputs)) {
					
					
					
					foreach ($inputs[0] as $input) {
						
						if (preg_match("/name=\"(.*)\"/iUs", $input, $name) && preg_match("/value=\"(.*)\"/iUs", $input, $value) && preg_match("/type=\"(.*)\"/iUs", $input, $types)) {
							
							if ($types[1] == "hidden")
							$post_fields .= $name[1] . "=". $value[1] ."&";
						}
						
						
					}
					
					
				}
				
			}
			
			$post_fields .= "&body=".rawurlencode($message);	
			
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
			
		}
		
		public function sendBirthdays () {
			
			$content = $this->getBirthdays();
			$regex = "/\<h3\>\<a href=\"(.*)\">(.+)\<\/a><\/h3>/iUs";
			
			if (preg_match_all($regex, $content, $matches)) {
				foreach ($matches[1] as $userProfile) {
					
					$this->sendMessage($this->getUserId($userProfile));
					
				}
				
			}
			
			
			
			
		}
		
		
		/*  Facebook News Feed Part 
			*	Begin
			*	Under Construction
		*/
		
		private function getMainStream($content)
		{
			$doc = new DOMDocument();
			libxml_use_internal_errors(true);
			@$doc->loadHTML(ENCODE_TAG.$content);
			
			foreach ($doc->getElementsByTagName('div') as $div) {
				$class = $div->getAttribute('id');
				if ($class == "m_newsfeed_stream") {
					$news_feed = $div;
					$html = $doc->saveHTML($news_feed);
					break;
				}
				
			}
			
			
			return $html;
		}
		
		private function getPostsNoTime ($contentArr) 
		{
			$arr = array();
			$i=0;
			// Get all posts 
			foreach ($contentArr as $content) {
				
				$doc = new DOMDocument();
				libxml_use_internal_errors(true);
				@$doc->loadHTML(ENCODE_TAG.$content);
				
				$arr[$i]['post'] = ($doc->saveHTML($doc->getElementsByTagName('div')->item(1)));
				
				preg_match('/href="\/nfx(.*)\"/isU', $content, $match);
				preg_match('/\"S:_I(\d{1,}):(\d{1,})\"/', urldecode($match[1]), $ids);
				
				$arr[$i]['page_id'] = $ids[1];
				$arr[$i]['post_id'] = $ids[2];
				
				if (preg_match('/\<a (.{2,25}) href=\"\/video_redirect\/(.*)\"(.*)\>\<img src=\"(.*)safe_image\.php(.*)\"(.*)\>/isU', $arr[$i]['post'], $matches)) {
					
					$arr[$i]['post'] = str_ireplace($matches[0], '  <div class="fb-video"
					data-href="https://www.facebook.com/'.$arr[$i]['page_id'].'/videos/'.$arr[$i]['post_id'].'/"
					data-width="500"
					data-allowfullscreen="true"></div>', $arr[$i]['post']);
				}
				
				$i++;
			}
			return $arr;
		}
		
		private function getUnfilteredPosts ($content)
		{
			$arr = array();
			
			// Get all posts 
			$doc = new DOMDocument();
			libxml_use_internal_errors(true);
			@$doc->loadHTML(ENCODE_TAG.$content);
			$allDivs = $doc->getElementsByTagName('div')->item(3);
			$html = $doc->saveHTML($allDivs);
			
			
			// Get all posts end
			
			
			$dox = new DOMDocument();
			libxml_use_internal_errors(true);
			@$dox->loadHTML(ENCODE_TAG.$html);
			
			$xpath = new DOMXPath($dox);
			
			
			// 1st item
			$nodes= $xpath->query("(//div[@class]/div[(@id) and (@class)])[1]");
			$arr[0] = $dox->saveHTML($nodes->item(0));
			
			
			
			$nodes= $xpath->query("//div[@class]/div[(@id) and (@class)]/following-sibling::div");
			
			$posts = 1;
			foreach ( $nodes as $post) {
				
				$arr[$posts++] = 	$dox->saveHTML($post);
				
			}
			
			return $arr;
		}
		
		private function filteredPosts ($postsArr)
		{
			$newArr = array();
			$j = 0;
			for ($i=0; $i<count($postsArr); $i++) {
				if (!preg_match('/(Suggested Post|was mentioned in|liked this)/isU', $postsArr[$i], $matches)) {
					$newArr[$j++] = $postsArr[$i];
					
				}
				
			}
			
			for ($k=0; $k<count($newArr); $k++) {
				$newArr[$k] = preg_replace('/<h3 (.*) posted (\d) updates.\<\/h3>/iUs', '', $newArr[$k]);
			}
			return $newArr;
			
		}
		
		private function getFacebookContent($linkUrl = '') 
		{
			
			if (!!(empty($linkUrl))) 
			$linkUrl = $this->url;
			
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $linkUrl);  
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
			curl_setopt($ch, CURLOPT_REFERER, $linkUrl);  
			
			$content = curl_exec( $ch );
			$response = curl_getinfo( $ch );
			curl_close ( $ch );
			
			return $content;
		}
		
		public function getMainPosts ($linkUrl = '')
		{
			return $this->filteredPosts($this->getUnfilteredPosts(($this->getMainStream($this->getFacebookContent($linkUrl)))));
		}v
		
		public function getInterestFeed($interestId) 
		{
			$interestUrl = "https://m.facebook.com/home.php?sk=fl_".$interestId."&ref=bookmarks";
			$interestFeed = $this->getPostsNoTime($this->getMainPosts($interestUrl));
			return $interestFeed;
		}
		
		/*  Facebook News Feed Part 
			*	End
			*	Under Construction
		*/
		
		
		
	}
	
	
	$myAccount = new FacebookAccount(FACEBOOK_UID, FACEBOOK_XS);
	
	$myAccount->sendBirthdays();
	
	
?>
