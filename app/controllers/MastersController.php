<?php

use Ajax\semantic\components\search\SearchCategories;
use Ajax\semantic\components\search\SearchResult;

class MastersController extends ControllerBase
{

    public function indexAction()
    {

    }
    
    
    public function vAddUserAction()
    {
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	$form = $semantic->htmlForm("formInsc");
    	
    	$fromAction = $this->url->get("$this->controller/addUserSubmit");
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    	
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$fields=$form->addFields();
    	$fields->addInput("name","Nom","text",$this->request->getPost("name"),"Entrez le nom")->addRule("empty");
    	$fields->addInput("firstname","Prenom","text",$this->request->getPost("firstname"),"Entrez le prenom")->addRule("empty");
    	$form->addInput("email","Email","email",$this->request->getPost("email"),"Entrez l'Email")->addRules(["empty","email"]);
    	$form->addInput("password","Mot de passe","password","","Veuillez entrer un mot de passe")->addRules(["empty","minLength[8]"]);
    	$form->addInput("checkpassword","Confirmation mot de passe","password","","Veuillez confirmer le mot de passe")->addRules(["empty","minLength[8]","match[password]"]);
    	$form->addInput("login","Login","text","","Entrez un identifiant" )->addRule("empty");
    	$form->addDropdown("roles",AppHelper::getAllRoles(),"Roles ","Selectionner un role...",false);
    	
    	$form->addButton("btSub1","Ajouter")->asSubmit();
    	//$form->submitOnClick("btSub1", $this->controller."/addUserSubmit", "#content-container");
    	
    	$this->jquery->compile($this->view);
    
    }
    
    public function addUserSubmitAction(){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	
    	$user=new User();
    	
    	if($this->request->getPost("roles") != null && $this->request->getPost("roles") != "Selectionner un role..."){
    		
    		$user->setIdrole($this->request->getPost("roles")+1);
    		
    	}else {
    		$user->setIdrole(2);
    	}
    	
    	$user->save($_POST);
    	
    	$msg=$semantic->htmlMessage("msg","Un nouvel utilisateur ajouté !");
    	$msg->addHeader("Bonne nouvelle !");
    	$msg->setIcon("hand peace");
    	$msg->addClass("success");
    	$msg->setDismissable();
    	
    	$this->dispatcher->forward(["controller"=>"Index","action" => "index","params" => [$msg]]);
    	
    }
    
    public function vUpdateUserAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	
    	$user = User::findFirst($id);
    	 
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
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
    	//$form->submitOnClick("btSub1","$this->controller/updateSubmitUser", "#content-container");
    	 
    	/**
    	 * form password
    	**/
    	
    	$formPassword = $semantic->htmlForm("formPassword");
    	$fromPasswordAction = $this->url->get("$this->controller/updateUserPasswordSubmit/".$user->getId());
    	$formPassword->setProperty("action", "$fromPasswordAction");
    	$formPassword->setProperty("method", "post");
    	$formPassword->setValidationParams(["on"=>"blur","inline"=>true]);
    	$formPassword->addInput("password","Mot de passe","password","","Veuillez entrer un mot de passe")->addRules(["empty","minLength[8]"]);
    	$formPassword->addInput("checkpassword","Confirmation mot de passe","password","","Veuillez confirmer le mot de passe")->addRules(["empty","minLength[8]","match[password]"]);
    	$formPassword->addButton("btSub1","Modifier")->asSubmit();
    	//$formPassword->submitOnClick("btSub1", $this->controller."/updateUserPasswordSubmit", "#content-container");
    	
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
    
    public function updateUserPasswordSubmitAction($id){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    
    	$user = User::findFirst($id);
    
    	$user->save($_POST);
    
    	$msg=$semantic->htmlMessage("msg","Le mot de passe ont été mis à jour avec succès !");
    	$msg->addHeader("Bonne nouvelle !");
    	$msg->setIcon("hand peace");
    	$msg->addClass("success");
    	$msg->setDismissable();
    
    	$this->dispatcher->forward(["controller"=>"Index","action" => "index","params" => [$msg]]);
    }
    
