<?php
require_once 'Autoloader.php';
Autoloader::register();
new Api();

class Api
{
	private static $db;

	public static function getDb()
	{
		return self::$db;
	}

	public function __construct()
	{
		self::$db = (new Database())->init();

		//$uri = strtolower(trim((string)$_SERVER['PATH_INFO'], '/'));
		$uri = strtolower(trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

		$httpVerb = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'cli';

		$wildcards = [
			':any' => '[^/]+',
			':num' => '[0-9]+',
		];
		$routes = [
			'get constructionStages' => [
				'class' => 'ConstructionStages',
				'method' => 'getAll',
			],
			'get constructionStages/(:num)' => [
				'class' => 'ConstructionStages',
				'method' => 'getSingle',
			],
			'post constructionStages' => [
				'class' => 'ConstructionStages',
				'method' => 'post',
				'bodyType' => 'ConstructionStagesCreate'
			],
			'patch constructionStages/(:num)' => [
				'class' => 'ConstructionStages',
				'method' => 'patch',
				'bodyType' => 'ConstructionStagesUpdate'
			],
			'delete constructionStages/(:num)' => [
				'class' => 'ConstructionStages',
				'method' => 'delete',
			],
		];

		$response = [
			'error' => 'No such route',
		];

		if ($uri) {
			foreach ($routes as $pattern => $target) {
				$pattern = str_replace(array_keys($wildcards), array_values($wildcards), $pattern);
				if (preg_match('#^'.$pattern.'$#i', "{$httpVerb} {$uri}", $matches)) {
					$params = [];
					array_shift($matches);
					try {
						if (isset($target['bodyType']) && in_array($httpVerb, ['post', 'patch', 'put']) ) {
							$data = json_decode(file_get_contents('php://input'));
							if ($httpVerb !== 'post' && isset($matches[0])) {
								$params = [new $target['bodyType']($data, (int)$matches[0])];
							} else {
								$params = [new $target['bodyType']($data)];
							}
						}
						$params = array_merge($params, $matches);
						$response = call_user_func_array([new $target['class'], $target['method']], $params);
					} catch (Throwable $e) {
						$response = ['error' => $e->getMessage()];
					}
					break;
				}
			}

			//echo json_encode($response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
			$jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
			header('Content-Type: application/json');
			print_r($jsonResponse);
		}
	}
}