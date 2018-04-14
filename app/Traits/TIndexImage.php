<?php
	namespace App\Traits;
	
	use Illuminate\Support\Facades\File;
	
	trait TIndexImage {
		
		public function saveIndexImage ($indexImage, $model, $originalPath, $path, $image_sizes, $aspectRatio = 0) {
			// delete previos file
			// move new original file
			$originalPath = public_path($originalPath);
			$path = public_path($path);
			
			$new_filename = $model->id . '_' . $indexImage->getClientOriginalName();
			if ($model->index_image != NULL && File::exists($originalPath . '/' . $model->index_image)) {
				File::delete($originalPath . '/' . $model->index_image);
			}
			$indexImage->move($originalPath, $new_filename);
			
			// create resized image from original
			// delete previous resized file
			$this->resizeIndexImage($model, $originalPath, $path, $image_sizes, $new_filename, $aspectRatio);
			
			return $new_filename;
		}
		
		public function resizeIndexImage ($model, $originalPath, $path, $image_sizes, $filename, $aspectRatio = 0) {
			foreach ($image_sizes as $size) {
				$size = explode('*', $size);
				$targetPath = $path . '/' . implode('_', $size);
				
				if (!File::isDirectory($targetPath)) {
					File::makeDirectory($targetPath, 755, true);
				}
				else if ($model->index_image != NULL && File::exists($targetPath . '/' . $model->index_image)) {
					File::delete($targetPath . '/' . $model->index_image);
				}
				
				$func = function ($constraint) use ($aspectRatio) {
					if ($aspectRatio) $constraint->aspectRatio();
				};
				
				\Image::make($originalPath . '/' . $filename)->resize($size[0], $size[1], $func)->save($targetPath . '/' . $filename);
			}
		}
		
		public function deleteIndexImage (&$model, $originalPath, $path, $image_sizes) {
			$originalPath = public_path($originalPath);
			$path = public_path($path);
			
			// delete original file
			if ($model->index_image != NULL && File::exists($originalPath . '/' . $model->index_image)) {
				File::delete($originalPath . '/' . $model->index_image);
			}
			
			// delete resized files
			foreach ($image_sizes as $size) {
				$size = explode('*', $size);
				$targetPath = $path . '/' . implode('_', $size);
				
				if ($model->index_image != NULL && File::exists($targetPath . '/' . $model->index_image)) {
					File::delete($targetPath . '/' . $model->index_image);
				}
			}
		}
		
		public function getIndexImages ($filename, $originalPath, $sizesPath, $image_sizes) {
			$images = [];
			
			if (File::exists($originalPath . '/' . $filename)) {
				$images['original'] = [
					'filename' => $filename,
					'size' => 'original',
					'path' => $originalPath . '/' . $filename,
					'url' => url($originalPath . '/' . $filename),
				];
			}
			
			foreach ($image_sizes as $size) {
				$size = explode('*', $size);
				$path = $sizesPath . '/' . implode('_', $size) . '/' . $filename;
				if (File::exists($path)) {
					$images[implode('_', $size)] = [
						'filename' => $filename,
						'size' => implode('*', $size),
						'path' => public_path($path),
						'url' => url($path)
					];
				}
			}
			
			return $images;
		}
	}