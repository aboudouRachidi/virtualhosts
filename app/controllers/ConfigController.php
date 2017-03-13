<?php

use Ajax\Semantic;
use Ajax\semantic\html\collections\form\HtmlFormDropdown;
use Ajax\service\JArray;

class ConfigController extends ControllerBase
{

	public function indexAction()
	{
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$servers=Server::find();
		$this->view->setVars(["servers"=>$servers]);
		
		//$hosts=Host::find();
		//$this->view->setVars(["hosts"=>$hosts]);
		
		$user = $this->session->auth;
		$user = User::findFirst($user->getId());
		
		$virtualhosts=Virtualhost::find();
		$this->view->setVars(["virtualhosts"=>$virtualhosts,"user"=>$user]);
		
		$semantic=$this->semantic;
		
		$mess=$semantic->htmlMessage("mess1","Cette interface permet aux utilisateurs de redémarer les VirtualHosts de la machine selectionné.");
		$mess->setVariation("floating");

		$host = Host::find("idUser=".$user->getId());
		$itemsHost = JArray::modelArray($host,"getId","getName");
		$form=$semantic->htmlForm("frm");
		$form->addField(new HtmlFormDropdown("machine",$itemsHost,"Machine","Selectionnez un machine"));
		$form->addButton("btnValider","Valider","ui green button")->setTagName("a")->addIcon("checkmark icon");
		$form->submitOnClick("btnValider","Config/liste","#liste");
		$this->jquery->compile($this->view);

	}
	public function listeAction(){
		if ($this->request->isPost()) {
			// récupére les donnée dans le formulaire
			$machine   = $this->request->getPost("machine");
			
		}
		$machine=Host::findFirst("id= ".$machine);
		$this->view->setVars(["machine"=>$machine]);
		
		$user = $this->session->auth;
		$user = User::findFirst($user->getId());
		
		$srvs = Server::find("idHost=".$machine->getId());
		$semantic=$this->semantic;
		
		$form=$semantic->htmlForm("frm2");
		
		$separation=$semantic->htmlDivider("");
		$form->addItem($separation);
		
		$titre=$semantic->htmlHeader("",3,"Liste des virtualhosts pour la machine ".$machine->getName())->setAttachment($segment,"top");
		$titre->addIcon("disk outline");
		$form->addItem($titre);
		
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