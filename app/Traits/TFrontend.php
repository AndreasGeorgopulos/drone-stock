<?php
	namespace App\Traits;
	
	use Illuminate\Support\Facades\Cookie;
	
	trait TFrontend {
		public function view ($tpl, array $data = []) {
			$this->gzip(['css', 'js']);
			
			// facebook meta data
			$data['meta_data']['og:type'] = 'website';
			$data['meta_data']['og:url'] = url()->current();
			$data['meta_data']['og:site_name'] = 'Drone-Stock.hu';
			if (!empty($data['meta_data']['title'])) $data['meta_data']['og:title'] = $data['meta_data']['title'];
			if (!empty($data['meta_data']['description'])) $data['meta_data']['og:description'] = $data['meta_data']['description'];
			if (!empty($data['meta_data']['social_image'])) $data['meta_data']['og:image'] = $data['meta_data']['social_image'];
			
			// twitter meta data
			$data['meta_data']['twitter:card'] = 'summary';
			//$data['meta_data']['twitter:site'] = config('agrotyre.social.twitter.site');
			if (!empty($data['meta_data']['title'])) $data['meta_data']['twitter:title'] = $data['meta_data']['title'];
			if (!empty($data['meta_data']['description'])) $data['meta_data']['twitter:description'] = $data['meta_data']['description'];
			if (!empty($data['meta_data']['social_image'])) $data['meta_data']['twitter:image'] = $data['meta_data']['social_image'];
			
			if (isset($data['meta_data']['social_image'])) unset($data['meta_data']['social_image']);
			
			$data['meta_data']['robots'] = 'index,follow';
			$data['meta_data']['author'] = 'Delta Triangle';
			$data['meta_data']['country'] = 'Hungary';
			
			switch (\App::getLocale()) {
				case 'hu':
					$data['meta_data']['content-language'] = 'hu, hun, hungarian';
					break;
				case 'en':
					$data['meta_data']['content-language'] = 'en, eng, english';
					break;
			}
			
			return view($tpl, $data);
		}
		
		protected function setLanguage ($lang) {
			if (in_array($lang, config('app.languages'))) {
				Cookie::queue(Cookie::make('locale', $lang, config('app.language_cookie_expires')));
				\App::setLocale($lang);
			}
		}
		
		
		// css, js file-ok összefűzése
		protected function gzip (array $types) {
			foreach ($types as $type) {
				// csak a megadott típusokat engedi
				if (!in_array($type, ['css', 'js'])) return;
				
				// file elérési útvonala lqconfig-ból
				$gzip_file = lqOption('frontend_gzip_' . $type . '_path');
				
				// ha nincs meg a file a megadott útvonalon,
				// akkor létrehozza a configban megadott listát összefűzve
				if (!file_exists($gzip_file)) {
					// összefűzött tartalom előállítása
					$content = '';
					foreach (explode(chr(13) . chr(10), lqOption('frontend_gzip_' . $type . '_files')) as $file) {
						$content .= file_get_contents($file) . chr(10);
					}
					
					// elérési útvonal könyvtár(ak) ellenőrzése, létrehozása
					$arr = explode('/', $gzip_file);
					unset($arr[count($arr) - 1]);
					if (count($arr)) {
						$dir = implode('/', $arr);
						if ($dir != '' && !is_dir($dir)) mkdir($dir, 0755, true);
					}
					
					$content .= lqOption('frontend_cookie_consent');
					$content .= lqOption('frontend_google_analytics');
					
					// összefűzött tartalom mentése
					$content = $this->contentCompress($content);
					file_put_contents($gzip_file, str_replace([chr(13), 'url(../fonts/'], ['', 'url(../plugins/bootstrap/fonts/'], $content));
				}
			}
		}
		
		private function contentCompress ($content) {
			return $content;
			
			// make it into one long line
			//$content = str_replace(['\r', '\n'], '', $content);
			// replace all multiple spaces by one space
			$content = preg_replace('!\s+!', ' ', $content);
			// replace some unneeded spaces, modify as needed
			$content = str_replace([' {', ' }', '{ ', '; '], ['{', '}', '{', ';'], $content);
			
			return $content;
		}
	}