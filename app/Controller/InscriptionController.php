<?php

namespace Controller;

use PDO;
use PDOException;
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
        
        $dbConnect = DatabaseService::getConnect();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer'])) {
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "veliko";

            try {
                session_start();
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $email = htmlspecialchars($_POST['email']);
                $mdp = sha1($_POST['mdp']);
                $nom = htmlspecialchars($_POST['nom']);
                $prenom = htmlspecialchars($_POST['prenom']);


                $stmt = $conn->prepare('INSERT INTO user(email, motDePasse, nom, prenom) VALUES(?, ?, ?, ?)');
                $stmt->execute([$email, $mdp, $nom, $prenom]);

                $recupUser = $conn->prepare('SELECT * FROM user WHERE email = ? AND motDePasse = ?');
                $recupUser->execute([$email, $mdp]);
                if ($recupUser->rowCount() > 0) {
                    $_SESSION['email'] = $email;
                    $_SESSION['mdp'] = $mdp;
                    $_SESSION['id'] = $recupUser->fetch()['id'];
                }
            } catch (PDOException $e) {
                echo "La connexion a échoué: " . $e->getMessage();
            }
        }

        return TwigCore::getEnvironment()->render('inscription/inscription.html.twig', [
            "titre" => 'InscriptionController',
            "request" => $request,
        ]);
    }
}
