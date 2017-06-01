<?php

// For the form generator itself, not for the phpMyEdit scripts.

function my_configured_databases($step)
{
	global $cfg;
	$ret = "\n".'';
	$ret .= "\n".'<div class="card card-block"><h3 class="card-title">Select a database connection:</h3>';
	for($i = 0; $i < $cfg['server_count']; $i++){
		$ret .= "\n".'<p class="card-text"><a href="'.basename($_SERVER['PHP_SELF']).'?step='.$step.'&amp;sn='.$i.'" class="btn btn-sm btn-primary">`'.$cfg['server'][$i]['db'].'`</a></p>';
	}
	$ret .= "\n".'</div>';
	return $ret;
};

function my_table_list($step, $sn)
{
	global $cfg, $display_comments;
	$ret = '';
	$test_ary = array();
	$qry = 'SELECT TABLE_NAME, ENGINE, TABLE_ROWS, AVG_ROW_LENGTH, TABLE_COLLATION, INDEX_LENGTH, TABLE_COMMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "%s"';
	$qry = sprintf($qry, $cfg['server'][$sn]['db']);
	if($display_comments){
		$ret .=  sprintf('<p class="text-muted">Collecting information: '. nl2br(htmlentities($qry)).'');
	}
	if(!$res = mysqli_query($cfg['server'][$sn]['link'], $qry)){
		$ret .=  sprintf('<p class="text-danger">mysqli_error: %s</p>', mysqli_error($cfg['server'][$sn]['link']));
	}else{
		$num_rows = mysqli_num_rows($res);
		if(empty($num_rows)){
			$ret .=  sprintf('<p class="text-warning">No rows returned. Make certain that tables exist in `'.$cfg['server'][$sn]['db'].'`.</p><blockquote>'. htmlentities($qry).'</blockquote>');
		}else{
			$ret .= "\n".'<table class="table table-bordered table-striped">';
			$ret .= "\n".'<tr>';
			$ret .= "\n".'<td>TABLE</td>';
			$ret .= "\n".'<td>TOGGLE</td>';
			$ret .= "\n".'<td>ENGINE</td>';
			$ret .= "\n".'<td class="text-right">ROWS</td>';
			$ret .= "\n".'<td class="text-right">AVG_ROW</td>';
			$ret .= "\n".'<td class="text-right">COLLATION</td>';
			$ret .= "\n".'<td class="text-right">INDEX LENGTH</td>';
			$ret .= "\n".'<td>TABLE COMMENT</td>';
			$ret .= "\n".'</tr>';
			while($row = mysqli_fetch_row($res)){
				$test_ary[] = $row[0];
				if($row[6] != 'VIEW' && $row[1] != 'MyISAM'){
					// unsupported Engine
					$ret .= "\n".'<tr>';
				}elseif($row[1] == ''){
					$row[1] = '&mdash;';
					$ret .= "\n".'<tr>';
				}else{
					$ret .= "\n".'<tr>';
				}
				// Parameter to let the form generator know if we have a VIEW or not
				$view = ($row[1] == 'MyISAM') ? 0 : 1;
				$ret .= "\n".'<td>'.$row[0].'</td>';
				$ret .= "\n".'<td style="white-space:nowrap;">';
				//$ret .= "\n".'<a href="'.basename($_SERVER['PHP_SELF']).'?step='.$step.'&amp;sn='.$sn.'&amp;tb='.$row[0].'&amp;o1=0&amp;view='.$view.'" class="pme-header" title="Omit toggle links">No</a>';
				//$ret .= "\n".' &mdash; ';
				//$ret .= "\n".'<a href="'.basename($_SERVER['PHP_SELF']).'?step='.$step.'&amp;sn='.$sn.'&amp;tb='.$row[0].'&amp;o1=1&amp;view='.$view.'" class="pme-header" title="Include toggle links">Yes</a>';

				//$ret .= "\n".'<div class="btn-group" role="group" aria-label="Toggle">';
				$ret .= "\n".'<a href="'.basename($_SERVER['PHP_SELF']).'?step='.$step.'&amp;sn='.$sn.'&amp;tb='.$row[0].'&amp;o1=1&amp;view='.$view.'" class="btn btn-sm btn-secondary" title="Include toggle links">Yes</a>';
				$ret .= "\n".'<a href="'.basename($_SERVER['PHP_SELF']).'?step='.$step.'&amp;sn='.$sn.'&amp;tb='.$row[0].'&amp;o1=0&amp;view='.$view.'" class="btn btn-sm btn-secondary" title="Omit toggle links">No</a>';
				//$ret .= "\n".'</div>';

				$ret .= "\n".'</td>';
				$ret .= "\n".'<td>'.$row[1].'</td>';
				$ret .= "\n".'<td class="text-right">'.number_format($row[2]).'</td>';
				$ret .= "\n".'<td class="text-right">'.number_format($row[3]).'</td>';
				$ret .= "\n".'<td class="text-right">'.$row[4].'</td>';
				$ret .= "\n".'<td class="text-right">'.number_format($row[5]).'</td>';
				$ret .= "\n".'<td>'.htmlentities($row[6]).'</td>';
				$ret .= "\n".'</tr>';
			}
			mysqli_free_result($res);
			$ret .= "\n".'</table>'."\n";
			if(!in_array($cfg['server'][$sn]['log'], $test_ary)){
				$ret .=  '<p class="text-warning">Installation of the provided `change_log` schema is required.</p><pre class="pre-scrollable">CREATE TABLE IF NOT EXISTS `change_log` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(50) NOT NULL DEFAULT \'\',
  `host` varchar(255) NOT NULL DEFAULT \'\',
  `operation` varchar(50) NOT NULL DEFAULT \'\',
  `tab` varchar(50) NOT NULL DEFAULT \'\',
  `rowkey` varchar(255) NOT NULL DEFAULT \'\',
  `col` varchar(255) NOT NULL DEFAULT \'\',
  `oldval` mediumtext,
  `newval` mediumtext,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`),
  KEY `idx_tab` (`tab`),
  KEY `idx_col` (`col`),
  KEY `idx_operation` (`operation`),
  KEY `idx_rowkey` (`rowkey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT=\'See the change_log features of phpMyEdit\';</pre>';

			} // end if()
		}
	}
	return $ret;
};

