<?php

class GrapesService
{
	public static function storeHtml($param)
	{
		$response = new stdClass;

		$response->success = FALSE;

		$class_name = 'TestePage';

		$php_file_name = "app/control/grapes_files/{$class_name}.php";
		
		$html_file_name = 'app/resources/grapes_files/teste.html';

		try 
		{
			$model_html = file_get_contents('app/starter/example.html');

			$model_html = str_replace('{$code}', $param['code'], $model_html);


			//creates the html file
			file_put_contents($html_file_name, $model_html);

			$model_php = file_get_contents('app/starter/ExampleClass.php');

			$model_php = str_replace('{$class_name}', $class_name, $model_php);
			$model_php = str_replace('{$html_path}', $html_file_name, $model_php);

			file_put_contents($php_file_name, $model_php);

			$response->success = TRUE;
		} 
		catch (Exception $e) 
		{
			$response->error = $e->getMessage();
		}

		echo json_encode($response);

	}	

}