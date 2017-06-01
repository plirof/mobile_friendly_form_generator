<?php

// Attempt to create and display a list of filenames beginning with "draft."
// 2 databases are configured in the online demo.

$db0 = 'test';  // Set this one for sure
$db1 = ''; // Empty if not using a 2nd database
$db2 = ''; // Empty if not using a 3rd database

$batch[$db0] = array();
$batch[$db1] = array();
$batch[$db2] = array();

$filename_prefix_to_look_for = 'draft.';

$file_count = 0;

if($iterator = new DirectoryIterator('.')){
	foreach($iterator as $fileinfo) {
		if($fileinfo->isDir()) {
			// nothing
		}elseif($fileinfo->isFile()){
			if(substr($fileinfo->getFilename(), 0, 6) == $filename_prefix_to_look_for){
				// echo $fileinfo->getFilename().'<br>';
				$parts = explode('.', $fileinfo->getFilename());
				if(isset($parts[4]) && $parts[4] == 'php'){
					switch($parts[1])
					{
						Case $db0:
							$batch[$db0][] = $fileinfo->getFilename();
							$file_count++;
							break;
						Case $db1:
							$batch[$db1][] = $fileinfo->getFilename();
							$file_count++;
							break;
						Case $db2:
							$batch[$db2][] = $fileinfo->getFilename();
							$file_count++;
							break;
						default:
							break;
					}
				}
			}
		}
	}
}
if(empty($file_count)){
	echo "\n".'<div class="alert alert-info" role="alert"> <p>No scripts have been created for database `'.$db0.'`. </p><p>Select a database connection and create a script.</p> </div> ';
}else{

	if(!empty($batch[$db0])){
		sort($batch[$db0]);
		echo '<h3 class="card-title">Scripts created by other users for database `'.$db0.'`</h3>'."\n";
		foreach($batch[$db0] as $fn){
			echo '<p class="card-title"><a href="'.$fn.'">'.$fn.'</a></p>'."\n";
		}
	}
	if(!empty($batch[$db1])){
		sort($batch[$db1]);
		echo '<h3 class="card-title">Scripts created by other users for database `'.$db1.'`</h3>'."\n";
		foreach($batch[$db1] as $fn){
			echo '<p class="card-title"><a href="'.$fn.'">'.$fn.'</a></p>'."\n";
		}
	}
	if(!empty($batch[$db2])){
		sort($batch[$db2]);
		echo '<h3 class="card-title">Scripts created by other users for database `'.$db2.'`</h3>'."\n";
		foreach($batch[$db2] as $fn){
			echo '<p class="card-title"><a href="'.$fn.'">'.$fn.'</a></p>'."\n";
		}
	}

	echo '<p>Tab example: <a href="app-tab-example.php">app-tab-example.php</a> requires the schema from <a href="sql/a_test_table.txt" target="_blank">a_test_table.txt</a></p>'."\n";

}

?>
