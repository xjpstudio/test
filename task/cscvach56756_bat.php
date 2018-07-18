<?php
error_reporting(0);
set_time_limit(0);
$t_file = 'cloopsdeg35.txt';
if($t = read_file($t_file))
{
	if(time() - $t >= 1800)
	{
		delete_files('../cache',true);
		write_file($t_file, time());
	}
} else write_file($t_file, time());
function delete_files($path, $del_dir = FALSE, $level = 0)
{	
	// Trim the trailing slash
	$path = rtrim($path, DIRECTORY_SEPARATOR);
	if ( ! $current_dir = @opendir($path)) return;
	while(FALSE !== ($filename = @readdir($current_dir)))
	{
		if ($filename != "." and $filename != "..")
		{
			if (is_dir($path.DIRECTORY_SEPARATOR.$filename))
			{
				// Ignore empty folders
				if (substr($filename, 0, 1) != '.')
				{
					delete_files($path.DIRECTORY_SEPARATOR.$filename, $del_dir, $level + 1);
				}				
			}
			else
			{
				$cache = read_file($path.DIRECTORY_SEPARATOR.$filename);
				if (preg_match("/(\d+TS--->)/", $cache, $match))
				{
					if (time() >= trim(str_replace('TS--->', '', $match['1'])))
					{ 		
						@unlink($path.DIRECTORY_SEPARATOR.$filename);
					}
				}
			}
		}
	}
	@closedir($current_dir);
	if ($del_dir == TRUE AND $level > 0)
	{
		@rmdir($path);
	}
}
function write_file($path, $data, $mode = 'wb')
{
	if ( ! $fp = @fopen($path, $mode))
	{
		return FALSE;
	}
	flock($fp, LOCK_EX);
	fwrite($fp, $data);
	flock($fp, LOCK_UN);
	fclose($fp);	
	return TRUE;
}
function read_file($file)
{
	if ( ! file_exists($file))
	{
		return FALSE;
	}
	if (function_exists('file_get_contents'))
	{
		return file_get_contents($file);		
	}
	if ( ! $fp = @fopen($file, 'rb'))
	{
		return FALSE;
	}
	flock($fp, LOCK_SH);
	$data = '';
	if ($fsize = filesize($file) > 0)
	{
		$data =& fread($fp, $fsize);
	}
	flock($fp, LOCK_UN);
	fclose($fp);
	return $data;
}
?>
