<?php

class View
{
	public function add($view, $data = false)
	{
		$path = VIEW_DIR.SEP.$view.EXT;

		if (file_exists($path)) {

			ob_start();
			if($data) {
				extract($data);
			}

			require $path;
		}
	}

	public function render()
	{
		ob_end_flush();
	}
}