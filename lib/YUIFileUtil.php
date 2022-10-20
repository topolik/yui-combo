<?php
class YUIFileUtil {
	public static function getFileExtension($filename) {
		eregi("\.([^.]+)*$", basename($filename), $m);

		return strtolower($m[1]);
	}

	public static function isSubDir($path = NULL, $parent_folder) {
	    // If the configuration is wrong then we cannot serve any file
	    if (!is_dir($parent_folder)) {
	        error_log("Fatal: Incorrect configuration of YUI_BUILD_PATH, dir doesn't exist: ".$parent_folder);
	        return FALSE;
	    }

	    // No loading of php scripts from the app directory
	    if (strpos(COMBO_FILE_PATH, realpath(dirname($path))) > -1) {
	        return FALSE;
	    }

	    //Get directory path minus last folder
	    $dir = dirname($path);
	    $folder = substr($path, strlen($dir));

	    //Check the the base dir is valid
	    $dir = realpath($dir);

	    //Only allow valid filename characters
	    $folder = preg_replace('/[^a-z0-9\.\-_]/i', '', $folder);

	    //If this is a bad path or a bad end folder name
	    if( !$dir OR !$folder OR $folder === '.') {
	        return FALSE;
	    }

	    //Rebuild path
	    $path = $dir.DS.$folder;

	    //If this path contains parent folder
	    if(strpos(realpath($path), realpath($parent_folder)) === 0) {
	        return TRUE;
	    }

	    return FALSE;
	}

	function writeCache($id, $content) {
		if (!is_dir(TEMP_DIR)) {
			mkdir(TEMP_DIR, 0777);
		}

		file_put_contents(TEMP_DIR.DS.$id, $content);
	}

	function getCache($id) {
		$file = TEMP_DIR.DS.$id;

		if (is_file($file)) {
			return file_get_contents(TEMP_DIR.DS.$id);
		}

		return false;
	}
}
?>