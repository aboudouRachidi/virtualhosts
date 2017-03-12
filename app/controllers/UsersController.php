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
    	$fromAction = $this->url->get("$this->controller/updateSubmit");
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$fields=$form->addFields();
    	$fields->addInput("name","Nom","text",$user->getName(),"Entrez votre nom")->addRule("empty");
    	$fields->addInput("firstname","Prenom","text",$user->getFirstname(),"Entrez votre prenom")->addRule("empty");
    	$form->addInput("email","Email","email",$user->getEmail(),"Entrez votre Email")->addRules(["empty","email"]);
    	
    	$form->addInput("login","Login","text",$user->getLogin(),"Entrez votre identifiant" )->addRule("empty");
    	$form->addButton("btSub1","Modifier")->asSubmit();
    	$form->submitOnClick("btSub1","$this->controller/updateSubmit", "#content-container");
    	
    	$this->view->setVar("user", $user);
    	$this->jquery->compile($this->view);
    }
    
    public function updateSubmitAction(){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	
    	$user = AuthHelper::getUser();
    	
    	$user->save($_POST);
    	
    	$msg=$semantic->htmlMessage("msg","Vos informations ont été mis à jour avec succès !");
    	$msg->addHeader("Bonne nouvelle !");
    	$msg->setIcon("hand peace");
    	$msg->addClass("success");
    	$msg->setDismissable();
    	
    	$this->dispatcher->forward(["controller"=>"Index","action" => "index","params" => [$msg]]);
    }
    
    public function updatePasswordAction(){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$user = AuthHelper::getUser();
    	 
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	
    	$form = $semantic->htmlForm("formInsc");
    	$fromAction = $this->url->get("$this->controller/updatePasswordSubmit");
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	//$fields=$form->addFields();
    	$form->addInput("password","Mot de passe","password","","Veuillez entrer un mot de passe")->addRules(["empty","minLength[8]"]);
    	$form->addInput("checkpassword","Confirmation mot de passe","password","","Veuillez confirmer votre mot de passe")->addRules(["empty","minLength[8]","match[password]"]);
    	$form->addButton("btSub1","Modifier")->asSubmit();
    	$form->submitOnClick("btSub1", $this->controller."/updatePasswordSubmit", "#content-container");
    	 
    	$this->view->setVar("user", $user);
    	$this->jquery->compile($this->view);
    }
    
    public function updatePasswordSubmitAction(){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	 
    	$user = AuthHelper::getUser();
    	if(!empty($this->request->getPost("password")) || !empty($this->request->getPost("checkpassword"))){
    		if($this->request->getPost("password") == $this->request->getPost("checkpassword")){
				$user->save($_POST);

				$msg=$semantic->htmlMessage("msg","Votre mot de passse a été mis à jour avec succès !");
				$msg->addHeader("Bonne nouvelle !");
				$msg->setIcon("hand peace");
				$msg->addClass("success");
				$msg->setDismissable();
			}else{
				$msg=$semantic->htmlMessage("msg","Mot de passe non identiques !");
				$msg->addHeader("Attention !");
				$msg->setIcon("warning circle");
				$msg->addClass("error");
				$msg->setDismissable();
			}
    	}else{
			$msg=$semantic->htmlMessage("msg","Veuillez saisir un mot de passe !");
			$msg->addHeader("Attention !");
			$msg->setIcon("warning circle");
			$msg->addClass("error");
			$msg->setDismissable();
		}

    	 
    	$this->dispatcher->forward(["controller"=>"Index","action" => "index","params" => [$msg]]);
    }

}

