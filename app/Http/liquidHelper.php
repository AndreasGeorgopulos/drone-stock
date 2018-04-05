<?php
	if (! function_exists('trans')) {
		/**
		 * Translate the given message.
		 *
		 * @param  string  $key
		 * @param  array   $replace
		 * @param  string  $locale
		 * @return \Illuminate\Contracts\Translation\Translator|string|array|null
		 */
		function trans($id = null, $replace = [], $locale = null)
		{
			if (is_null($id)) {
				return app('translator');
			}
			
			$translated = app('translator')->trans($id, $replace, $locale);
			
			if (strpos($translated, 'admin.') === 0) {
				$translated = explode("admin.",$translated)[1];
			}
			else if (strpos($translated, 'frontend.') === 0) {
				$translated = explode("frontend.",$translated)[1];
			}
			else if (strpos($translated, 'validation.') === 0) {
				$translated = explode("validation.",$translated)[1];
			}
			
			return $translated;
		}
	}
	
	if (! function_exists('fileFormatedSize')) {
		function fileFormatedSize ($bytes) {
			if ($bytes / 1024000000 > 1) {
				return number_format(round($bytes / 1024000000, 2), 2) . ' GB';
			}
			else if ($bytes / 1024000 > 1) {
				return number_format(round($bytes / 1024000, 2), 2) . ' MB';
			}
			else if ($bytes / 1024 > 1) {
				return number_format(round($bytes / 1024), 2) . ' kB';
			}
			else {
				return $bytes . ' b';
			}
		}
	}