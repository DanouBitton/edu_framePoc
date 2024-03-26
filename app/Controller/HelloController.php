<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\Service\DatabaseService;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HelloController implements ControllerInterface
{

	public function execute(Request $request): string|null
	{
        $getConnect = DatabaseService::getConnect();
        //PHP PDO Mysql
        $statement = $getConnect->query("SELECT * FROM user");


        $users =  $statement->fetchAll();


		return TwigCore::getEnvironment()->render('hello/hello.html.twig',
		    [
		        "titre"   => 'HelloController',
		        "request" => $request,
                "ville" => $request->get('ville'),
                "listeUSer" => $users

		    ]
		);
	}
}
