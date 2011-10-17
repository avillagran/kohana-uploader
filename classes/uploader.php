<?php defined('SYSPATH') or die('No direct script access.');

class Uploader {
	
	const directory = "media/uploads";
	
	static function form_open($action, $attributes = array() )
	{
		if( !is_array($attributes) )
			$attributes = array();
		
		$attributes['enctype'] = 'multipart/form-data';
			
		return Form::open($action, $attributes);
	}
	/***
	 * Check if $_FILE has $file_keyname
	 * 
	 * @return boolean
	 */
	static function exist_file($file_keyname)
	{
		if( isset($_FILES) && count($_FILES) > 0 && isset( $_FILES[ $file_keyname ] ) )
			return true;
			
		return false;
	}
	static function save_to_subfolder($file_keyname, $subfolder = '')
	{
		return self::save($file_keyname, self::get_date_string($subfolder));
	}
	static function save($file_keyname, $subdir = '', $save_as = NULL) {
		
		if( self::exist_file($file_keyname) )
		{
			$sd = self::directory . (strlen($subdir) > 0 ? '/' : '' ) . $subdir;
			@mkdir($sd, 0766, true);
			$path = Upload::save( $_FILES[ $file_keyname ], $save_as, $sd );
			
			return str_replace(DOCROOT, '/', $path);
		}
		return NULL;
	}
	static function get_date_string($subfolder = '')
	{
		return $subfolder . '/' . date('Y/m/d') . '/';
	}

}