    public function userSearchAction($query=NULL) {
    	$this->view->disable();
    	$this->response->setContentType('application/json', 'UTF-8');
    	$search=new SearchCategories();
    	if (isset($query) === false) {
    		$users = User::find();
    	} else {
    		$users=User::find("name like '%" . $query . "%' 
    				or firstname like '%" . $query . "%' 
    				or login like '%" . $query . "%'
    				or email like '%" . $query . "%'");
    	}
    	$search->fromDatabaseObjects($users, function ($user) use($search) {
    		$login=$user->getLogin();
    		$description="Nom : " . $user->getName(). "
						Prenom : " . $user->getFirstname()."
						login : " . $user->getLogin();
    
    		$search->add(new SearchResult($login, $user->getEmail(), $description), $user->getLogin());
    	});
    		echo $search->getResponse();
    }
    
    public function userInfoAction(){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	
    	$user = User::findFirst("login = '".$this->request->getPost('id')."'");
    	
    	$btnDelUser = $semantic->htmlButton("btnDelUser","Supprimer","ui basic negative button");
    	$btnDelUser->addIcon("icon remove user",true,false);
    	$btnDelUser->getOnClick("masters/vDeleteUser/".$user->getId(),"#result");
    	
    	$btnUpdateUser = $semantic->htmlButton("btnUpdateUser","Modifier","ui basic positive button");
    	$btnUpdateUser->addIcon("icon edit",true,false);
    	$btnUpdateUser->getOnClick("masters/vUpdateUser/".$user->getId(),"#result");
    	
    	$semantic->htmlList("list",[
    			["fa-address-card-o",$user->getName()." ".$user->getFirstname() . " (".$user->getLogin().")"],
    			["mail",$user->getEmail()],
    			["linkify",strtoupper($user->getRole()->getName())],
    	]);
    	$this->jquery->compile($this->view);
    }
    
    public function vDeleteUserAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    
    	$user = User::findFirst($id);
    
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick("index/index","#main-container");
    
    	$form=$semantic->htmlForm("frmDelete");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$form->addErrorMessage();
    	$fromAction = $this->url->get("$this->controller/confirmDelete");
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    
    	$form->addHeader("Voulez-vous vraiment supprimer l'utilisateur : ". $user->getName()." ? ",3);
    	$form->addInput("id",NULL,"hidden",$user->getId());
    	$nom = $form->addInput("name","Nom :","text",NULL,"Confirmer le nom de l'utilisateur")->addRule("empty");
    	$nom->getField()->labeledToCorner("asterisk","right");
    
    	$form->addButton("submit", "Supprimer","ui negative button")->asSubmit();
    	//$form->submitOnClick("submit",$this->controller."/confirmDelete","#table-users-update");
    
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    
    
    	$this->view->setVars(["user"=>$user]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteAction(){
    	$user = User::findFirst($_POST['id']);
    
    	if($user->getName() == $_POST['name']){
    		$user->delete();
    
    		$this->flash->message("success","L'utilisateur '".$_POST['name']."' a été supprimé avec succès");
    		$this->jquery->get($this->controller,"#table-users-update");
    
    	}else{
    
    		$this->flash->message("error","L'utilisateur '".$user->getName()."' n'a pas été supprimé : Le nom ne correspond pas ! ");
    		$this->jquery->get($this->controller,"#table-users-update");
    	}
    
    	echo $this->jquery->compile();
    }
    
    
    public function vAddRoleAction(){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	 
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    
    	$form=$semantic->htmlForm("frmAdd");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$name = $form->addInput("nameRole","Nom","text")->addRule("empty");
    	$name->getField()->labeledToCorner("asterisk","right");
    	$form->addButton("submit","Ajouter le rôle","button green")->postFormOnClick("ManageRole/newRole","frmAdd","#result");
    	$this->jquery->compile($this->view);
    }
    
    

    
    
    public function vUpdateRoleAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    	 
    	$role = Role::findFirst($id);
    	
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    	
    	$form=$semantic->htmlForm("frmUpdate");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	
    	$fromAction = $this->url->get("$this->controller/updateRoleSubmit/".$role->getId());
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    	
    	$name = $form->addInput("name","Nom","text",$role->getName())->addRule("empty");
    	$name->getField()->labeledToCorner("asterisk","right");
    	$form->addButton("submit","Modifier le rôle","button green")->asSubmit();
    	//$form->addButton("btSub1","Modifier")->asSubmit();
    	//$form->submitOnClick("btSub1", $this->controller."/updateUserPasswordSubmit", "#content-container");
    	   
    	
    	$this->jquery->compile($this->view);
    }
    
    public function updateRoleSubmitAction($id){
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    
    	$role = Role::findFirst($id);
    
    	$role->save($_POST);
    
    	$msg=$semantic->htmlMessage("msg","Le role a été mis à jour avec succès !");
    	$msg->addHeader("Bonne nouvelle !");
    	$msg->setIcon("hand peace");
    	$msg->addClass("success");
    	$msg->setDismissable();
    
    	$this->dispatcher->forward(["controller"=>"Index","action" => "index","params" => [$msg]]);
    }
    
    public function vDeleteRoleAction($id){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);
    
    	$role = Role::findFirst($id);
    
    	$semantic=$this->semantic;
    	$semantic->setLanguage("fr");
    
    	$btnCancel = $semantic->htmlButton("btnCancel","Annuler","red");
    	$btnCancel->getOnClick("index/index","#main-container");
    
    	$form=$semantic->htmlForm("frmDelete");
    	$form->setValidationParams(["on"=>"blur","inline"=>true]);
    	$form->addErrorMessage();
    	$fromAction = $this->url->get("$this->controller/confirmDeleteRole");
    	$form->setProperty("action", "$fromAction");
    	$form->setProperty("method", "post");
    
    	$form->addHeader("Voulez-vous vraiment supprimer le role : ". $role->getName()." ? ",3);
    	$form->addInput("id",NULL,"hidden",$role->getId());
    	$nom = $form->addInput("name","Nom :","text",NULL,"Confirmer le nom du role")->addRule("empty");
    	$nom->getField()->labeledToCorner("asterisk","right");
    
    	$form->addButton("submit", "Supprimer","ui negative button")->asSubmit();
    	//$form->submitOnClick("submit",$this->controller."/confirmDelete","#table-users-update");
    
    	$form->addButton("btnCancel", "Annuler","ui positive button");
    
    
    	$this->view->setVars(["role"=>$role]);
    
    	$this->jquery->compile($this->view);
    }
    
    public function confirmDeleteRoleAction(){
    	$role = Role::findFirst($_POST['id']);
    
    	if($role->getName() == $_POST['name']){
    		$role->delete();
    
    		$this->flash->message("success","Le role '".$_POST['name']."' a été supprimé avec succès");
    		$this->jquery->get($this->controller,"#table-role-update");
    
    	}else{
    
    		$this->flash->message("error","Le roles '".$role->getName()."' n'a pas été supprimé : Le nom ne correspond pas ! ");
    		$this->jquery->get($this->controller,"#table-role-update");
    	}
    
    	echo $this->jquery->compile();
    }
}

