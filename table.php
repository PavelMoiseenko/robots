<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
		<style type="text/css">
			td{
				 border: 1px solid black;
			}
		</style>
	</head>
<body>
	<h1>Результат проверки</h1>
	<?php
		
		if (isset($_POST['url'])){
			$url = $_POST['url'];
		}

		$file = basename($url);

		if($f = fopen($url, 'r')){			
			$file_exists = 'Ok';
			fclose($f);
		}
		else{			
			$file_exists = 'Ошибка';
		}

		//Определяем укзание директивы Host и Sitemap
		$lines = file($url);
		$numHost = 0;
		$numSiteMap = 0;
		foreach ($lines as $line) { 
			$host = preg_match('/^Host:/',$line);
			$siteMap = preg_match('/^Sitemap:/',$line);
			if($host==1){
				$numHost++;
			}
			if($siteMap==1){
				$numSiteMap++;
			} 
		}
		if($numHost == 0){
			$host = "Ошибка";
			$numHost = "Ошибка";
		}
		else if($numHost == 1){
			$host = "Оk";
			$numHost = "Ок";
		}
		else{
			$host = "Оk";
			$numHost = "Ошибка";
		}

		if($numSiteMap){
			$numSiteMap = 'Ok';
		}
		else{
			$numSiteMap = 'Oшибка';
		}

		

		//Определяем размер файла		
		$file_size = filesize($file);
		if($file_size < 32000 && $file_exists =='Ok' ){
			$file_size = "Оk";
		}
		else{
			$file_size = "Ошибка";
		}

		//Определяем код ответа
		$headers = get_headers($url);
		$response = $headers[0];
		$response = preg_match('/200/',$response);
		if($response){
			$response = "Ok";
		}else{
			$response = "Oшибка";
		}
		
	?>
	<table>
		<tr>
			<td>Номер</td>
			<td>Название проверки</td>
			<td>Статус</td>
		</tr>
		<tr>
			<td>1</td>
			<td>Проверка наличия файла</td>
			<td><?php echo $file_exists; ?></td>
		</tr>
		<tr>
			<td>2</td>
			<td>Проверка указания директивы Host</td>
			<td><?php echo $host; ?></td>
		</tr>
		<tr>
			<td>3</td>
			<td>Проверка количества директив Host, прописанных в файле</td>
			<td><?php echo $numHost; ?></td>
		</tr>
		<tr>
			<td>4</td>
			<td>Проверка размера файла</td>
			<td><?php echo $file_size; ?></td>
		</tr>
		<tr>
			<td>5</td>
			<td>Проверка указания директивы Sitemap</td>
			<td><?php echo $numSiteMap; ?></td>
		</tr>
		<tr>
			<td>6</td>
			<td>Проверка кода ответа сервера для файла</td>
			<td><?php echo $response; ?></td>
		</tr>		
	</table>

</body>
</html>
