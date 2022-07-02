<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

	public function __construct(private UserService $service)
	{
	}

}