<?php
	class UploadController extends Controller
	{
		public function index()
		{
			//determine destindation
			if(Input::file('logo'))
			{
				$file = Input::file('logo');
				$destinationFolder = $this->uploadFolder('logo');
			}

			//hash filename
			$filename = md5($file->getClientOriginalName());
			//file extension
			$ext = $file->getClientOriginalExtension();
			//move file to destination folder
			$upload = $file->move($destinationFolder, $filename.'.'.$ext);

			if($upload)
			{
				$filedata = array(
					"name"=>$filename.".".$ext,
					"path"=>Config::get('app.url')."/".$destinationFolder."/".$filename.".".$ext
				);

				return Response::json(array("status"=>"success","file"=>$filedata));
			}
			else
			{
				return Response::json(array("status"=>"error"));
			}
		}

		private function uploadFolder($fileIndex)
		{
			switch ($fileIndex) {
				case 'logo':
					$folder = "data/logos";
					break;
			}

			return $folder;
		}
	}