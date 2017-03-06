<?php
use Ajax\semantic\html\base\constants\State;
use Ajax\semantic\components\validation\Rule;


class AccueilController extends ControllerBase
{

	
	public function initialize()
	{
	
		if ($this->session->has('auth') && $this->dispatcher->getActionName()!=="index") {
			//$this->jquery->get("Accueil/connect","#content-container");
			$this->dispatcher->forward(array("controller" => "Index", "action" => "index"));
		}
	}

	public function signUpAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		$semantic->htmlMessage ( "messageInfo", "<b> Veuillez rentrer vos informations ");
		$form = $semantic->htmlForm("formInsc");
		$form->setValidationParams(["on"=>"blur","inline"=>true]);
		$fields=$form->addFields();
		$fields->addInput("name","Nom","text","","Entrez votre nom")->addRule("empty");
		$fields->addInput("firstname","Prenom","text","","Entrez votre prenom")->addRule("empty");
		$form->addInput("email","Email","email","","Entrez votre Email")->addRules(["empty","email"]);
		$form->addInput("password","Mot de passe","password","","Veuillez entrer un mot de passe")->addRules(["empty","minLength[8]"]);
		$form->addInput("checkpassword","Confirmation mot de passe","password","","Veuillez confirmer votre mot de passe")->addRules(["empty","minLength[8]","match[password]"]);
		$form->addInput("login","Login","text","","Entrez votre identifiant" )->addRule("empty");
		$form->addButton("btSub1","S'inscrire")->asSubmit();
		$form->submitOnClick("btSub1", $this->controller."/register", "#content-container");
		
		$this->jquery->compile($this->view);
	}

	
	public function registerAction(){
		$user=new User();
		$user->setIdrole(2);
		$user->save($_POST);
		$this->flash->success("Bienvenue ".$user->getLogin());
	}
	
	public function signInAction($msg=NULL)
	{
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		$form=$semantic->htmlForm("frmLogin");
		$form->setProperty("method", "post");
		$form->setProperty("action", "login");
		$form->addErrorMessage();
		$form->addInput("email","Adresse email","email",$this->request->getPost("email"))->addRule("empty","Veuillez remplir le champ adresse...");
		$form->addInput("password","Mot de passe","password")->addRule("empty","Veuillez remplir le champ mot de passe ...");
		$icon=$semantic->htmlIcon("","checkmark");
		$form->addButton("btValider","Valider")->setColor("green")->asSubmit();
		//$form->submitOn("click","btValider",$this->controller."/login",");
		
		
		$this->view->setVar("msg", $msg);
		//echo $form;
		$this->jquery->compile($this->view);
		
	}
	
	public function loginAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		$semantic=$this->semantic;
		
		if($this->request->isPost()){
			$user = User::findFirst("email = '".@$_POST['email']."'");
			if($user != null){
				if (@$_POST['password'] == $user->getPassword()){
					$this->session->set("auth", $user);
					$this->flash->success("Bienvenue ".$user->getLogin());
					
					$this->dispatcher->forward(array("controller"=>"Index","action"=>"index"));

				}
				else{

					$msg=$semantic->htmlMessage("msg","Email ou mot de passe incorrect !");
					$msg->addHeader("Erreur !");
					$msg->setIcon("warning circle");
					$msg->addClass("error");
					$msg->setDismissable();

					$this->dispatcher->forward(["controller"=>$this->controller,"action" => "signIn","params" => [$msg]]);
				}
			}else{
				$msg=$semantic->htmlMessage("msg","Utilisateur non reconnu !");
				$msg->addHeader("Erreur !");
				$msg->setIcon("warning circle");
				$msg->addClass("error");
				$msg->setDismissable();
				$this->dispatcher->forward(["controller"=>$this->controller,"action" => "signIn","params" => [$msg]]);
			}
		}else{
			$this->response->redirect("$this->controller/signIn");
		}

		$this->jquery->compile($this->view);
	
	}
	
	public function asUserAction(){
		$user = User::findFirst("idrole = 2");
		$this->session->set("auth", $user);
		$this->dispatcher->forward(array("controller"=>"Index", "action"=>"index"));
	}
	
	public function asAdminAction(){
		$user = User::findFirst("idrole = 1");
		$this->session->set("auth", $user);
		$this->dispatcher->forward(array("controller"=>"Index", "action"=>"index"));
	}
	
	public function logoutAction(){
		// Destroy the whole session
		$this->session->destroy();
		$this->response->redirect("$this->controller/signIn");
	}
	
}