<?php

class Files_Controller extends Base_Controller {

	public $content_dir = './public/content/';

	public $exclude_dir = array('.','..');
	
	public function get_files() {
		$main_level = $this->content_scan();

		foreach ($main_level as $key => $dir) {
			$main_level[$key] = array('dir'=>$dir);
			$main_level[$key]['subdir'] = 
				$this->content_scan($this->content_dir . $dir);
		}
		
		return View::make('files.index')
			->with('title','Learning Resources')
			->with('main_level',$main_level);
	}

	public function get_update() {
		$this->update_videos();

		return View::make('files.updated')
			->with('title','Updated');
	}

	private function update_videos() {
		$tuts = $this->content_scan($this->content_dir . 'Videos/');

		foreach ($tuts as $tut) {
			$this->generate_index($this->content_dir . 'Videos/' . $tut . '/', $tut);
		}
	}

	private function generate_index($dir, $title) {
		if (file_exists($dir . 'index.html')) {
			return true;
		}

		$files = $this->content_scan($dir);
		$video_array = array();

		$videos = array_filter($files, 'mp4');

		foreach($videos as $video) {
		    $video = substr($video, 0, -4);

		    $video_array[] = array(
		        'title' => $video,
		        'm4v' => $video . '.mp4',
		        'ogv' => $video . '.ogv',
		        'poster' => '../../../img/bg.png'
		    );
		}

		$json = json_encode($video_array);

		$html = View::make('layouts.videos')
			->with('title',$title)
			->with('videos',$json);

		$fh = fopen($dir . 'index.html', 'w');
		fwrite($fh, $html);
		fclose($fh);

		return true;
	}

	private function content_scan($dir = null) {
		$dir = ($dir) ?: $this->content_dir;

		return array_values(
			array_diff(
				scandir($dir), $this->exclude_dir
			)
		);
	}
}

function mp4($var) {
	return(preg_match('/\.mp4$/', $var));
}