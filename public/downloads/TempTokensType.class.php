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
				return get_date_in_time("+30 days");
				break;
			case self::FORGOT_PASSWORD:
				return get_date_in_time("+1 hours");
				break;
			case self::VERIFICATION_EMAIL:
				return get_date_in_time("+2 years");
				break;
			case self::CUSTOMER_ACTIVATION:
				return get_date_in_time("+1 years");
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