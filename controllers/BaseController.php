<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

use app\common\AjaxErrorCode;

class BaseController extends Controller
{
	public function renderAjax($errorCode, $message = '', $data = []) {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$messageMap = AjaxErrorCode::getMessage();
		if ($message == '' && isset($messageMap[$errorCode])) {
			$message = $messageMap[$errorCode];
		}
		return [
			'errorCode' => $errorCode,
			'message' => $message,
			'data' => $data,
		];
	}

	public function checkRequiredParams($data, $attrs) {
		
		$missing = [];
		foreach($attrs as $attr) {
			if (!isset($data[$attr])) {
				$missing[] = $attr;
			}
		}
		return empty($missing) ? null : $missing;
	}

	public function checkParamsType($data, $type, $attrs) {
		$invalid = [];
		switch($type) {
		case 'number':
			foreach($attrs as $attr) {
				if (!is_numeric($data[$attr])) {
					$invalid[] = $attr;
				}
			}
		}
		return empty($invalid) ? null : $invalid;
	}
}