function abort($data)
{
	// die() pretty
	// Terminate the current operation using valid HTML.
	// Data passed in may or may not contain HTML markup.
	global $cfg, $opts, $sn;
	if(empty($data)){
		echo "\n".'<p>Processing terminated for unknown reasons.</p>';
	}elseif(!empty($data)){
		$tag = PHP_EOL.'<li>%s</li>';
		echo "\n".'<div class="alert alert-danger" role="alert"><ul>';
		if(is_array($data)){
			foreach($data as $val){
				if(empty($val)){
					continue;
				}
				if(is_array($val)){
					$val = implode(', ', $val);
				}
				$tmp = strip_tags($val);
				if($val == $tmp){
					printf($tag, htmlentities($val));
				}else{
					printf($tag, $val);
				}
			}
		}else{
			$tmp = strip_tags($data);
			if($data == $tmp){
				printf($tag, htmlentities($data));
			}else{
				printf($tag, $data);
			}
		}
		echo "\n".'</ul>';
		echo "\n".'</div>';
	}
	echo "\n".'</div><!-- /col -->';
	echo "\n".'</div><!-- /fow -->';
	echo "\n".'</div><!-- /container -->';
	require_once('inc/footer.php');	
	exit;
	exit;
};

function get_cgi_var($name, $default_value = null)
{
	// Best function ever.
	static $magic_quotes_gpc = null;
	if($magic_quotes_gpc === null){
		$magic_quotes_gpc = get_magic_quotes_gpc();
	}
	$var = @$_GET[$name];
	if(!isset($var)){
		$var = @$_POST[$name];
	}
	if(isset($var)){
		if($magic_quotes_gpc){
			if(is_array($var)){
				foreach (array_keys($var) as $key){
					$var[$key] = trim(stripslashes(strip_tags($var[$key])));
				}
			}else{
				$var = trim(stripslashes(strip_tags($var)));
			}
		}else{
			if(is_array($var)){
				foreach (array_keys($var) as $key){
					$var[$key] = trim(strip_tags($var[$key]));
				}
			}else{
				$var = trim(strip_tags($var));
			}
		}
	}else{
		$var = @$default_value;
	}
	return $var;
};

