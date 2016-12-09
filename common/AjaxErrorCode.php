<?php
namespace app\common;

class AjaxErrorCode {
	const SUCCESS = 0;
	const FAILED = 1;
	const NEED_LOGIN = 2;
	const PERMISSION_DENY = 3;
	const PARAMS_MISSING = 4;
	const INVALID_PARAMS = 5;


	static public function getMessage() {
		return [
			AjaxErrorCode::SUCCESS => 'success',
			AjaxErrorCode::NEED_LOGIN => 'please login first.',
			AjaxErrorCode::PERMISSION_DENY => 'permission deny.',
			AjaxErrorCode::PARAMS_MISSING => 'params missing.',
			AjaxErrorCode::INVALID_PARAMS => 'invalid params',
		];
	}
}
