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
        $crud = "create";
        //1- récupere l'objet qui se connecte a la base de données -> PDO
        $dbConnect = DatabaseService::getConnect();
        //traitement de mon formulaire
//var_dump($request->get('nom'),$request->get('crud'));
        if ($request->get('nom') != null && $request->get('crud') == 'create')
        {
            $dbConnect->query("INSERT INTO ville (id, nom) VALUES (null,'".$request->get('nom')."')");

        }


        //traitement de supression
        if($request->get('id_ville')!=null && $request->get('crud') =='delete'){
            $statement = $dbConnect->query("Delete FROM ville WHERE ville.`id` =". $request->get('id_ville'));

        }

        if ($request->get('id_ville')!==null && $request->getHttpMethod() == "GET" && $request->get('crud') =='update')
        {
            $statement = $dbConnect->query("Select * From ville WHERE id = ".$request->get('id_ville'));
            if ($statement !=false)
            {
                $ville = $statement->fetch();
            }
            $crud = "update";
        }


        if ($request->get('id_ville') !== null  && $request->getHttpMethod() == "POST" && $request->get('crud') =='update') {

            $statement = $dbConnect->query("UPDATE `ville` SET ville.`nom` = '" . $request->get('nom') . "' WHERE ville.`id` = " . $request->get('id_ville'));
        }

        //Récupération des users
        $villes = false;




        //2- Creation de la requete SQL -> PDOStatement
        //Phase de préparation de la validation SQL
        $statement = $dbConnect->query("SELECT * FROM ville");

        //3- Resultat de la requete SQL -> array
        if ($statement !=false)
        {
            $villes = $statement->fetchAll();
        }


        return TwigCore::getEnvironment()->render('hello/hello.html.twig',
            [
                "titre"   => 'HelloController',
                "request" => $request,
                "listVilles" =>$villes,
                "crud" => $crud,
                "ville" =>$ville

            ]
        );
    }
}
