<?php

use Ajax\Semantic;
use Ajax\semantic\html\collections\form\HtmlFormDropdown;
use Ajax\service\JArray;

class ConfigController extends ControllerBase
{

	public function indexAction($msg)
	{
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		

		
		$user = $this->session->auth;
		$user = User::findFirst($user->getId());
		

		$semantic=$this->semantic;
		
		$mess=$semantic->htmlMessage("mess1","Cette interface permet aux utilisateurs d'avoir accés aux VirtualHosts de leurs differentes machines.");
		$mess->setVariation("floating");
		


		if($user->getIdrole()==2){
			$host = Host::find("idUser=".$user->getId());
		}
		elseif ($user->getIdrole()==1){
			$host = Host::find();
		}


		
		$btnAddHost = $semantic->htmlButton("btnAddHost","Ajouter une machine","ui basic button");
		$btnAddHost->addIcon("icon add",false,true);
		$btnAddHost->getOnClick("Config/addHost","#modifHost");
		
		
		
		$cards=$semantic->htmlCardGroups("cards2");
		$cards->setWide(3);
		$cards->fromDatabaseObjects($host,function($host) use ($cards){

					
			$card=$cards->newItem("card-".$host->getId());
			$card->setIdentifier($host->getId());
			$idHost=$card->getIdentifier();
						
			$card->addItemHeaderContent($host->getName(),$host->getIpv4());
			$card->addToProperty("data-ajax", $host->getId());

			$card->getOnClick("Config/liste/".$idHost,"#liste");
			return $card;					
		});
		


		
			
		$this->jquery->compile($this->view);

	}
	
	public function addHostAction(){
		
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		$semantic->htmlMessage ( "messageInfo", "<b> Veuillez rentrer les informations de votre machine.");
		$form = $semantic->htmlForm("formAddHost");
		$separation=$semantic->htmlDivider("");
		$form->addItem($separation);
		$form->setValidationParams(["on"=>"blur","inline"=>true]);
		$titre=$semantic->htmlHeader("",3,"Ajouter une machine ")->setAttachment($segment,"top");
		$titre->addIcon("disk outline");
		$form->addItem($titre);
		$form->addInput("name","Nom","text","","Entrez le nom de votre machine")->addRule("empty");
		$form->addInput("ipv4","IPv4","text","","Entrez l'addresse IPv4 de votre machine")->addRule("empty");
		$form->addInput("ipv6","IPv6","text","","Entrez l'addresse IPv6 de votre machine");
		$form->addButton("btSub1","Ajouter")->asSubmit();
		$form->submitOnClick("btSub1", "Config/createHost", "#content-container");
		$this->jquery->compile($this->view);
	}
	
	public function createHostAction(){
		
		$host=new Host();
		$user = $this->session->auth;
		$user = $user->getId();
		$host->setIdUser($user);
		$host->save($_POST);
		$this->response->redirect("$this->controller/index");
	}
	
	
	public function listeAction($machine){
		/* if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$machine   = $this->request->getPost("machine");
			
		} */
		$machine=Host::findFirst("id= ".$machine);
		$this->view->setVars(["machine"=>$machine]);
		
		$user = $this->session->auth;
		$user = User::findFirst($user->getId());
		
		$srvs = Server::find("idHost=".$machine->getId());
		$semantic=$this->semantic;
		
		$form=$semantic->htmlForm("frm2");
		
		$separation=$semantic->htmlDivider("");
		$form->addItem($separation);
		
	
		$btdel=$semantic->htmlButton("btdel","Supprimer");
		$btdel->addIcon("remove",false,true);
		$btdel->getOnClick("Config/deleteHost/".$machine->getId(),"#modifHost");
		
		$titre=$semantic->htmlHeader("",3,"Liste des virtualhosts pour la machine ".$machine->getName())->setAttachment($segment,"top");
		$titre->addIcon("disk outline");
		
		$form->addItem($titre);
		
	
		$form->addItem($btdel);
		
		if (count(Server::find("idHost=".$machine->getId()))==0){
			$mess=$semantic->htmlMessage("mess5","Aucun Virtualhost disponible pour cette machine...");
			$mess->setVariation("floating");
			$mess->setIcon("cloud big");
			$form->addItem($mess);
			
		}
		
		foreach ($srvs as $srv){
		$vhs = Virtualhost::find("idServer=".$srv->getId());
		

		
		$table=$semantic->dataTable("table","VirtualHost",$vhs);
		$table->setFields(["name"]);
		$table->setCaptions(["Nom","Actions"]);
		$table->setColWidths([8,8]);
		
		$table->addFieldButton("Redemarer",false,function(&$bt,$instance){
			$bt->addIcon("refresh",true,true);
			$bt->addToProperty("class","restart");
		});
		$table->setIdentifierFunction("getId");
		$this->jquery->getOnClick("#table .restart", "config/reboot","#liste",["attr"=>"data-ajax"]);
		$table->asForm();
		$table->submitOnClick("Redemarer","Config/rebot","#reboot");
		
		$label=$semantic->htmlSegment("label");
		$label->addLabel("Serveur : ". $srv->getName())->asRibbon()->setColor("red");
		$label->addContent($table);
		
		$form->addItem($label);
		}

		$this->jquery->compile($this->view);
		
		
	}
	
