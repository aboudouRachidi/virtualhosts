<?php

class MastersController extends ControllerBase
{

    public function indexAction()
    {

    }
    
    public function vUpdateUserAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	$user = User::findFirst($id);
    	 
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	$semantic->htmlMessage ( "messageInfo", "<b> Veuillez rentrer vos informations ");
    	$form = $semantic->htmlForm("formInsc");
    	$fromAction = $this->url->get("$this->controller/updateUserSubmit/".$user->getId());
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$fields=$form->addFields();
    	$fields->addInput("name","Nom","text",$user->getName(),"Entrez votre nom")->addRule("empty");
    	$fields->addInput("firstname","Prenom","text",$user->getFirstname(),"Entrez votre prenom")->addRule("empty");
    	$form->addInput("email","Email","email",$user->getEmail(),"Entrez votre Email")->addRules(["empty","email"]);
    	 
    	$form->addInput("login","Login","text",$user->getLogin(),"Entrez votre identifiant" )->addRule("empty");
    	$form->addButton("btSub1","Modifier")->asSubmit();
    	$form->submitOnClick("btSub1","$this->controller/updateSubmitUser", "#content-container");
    	 
    	$this->view->setVar("user", $user);
    	$this->jquery->compile($this->view);
    }
    
    public function updateUserSubmitAction($id){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	 
    	$user = User::findFirst($id);
    	 
    	$user->save($_POST);
    	 
    	$msg=$semantic->htmlMessage("msg","Les informations ont été mis à jour avec succès !");
    	$msg->addHeader("Bonne nouvelle !");
    	$msg->setIcon("hand peace");
    	$msg->addClass("success");
    	$msg->setDismissable();
    	 
    	$this->dispatcher->forward(["controller"=>"Index","action" => "index","params" => [$msg]]);
    }
    
    public function vDeleteUserAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	 
    	$user = User::findFirst($id);
    	 
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	 
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick($this->controller."/index","#index");
    
    	$form=$semantic->htmlForm("frmDelete");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$form->addErrorMessage();
    	 
    	$form->addHeader("Voulez-vous vraiment supprimer l'utilisateur : ". $user->getName()." ? ",3);
    	$form->addInput("id",NULL,"hidden",$user->getId());
    	$nom = $form->addInput("name","Nom *:","text",NULL,"Confirmer le nom du type de serveur")->addRule("empty");
    	$nom->getField()->labeledToCorner("asterisk","right");
    	 
    	$form->addButton("submit", "Supprimer","ui negative button")->asSubmit();
    	$form->submitOnClick("submit",$this->controller."/confirmDelete","#divAction");
    	 
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    	 
    
    	$this->view->setVars(["user"=>$user]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	$Stype = Stype::findFirst($_POST['id']);
    	 
    	if($Stype->getName() == $_POST['name']){
    		$Stype->delete();
    
    		$this->flash->message("success","Le type de serveur '".$_POST['name']."' a été supprimé avec succès");
    		$this->jquery->get($this->controller,"#refresh");
    
    	}else{
    
    		$this->flash->message("error","Le type de serveur '".$Stype->getName()."' n'a pas été supprimé : Le nom ne correspond pas ! ");
    		$this->jquery->get($this->controller,"#refresh");
    	}
    	 
    	echo $this->jquery->compile();
    }
}

