---
layout: post
title: Generating secure tokens for forgot password and remember me cookie
---

I was made team lead of a project, that saved passwords in plain text in cookies for remember me, verification email just contained primary key and forgot password just sent the password in mail. 

In short: It was crazy and looked like a sophomore university project. I had to do something to secure most of it. So I decided to generate tokens for such data and sharing code here for help of others.

Why use tokens?
-----------

Let's assume we have a url *http://example.com/verify.php?id=2132* which verifies email id *foo@example.com* and auto logins user with id 2132, once url is hit. A major security blunder is that if I hit *http://example.com/verify.php?id=2133*, *http://example.com/verify.php?id=2134* and so on... I can easily verify all emails in your database and login.

Another example is remember me cookie, people save user ids in cookies and check for user ids in server side script to validate and login users without password. If I make a cookie with any user's id I can easily login.

##Problem statement

Fetch user id from database using user supplied data in cookies, post or get, such that user can't guess or access anyone else's user id.

##Solution

After a lot of research and thinking I came up with this solution:

- Generate a cryptographically secure random token and save it against an expire time and desired user id.
- When a token is supplied via REQUEST, pass token to a function which checks if token exists and is not expired so returns user id otherwise returns false.

This makes sure that identity tokens are random and can't be guessed by anyone.

##Source code

####TempTokens.class.php

{% highlight php %}
<?php
/**
 * This class sets and gets temporary authentication tokens for use in
 * remember me, forgot password and verification mail
 * @file TempTokens.class.php
 */
class TempTokens{
	
	const TABLE = "temp_tokens";
	const TOKEN_SIZE = 50;

	public function __construct($db){
		$this->db = $db;
	}
	/**
	 * sets a token for supplied $uid and $type
	 * @param int $uid  user id to save token against
	 * @param TempTokensType $type type of token see @link TempTokensType
	 * @return string|boolean returns string token if success, false on failure
	 */
	public function set($uid, $type){
		$data['uid'] = intval($uid);
		$data['type'] = intval($type);
		$data['expires'] =  TempTokensType::get_expires($type);
		$data['token'] = $this->generate_token();
		$rules = [
			['required', 'uid, type, expires, token'],
			['min', 'type, uid', 1],
			['enum', 'type', TempTokensType::get_types()],
			['date', 'expires']
		];
		if($this->validator->validate($data, $rules)){
			if($this->db->insert(self::TABLE, $data)){
				return $data['token'];
			}
			else{
				$this->errors['system'][] = "Error in insert query";
				return false;
			}
		}
		else{
			$this->errors += $this->validator->get_errors();
			return false;
		}
	}
	/**
	 * Gets uid against supplied token and type
	 * @param  char[50] $token token of length 50
	 * @param  TempTokensType $type  type of token see @link TempTokensType
	 * @return [type]        [description]
	 */
	public function get($token, $type){
		$token = $this->db->escape($token);
		$type = intval($type);
		$query = "SELECT id, uid, expires FROM " . self::TABLE . 
					" WHERE token = '" . $token . 
					"' AND type = " . $type;
		$token_data = $this->db->fetch_assoc($this->db->query($query));
		if($token_data){
			//token has expired
			if(strtotime($token_data['expires']) <= time()){
				$this->db->delete(self::TABLE, $token_data['id']);
				return false;
			}
			else{
				return $token_data['uid'];
			}
		}
		else{
			return false;
		}
	}
	/**
	 * generates random secure token of self::TOKEN_SIZE size.
	 * @return string generated token
	 */
	private function generate_token(){
		$bytes = openssl_random_pseudo_bytes(self::TOKEN_SIZE);
    	$hex   = bin2hex($bytes);
    	return $hex;
	}

	/**
	 * Simple function to test if everything works correctly
	 */
	public function test(){
		$tokens = new TempTokens;
		if($token = $tokens->set(25, TempTokensType::REMEMBER_ME)){
			$uid = $tokens->get($token, TempTokensType::REMEMBER_ME);
			var_dump($token, $uid);
			if($uid == 25){
				echo "success";
			}
			else{
				echo "failed";
			}
		}
	}
} 

if ($_SERVER['SCRIPT_FILENAME'] == __FILE__) {
	$tokens = new TempTokens;
	$tokens->test();
}
?>
{% endhighlight %}

####TempTokensType.class.php

{% highlight php %}
<?php
class TempTokensType{
	const REMEMBER_ME = 1;
	const FORGOT_PASSWORD = 2;
	const VERIFICATION_EMAIL = 3;
	const CUSTOMER_ACTIVATION = 4;

	public static function get_expires($type){
		switch ($type) {
			case self::REMEMBER_ME:
				//see libs/helpers.php for this function's definition
				return date("Y-m-d H:i:s", strtotime("+30 days"));
				break;
			case self::FORGOT_PASSWORD:
				return date("Y-m-d H:i:s", strtotime("+1 hours"));
				break;
			case self::VERIFICATION_EMAIL:
				return date("Y-m-d H:i:s", strtotime("+2 years"));
				break;
			case self::CUSTOMER_ACTIVATION:
				return date("Y-m-d H:i:s", strtotime("+1 years"));
				break;
			default:
				return false;
				break;
		}
	}

	public static function get_types(){
		return [self::REMEMBER_ME , self::FORGOT_PASSWORD, self::VERIFICATION_EMAIL,self::CUSTOMER_ACTIVATION];
	}
}
?>
{% endhighlight %}