	public function deleteHostAction($id){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$host = Host::findFirst($id);
		
		$semantic=$this->semantic;
		$semantic->setLanguage("fr");
		
		
		$form=$semantic->htmlForm("frmDelete");
		
		$form->setValidationParams(["on"=>"blur","inline"=>true]);
		$form->addErrorMessage();
		
		$form->addHeader("Voulez-vous vraiment supprimer l'élément : ". $host->getName()." ? ",3);
		$form->addInput("id",NULL,"hidden",$host->getId());
		$nom = $form->addInput("name","Nom *:","text",NULL,"Confirmer le nom de la machine")->addRule("empty");
		$nom->getField()->labeledToCorner("asterisk","right");
		
		$form->addButton("btnCancel", "Annuler","ui positive button");
		
		$form->addButton("submit", "Supprimer","ui negative button")->asSubmit();
		$form->submitOnClick("submit",$this->controller."/confirmDelete","#divAction");
		
		
		
		//$this->view->setVars(["element"=>$host]);
		
		$this->jquery->compile($this->view);
	}
	
	public function confirmDeleteAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$Host = Host::findFirst($_POST['id']);
		
		if($Host->getName() == $_POST['name']){
			$this->flash->message("success","Le host a �t� supprim� avec succ�s");
			$this->jquery->get($this->controller,"#refresh");
			
		}else{
			
			$this->flash->message("error","Le host n'a pas �t� supprim� : Le nom ne correspond pas ! ");
			$this->jquery->get($this->controller,"#refresh");
		}
		
		$this->jquery->compile($this->view);
		
	}
	
	public function rebootAction($id){
		
		$this->view->disable();
		echo $id;
		
		$vh= Virtualhost::findFirst("id=".$id);
		$address="127.0.0.1";
		$port="80";
		$action="restart";
		Network::$semantic=$this->semantic;
		$responses=Network::send("172.16.104.25", "9001", "run", "restart Apache2");
		echo Network::displayMessages($responses);
		
		echo $this->jquery->compile();
		
	}
	/*public function rebootAction(){
		
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$idVH  = $this->request->getPost("virtualhost");

		}
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		

			$virtualhost = Virtualhost::findFirst("id = ".$idVH);
			$this->view->setVars(["virtualhost"=>$virtualhost]);
			

			$this->jquery->compile($this->view); 
			
	

	}
	public function rebootServAction(){
	
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$idServ  = $this->request->getPost("server");
	
		}
	
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
	
	
	
		$server = Server::findFirst("id = ".$idServ);
		$this->view->setVars(["server"=>$server]);
			
	
		$this->jquery->compile($this->view);
			
	
	
	}
	public function finAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$id  = $this->request->getPost("virtualhost");
		}
		
		
		
		
		$this->jquery->compile($this->view);
		
		
		
	}
	public function finServAction(){
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$id  = $this->request->getPost("server");
		}
	
	
	
	
		$this->jquery->compile($this->view);
	
	
	
	}*/
	
	
}