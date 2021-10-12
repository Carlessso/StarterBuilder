<?php

class GrapesService
{
	public static function storeHtml($param)
	{
		$response = new stdClass;

		$response->success = FALSE;

		if (empty($param['classe']) OR empty($param['code'])) 
		{
			echo json_encode($response);
			return;
		}

		$class_name = $param['classe'];

		$class_name = preg_replace('/\s+/', '', $class_name);

		$php_file_name = "app/control/grapes_files/{$class_name}.php";

		$lower_class = strtolower($class_name);

		$html_file_name = "app/resources/grapes_files/{$lower_class}.html";

		try 
		{
			if (file_exists($html_file_name)) {
				unlink($html_file_name);
			}

			$model_html = file_get_contents('app/starter/example.html');

			$model_html = str_replace('{$code}', $param['code'], $model_html);

			//creates the html file
			file_put_contents($html_file_name, $model_html);

			chmod($html_file_name, 0777);
			if (!file_exists($php_file_name)) 
			{

				$model_php = file_get_contents('app/starter/ExampleClass.php');

				$model_php = str_replace('{$class_name}', $class_name, $model_php);
				$model_php = str_replace('{$html_path}', $html_file_name, $model_php);

				file_put_contents($php_file_name, $model_php);

				chmod($php_file_name, 0777);
			}

			$response->success = TRUE;
		} 
		catch (Exception $e)
		{
			$response->error = $e->getMessage();
		}

		echo json_encode($response);
	}	

}