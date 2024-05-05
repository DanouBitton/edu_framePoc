<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\Service\DatabaseService;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class InscriptionController implements ControllerInterface
{

	public function execute(Request $request): string|null
	{


		return TwigCore::getEnvironment()->render('inscription/inscription.html.twig',
		    [
		        "titre"   => 'InscriptionController',
		        "request" => $request,



		    ]
		);
	}
}