function connect_using_mysqli($sn)
{
	global $cfg;
	// The database connection configured in pme.config.php is much simpler.
	// Multiple servers and multiple database possible using $sn (ala phpMyAdmin)
	if(!function_exists('mysqli_init')){
		// possibly make a backwards-compatible non-mysqli connection
		abort('mysqli_init() is required but cannot be located [$sn = '.$sn.']');
	}else{
		$cfg['server'][$sn]['link'] = mysqli_init();
		$cfg['server'][$sn]['mysqli_connect_errno'] = mysqli_connect_errno();
		if(!empty($cfg['server'][$sn]['mysqli_connect_errno'])){
			abort('Connect failed [$sn = '.$sn.']: '.mysqli_connect_error());
		}
		if(!mysqli_options($cfg['server'][$sn]['link'], MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')){
			$cfg['server'][$sn]['mysqli_connect_errno'] = mysqli_connect_errno();
			abort('Setting MYSQLI_INIT_COMMAND failed [$sn = '.$sn.']');
		}
		if(!empty($cfg['server'][$sn]['timeout'])){
			if(!mysqli_options($cfg['server'][$sn]['link'], MYSQLI_OPT_CONNECT_TIMEOUT, $cfg['server'][$sn]['timeout'])){
				$cfg['server'][$sn]['mysqli_connect_errno'] = mysqli_connect_errno();
				abort('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed [$sn = '.$sn.']');
			}
		}
		if(!@mysqli_real_connect($cfg['server'][$sn]['link'], $cfg['server'][$sn]['hn'], $cfg['server'][$sn]['un'], $cfg['server'][$sn]['pw'], $cfg['server'][$sn]['db'])){
			$cfg['server'][$sn]['mysqli_connect_errno'] = mysqli_connect_errno();
			if($cfg['server'][$sn]['mysqli_connect_errno'] == 2002){
				abort('[Error '. mysqli_connect_errno() .'] The connection to the database server timed out after '.$cfg['server'][$sn]['timeout'].' seconds. [sn '.$sn.']');
			}else{
				abort('[Error '. mysqli_connect_errno() .'] ' . mysqli_connect_error().' [$sn = '.$sn.']');
			}
		}else{
			if($link_charset = mysqli_character_set_name($cfg['server'][$sn]['link'])){
				if($link_charset != $cfg['server'][$sn]['charset']){
					if(!mysqli_set_charset($cfg['server'][$sn]['link'], $cfg['server'][$sn]['charset'])){
						abort('Error loading character set: '.mysqli_error($cfg['server'][$sn]['link'].' [$sn = '.$sn.']'));
					}
				}
			}else{
				abort('The character set for this link cannot be determined '.mysqli_error($cfg['server'][$sn]['link'].' [$sn = '.$sn.']'));
			}
		}
		return $cfg['server'][$sn]['link'];
	}
	return false;
};

function echo_buffer($str)
{
	global $output_buffer;
	$output_buffer .= $str.PHP_EOL;
};

function my_list($label, $ary)
{
	if(empty($ary)){
		return null;
	}else{
		sort($ary);
		return "\n".'<p class="text-muted">'.$label.':</p> <ul><li class="text-muted">'.implode('</li><li class="text-muted">', $ary).'</li></ul>';
	}
};



?>