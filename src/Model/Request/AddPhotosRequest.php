<?php

declare(strict_types=1);

namespace App\Model\Request;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class AddPhotosRequest
{
	#[Assert\All([
		new Assert\Image(
			minWidth: 20,
			maxWidth: 4000,
			maxHeight: 8000,
			minHeight: 10,
		),
	])]
	#[Assert\Count(
		min: 1,
		max: 10,
		minMessage: 'You must send at least one file',
		maxMessage: 'You\'ve sent too many files. Please upload no more than 10 files at once',
	)]
	private array $photos;

	/**
	 * @return array
	 */
	public function getPhotos(): array
	{
		return $this->photos;
	}

	/**
	 * @param  array  $photo
	 *
	 * @return AddPhotosRequest
	 */
	public function setPhotos(array $photo): AddPhotosRequest
	{
		$this->photos = $photo;
		return $this;
	}
}