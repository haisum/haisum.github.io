<?php
/**
 * We need access to db object
 */
global $tb_db;
if (!$tb_db) {
	require_once dirname(__FILE__) . "/../myconnect.php";
	require_once dirname(__FILE__) . "/../functions.php";
}
/**
 * This class sets and gets temporary authentication tokens for use in
 * remember me, forgot password and verification mail
 */
class TempTokens extends Model{
	
	const TABLE = "ephpb2b_temp_tokens";
	const TOKEN_SIZE = 50;

	public function set($uid, $type){
		$data['es_uid'] = intval($uid);
		$data['es_type'] = intval($type);
		$data['es_expires'] =  TempTokensType::get_expires($type);
		$data['es_token'] = $this->generate_token();
		$rules = [
			['required', 'es_uid, es_type, es_expires, es_token'],
			['min', 'es_type, es_uid', 1],
			['enum', 'es_type', TempTokensType::get_types()],
			['date', 'es_expires']
		];
		if($this->validator->validate($data, $rules)){
			if($this->db->insert(self::TABLE, $data)){
				return $data['es_token'];
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

	public function get($token, $type){
		$token = $this->db->escape($token);
		$type = intval($type);
		$query = "SELECT es_id, es_uid, es_expires FROM " . self::TABLE . 
					" WHERE es_token = '" . $token . 
					"' AND es_type = " . $type;
		$token_data = $this->db->fetch_assoc($this->db->query($query));
		if($token_data){
			//token has expired
			if(strtotime($token_data['es_expires']) <= time()){
				$this->db->delete(self::TABLE, $token_data['es_id']);
				return false;
			}
			else{
				return $token_data['es_uid'];
			}
		}
		else{
			return false;
		}
	}

	private function generate_token(){
		$bytes = openssl_random_pseudo_bytes(self::TOKEN_SIZE);
    	$hex   = bin2hex($bytes);
    	return $hex;
	}

	public function test(){
		if($token = TempTokens::get_instance()->set(25, TempTokensType::REMEMBER_ME)){
			$uid = TempTokens::get_instance()->get($token, TempTokensType::REMEMBER_ME);
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
	$reg = TempTokens::get_instance();
	$reg->test();
}