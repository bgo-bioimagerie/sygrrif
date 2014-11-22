<?php

require_once 'Framework/Controller.php';
require_once 'Modules/core/Model/User.php';

/**
 * Controler managing the user connection 
 * 
 * @author Sylvain Prigent
 */
class ControllerConnection extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $this->generateView();
    }

    public function connect()
    {
        if ($this->request->isparameter("login") && $this->request->isParameter("pwd")) {
            $login = $this->request->getParameter("login");
            $pwd = $this->request->getparameter("pwd");
            if ($this->user->connecter($login, $pwd)) {
                $user = $this->user->getUtilisateur($login, $pwd);
                $this->request->getSession()->setAttribut("idUser",
                        $user['idUtilisateur']);
                $this->request->getSession()->setAttribut("login",
                        $user['login']);
                $this->redirect("home");
            }
            else
                $this->generateView(array('msgError' => 'Login or password not correct'),
                        "index");
        }
        else
            throw new Exception("Action not allowed : login or passeword undefined");
    }

    public function disconnect()
    {
        $this->request->getSession()->destroy();
        $this->redirect("home");
    }

}
