<?php

class UsersController extends ControllerBase
{

    public function indexAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$user = AuthHelper::getUser();
    	
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	$semantic->htmlMessage ( "messageInfo", "<b> Veuillez rentrer vos informations ");
    	$form = $semantic->htmlForm("formInsc");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$fields=$form->addFields();
    	$fields->addInput("name","Nom","text",$user->getName(),"Entrez votre nom")->addRule("empty");
    	$fields->addInput("firstname","Prenom","text",$user->getFirstname(),"Entrez votre prenom")->addRule("empty");
    	$form->addInput("email","Email","email",$user->getEmail(),"Entrez votre Email")->addRules(["empty","email"]);
    	
    	$form->addInput("login","Login","text",$user->getLogin(),"Entrez votre identifiant" )->addRule("empty");
    	$form->addButton("btSub1","Modifier")->asSubmit();
    	$form->submitOnClick("btSub1","$this->controller/update", "#content-container");
    	
    	$this->view->setVar("user", $user);
    	$this->jquery->compile($this->view);
    }
    
    public function updateAction(){
    	$user = AuthHelper::getUser();
    	$user->save($_POST);
    }

}

