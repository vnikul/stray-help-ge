<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\File;

class UploaderService
{
	public function saveFile(File $file, $destination): string
	{
		$newFilename = Urlizer::urlize(
				pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
			).
			'-'.
			uniqid('', true).
			'.'.
			$file->guessExtension();
		$file->move($destination, $newFilename);
		return $newFilename;
	}
}