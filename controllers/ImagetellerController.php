<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use app\common\AjaxErrorCode;
use app\models\ThriftAdapter;

class ImagetellerController extends BaseController {
	public $defaultAction = 'index';

	public function actionImageAnalyst($language='en') {
		$files = UploadedFile::getInstancesByName('image');
		if (!$files || !isset($files[0])) {
			return $this->renderAjax(AjaxErrorCode::PARAMS_MISSING, 'No image uploaded');
		}
		$image = $files[0];
		$tmpPath = Yii::$app->params['UPLOAD_TMP_PATH'];
		list($type, $ext) = explode('/', $image->type);
		$tmpPath = "{$tmpPath}/{$image->name}.{$ext}";
		if ($image->saveAs($tmpPath, true)) {
			$api = new \app\models\api\MicrosoftApi();
			$ret = $api->analystImage($tmpPath, ($language == 'en' ? 'en' : 'zh'));
			if ($ret) {
				$data = [
					'tags' => [],
					'descriptions' => [],
				];
				$tagConfidenceMap = []; //记录tag name 和confidence的map，用于排序
				if (isset($ret['description']) && is_array($ret['description'])) {
					if (isset($ret['description']['captions']) && is_array($ret['description']['captions'])) {
						foreach($ret['description']['captions'] as $desc) {
							$data['descriptions'][] = $desc['text'];
						}
					}
					$limit = 5; //我最多只要5个！
					if (isset($ret['description']['tags']) && is_array($ret['description']['tags'])) {
						foreach($ret['description']['tags'] as $text) {
							if ($limit < 0) {
								break;
							}
							$limit--;
							$data['tags'][$text] = [
								'text' => $text,
								'confidence' => '75',
							];
							//大家都是75,何必互相为难
							#$tagConfidenceMap[$text] = !$tagConfidenceMap[$text] ? 75 : ($tagConfidenceMap[$text] > 75 ? $tagConfidenceMap[$text] : 75);
							$tagConfidenceMap[$text] = 75;
						}
					}
				}
				if (isset($ret['tags']) && is_array($ret['tags'])) {
					foreach($ret['tags'] as $tag) {
						$tag['confidence'] = (int)($tag['confidence'] * 100);
						$data['tags'][$tag['name']] = [
							'text' => $tag['name'],
							'confidence' => $tag['confidence'],
						];
						$currentConfidence = $tagConfidenceMap[$tag['name']] ? $tagConfidenceMap[$tag['name']] : 0;
						if ($tag['confidence'] > $currentConfidence) {
							$tagConfidenceMap[$tag['name']] = $tag['confidence'];
						}
					}
				}
				arsort($tagConfidenceMap); //按分数/自信度排序
				//取前20个
				$_tags = [];
				$limit = 20;
				foreach($tagConfidenceMap as $text => $confidence) {
					if ($limit < 0) {	
						break;
					}
					$_tags[] = $data['tags'][$text];
					$limit--;
				}
				$data['tags'] = $_tags;
				
				#$data['tags'] = array_values($data['tags']);
				return $this->renderAjax(AjaxErrorCode::SUCCESS, '', $data);
			} else {
				return $this->renderAjax(AjaxErrorCode::FAILED, 'api returned nothing.');
			}
		} else {
			return $this->renderAjax(AjaxErrorCode::FAILED, 'server error.');
		}
	}	

	public function actionGetPoem($tags = '[]', $descriptions = '[]', $poemTitle = '') {
		if (!$tags && !$descriptions) {
			return $this->renderAjax(AjaxErrorCode::PARAMS_MISSING, '大兄弟你是不是忘了啥');
		}
		if (!is_string($tags) || !is_string($descriptions)) {
			return $this->renderAjax(AjaxErrorCode::INVALID_PARAMS, '大兄弟，我们只要字符串啊');
		}
		$tags = json_decode($tags, true);
		$descriptions = json_decode($descriptions, true);
		if (!is_array($tags) || !is_array($descriptions)) {
			return $this->renderAjax(AjaxErrorCode::INVALID_PARAMS, '大兄弟，你给我的这字符串，不符合基本法啊');
		}

		$thrift = ThriftAdapter::getImageTellerThrift();
		$_tags = [];
		$_descriptions = [];
		foreach($tags as $tag) {
			if (isset($tag['text']) && is_string($tag['text']) && isset($tag['confidence']) && is_numeric($tag['confidence']) && $tag['confidence'] > 0) {
				$_tag = new \Thrift_OMG\ImageTag();
				$_tag->tag = $tag['text'];
				$_tag->confidence = intval($tag['confidence']);
				$_tags[] = $_tag;
			} else {
				Yii::info(sprintf("invalid image tag %s", json_encode($tag)));
			}
		}
		foreach($descriptions as $description) {
			if (is_string($description)) {
				$_description[] = $description;
			} else {
				Yii::info("invalid image description.");
			}
		}
		if ($_tags || $_descriptions) {
			$ret = $thrift->generatePoem($poemTitle, $_tags, $_descriptions);
			if ($ret) {
				return $this->renderAjax(AjaxErrorCode::SUCCESS, '', ['poem' => $ret]);
			} else {
				return $this->renderAjax(AjaxErrorCode::FAILED, '画译娘罢工了!');
			}
		} else {
			return $this->renderAjax(AjaxErrorCode::INVALID_PARAMS, '一个能用的标签都木有啊兄弟');
		}
	}
	
	public function actionGetCreativeText($tags = '[]', $descriptions = '[]') {
		if (!$tags && !$descriptions) {
			return $this->renderAjax(AjaxErrorCode::PARAMS_MISSING, '大兄弟你是不是忘了啥');
		}
		if (!is_string($tags) || !is_string($descriptions)) {
			return $this->renderAjax(AjaxErrorCode::INVALID_PARAMS, '大兄弟，我们只要字符串啊');
		}
		$tags = json_decode($tags, true);
		$descriptions = json_decode($descriptions, true);
		if (!is_array($tags) || !is_array($descriptions)) {
			return $this->renderAjax(AjaxErrorCode::INVALID_PARAMS, '大兄弟，你给我的这字符串，不符合基本法啊');
		}

		$thrift = ThriftAdapter::getImageTellerThrift();
		$_tags = [];
		$_descriptions = [];
		foreach($tags as $tag) {
			#if (isset($tag['text']) && is_string($tag['text']) && isset($tag['confidence']) && is_numeric($tag['confidence']) && $tag['confidence'] > 0) {
			if (isset($tag['text']) && is_string($tag['text'])) {
				$_tags[] = $tag['text'];
			} else {
				Yii::info(sprintf("invalid image tag %s", json_encode($tag)));
			}
		}
		foreach($descriptions as $description) {
			if (is_string($description)) {
				$_description[] = $description;
			} else {
				Yii::info("invalid image description.");
			}
		}
		if ($_tags || $_descriptions) {
			$ret = $thrift->searchCreativeTexts($_tags, $_descriptions);
			if ($ret) {
				return $this->renderAjax(AjaxErrorCode::SUCCESS, '', ['texts' => $ret]);
			} else {
				return $this->renderAjax(AjaxErrorCode::FAILED, '画译娘罢工了！');
			}
		} else {
			return $this->renderAjax(AjaxErrorCode::INVALID_PARAMS, '一个能用的标签都木有啊兄弟');
		}
	}
	
	public function actionIndex() {
		$poemTitles = \app\common\Poem::getPoemTitles();
		return $this->render('index', ['poemTitles' => $poemTitles]);
	}
}
