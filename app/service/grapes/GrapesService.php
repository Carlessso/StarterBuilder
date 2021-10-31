<?php

class GrapesService
{
	public static function storeHtml($param)
	{
		$response = new stdClass;

		$response->success = FALSE;

		if (empty($param['classe']) OR empty($param['htmlCode'])) 
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

			$model_html = str_replace('{$css_code}', json_decode($param['cssCode']), $model_html);
			$model_html = str_replace('{$code}', json_decode($param['htmlCode']), $model_html);

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

	public static function storePageFile($param)
	{
		$response = new stdClass;

		$response->success = FALSE;

		if (empty($param['htmlCode'])) 
		{
			echo json_encode($response);
			return;
		}

		$file_name = $param['name'];

		$file_name = preg_replace('/\s+/', '', $file_name);

		$lower_class = strtolower($file_name);

		$html_file_name = "app/resources/grapes_pages/{$lower_class}.html";

		try 
		{
			if (file_exists($html_file_name)) {
				unlink($html_file_name);
			}

			$model_html = file_get_contents('app/starter/example.html');

			$model_html = str_replace('{$css_code}', json_decode($param['cssCode']), $model_html);
			$model_html = str_replace('{$code}', json_decode($param['htmlCode']), $model_html);


			if(strpos($model_html, '<script>') !== false)
			{
				$model_html = strstr($model_html, '<script>', true);
			}


			//creates the html file
			file_put_contents($html_file_name, $model_html);

			chmod($html_file_name, 0777);

			$response->path    = $html_file_name;
			$response->success = TRUE;
		} 
		catch (Exception $e)
		{
			$response->error = $e->getMessage();
		}

		echo json_encode($response);
	}

	public static function storeComponentFile($param)
	{
		$response = new stdClass;

		$response->success = FALSE;

		if (empty($param['htmlCode'])) 
		{
			echo json_encode($response);
			return;
		}

		$file_name = $param['name'];

		$file_name = preg_replace('/\s+/', '', $file_name);

		$lower_class = strtolower($file_name);

		$html_file_name = "app/resources/grapes_components/{$lower_class}.html";

		try 
		{
			if (file_exists($html_file_name)) {
				unlink($html_file_name);
			}

			$model_html = file_get_contents('app/starter/example.html');

			$model_html = str_replace('{$css_code}', json_decode($param['cssCode']), $model_html);
			$model_html = str_replace('{$code}', json_decode($param['htmlCode']), $model_html);


			if(strpos($model_html, '<script>') !== false)
			{
				$model_html = strstr($model_html, '<script>', true);
			}


			//creates the html file
			file_put_contents($html_file_name, $model_html);

			chmod($html_file_name, 0777);

			$response->path    = $html_file_name;
			$response->success = TRUE;
		} 
		catch (Exception $e)
		{
			$response->error = $e->getMessage();
		}

		echo json_encode($response);
	}	

	public static function saveClass($page_id, $class_name): string
	{
		TTransaction::open('starter');
		$page = Page::find($page_id);
		TTransaction::close();

		$class_name = preg_replace('/\s+/', '', $class_name);

		$php_file_name = "app/control/grapes_classes/{$class_name}.php";

		try 
		{
			if (!file_exists($php_file_name)) 
			{
				$model_php = file_get_contents('app/starter/ExampleClass.php');

				$model_php = str_replace('{$class_name}', $class_name, $model_php);
				$model_php = str_replace('{$html_path}', $page->path, $model_php);

				file_put_contents($php_file_name, $model_php);

				chmod($php_file_name, 0777);
			}

		} 
		catch (Exception $e)
		{
			throw $e;
		}

		return $php_file_name;
	}
}