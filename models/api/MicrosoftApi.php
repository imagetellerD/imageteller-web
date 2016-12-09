<?php
namespace app\models\api;

use Yii;

class MicrosoftApi {
	public $apiAddress = 'https://api.cognitive.azure.cn/vision/v1.0';

	public function analystImage($filename, $language) {
		if (!is_string($filename) || !file_exists($filename)) {
			Yii::warning("{$filename} not exist.");
			return [];
		}
		$ch = curl_init();
		$post_data = [
			'image' => "@{$filename}",
		];
		$url = $this->apiAddress . '/analyze?' . http_build_query([
			'visualFeatures' => ($language == 'en' ? 'Tags,Description' : 'Tags'),
			'details' => 'Celebrities',
			'language' => $language,
		]);
		$headers = [
			"Content-Type:multipart/form-data",
			"Ocp-Apim-Subscription-Key:" . Yii::$app->params['MICROSOFT_VISION_TOKEN'],
		];
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	
		$response = curl_exec($ch);
		if ($response) {
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$headers = substr($response, 0, $header_size);
			$body = json_decode(substr($response, $header_size), true);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpCode == '200' && $body != null) {
				return $body;
			} else {
				Yii::warning(sprintf("call microsoft image analyst api failed, http code: %s, response: %s", $httpCode, $response));
			}
		} else {
			Yii::warning("call microsoft image analyst api failed, nothing returned.");
		}
		return [];
	}
}
