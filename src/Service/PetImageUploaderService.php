<?php

namespace App\Service;

use App\Entity\Pet;
use App\Entity\PetImage;
use Symfony\Component\HttpFoundation\File\File;

class PetImageUploaderService
{
	private const PETS_IMAGES_DIRECTORY = '/pets';
	private string $destination;

	public function __construct(
		private readonly UploaderService $service,
		private readonly string $uploadsDir,
	)
	{
		$this->destination = $this->uploadsDir . self::PETS_IMAGES_DIRECTORY;
	}

	public function createForPet(File $file, Pet $pet): PetImage
	{
		$newFilename = $this->service->saveFile($file, $this->destination);
		return (new PetImage())->setPath($newFilename)->setPet($pet);
	}
}