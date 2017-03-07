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
				
		$vhs = Virtualhost::find("idUser=".$user->getId());
		
	    
		
		$semantic=$this->semantic;
		
		$redemarer=$semantic->htmlButton("Redemarer","Redemarer");
		$redemarer->addIcon("power",false,true);
		
		$table=$semantic->dataTable("table","VirtualHost",$vhs);
		$table->setFields(["name","serveur"]);
		$table->setCaptions(["Nom","Serveur","Actions"]);
		$table->addFieldButton("Redemarer");
		

		
		
		
		
		
		
		
		
		
		
		$this->secondaryMenu($this->controller,$this->action);
		$this->tools($this->controller,$this->action);
		
		$servers=Server::find();
		$this->view->setVars(["servers"=>$servers]);
		
		$hosts=Host::find();
		$this->view->setVars(["hosts"=>$hosts]);
		
		$user = $this->session->auth;
		$user = User::findFirst($user->getId());
		
		$virtualhosts=Virtualhost::find();
		$this->view->setVars(["virtualhosts"=>$virtualhosts,"user"=>$user,"host"=>$host]);
		
		$this->jquery->compile($this->view);
		
		
	}
	public function rebootAction(){
		
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
	
	
	
	}
	
	
}