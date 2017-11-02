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
                curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:39.0) Gecko/20100101 Firefox/39.0');
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
            
            
            
            public function sendMessage ($userID, $message="Happy Birthday 😊") {
                $ch = curl_init();  
                curl_setopt($ch, CURLOPT_URL, "https://mbasic.facebook.com/messages/thread/".$userID."/?refid=17");  

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
                
                if (preg_match_all ("/\<form method=\"post\" class=\"(.*)\" id=\"composer_form\" action=\"\/messages\/send\/\?icm=1&amp;refid=12\"\>(.*)\<\/form\>/iUs", $content, $forms) ) {
                    
                    //var_dump($forms[0][0]);
                    
                    if (preg_match_all("/\<input(.*)\/>/iUs", $forms[0][0], $inputs)) {
                        
                        
                        //var_dump($inputs[0]);
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
            
            
        }
        

        $myAccount = new FacebookAccount(FACEBOOK_UID, FACEBOOK_XS);

        $myAccount->sendBirthdays();
?>
