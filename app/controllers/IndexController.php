<?php

use Phalcon\Mvc\View;
use Ajax\semantic\html\elements\HtmlButton;
class IndexController extends ControllerBase{

    public function indexAction($msg=NULL){
    	$this->secondaryMenu($this->controller,$this->action);
    	$this->tools($this->controller,$this->action);

    	$semantic=$this->semantic;
    	$button=$semantic->htmlButton("btAfficher","Afficher message")->setColor("red");
    	$message=$semantic->htmlMessage("message1","<b>Cliquer</b> sur le bouton...");
    	$button->onClick($message->jsHtml("Click sur bouton"));
		$semantic->htmlButton("btApache","Apache file","green")->getOnClick("Index/readApache","#file");
		$semantic->htmlButton("btNginx","NginX file","black")->getOnClick("Index/readNginX","#file");
		$semantic->htmlButton("btTmp","Accès aux US","purple")->getOnClick("Tmp/index","#file");
		$btEx=$semantic->htmlButton("btEx","Test des échanges client/serveur")->getOnClick("ServerExchange/index","#file");
		$btEx->addLabel("New");
		
		$btEditProfile = $semantic->htmlButton("btEditProfile","Modifier mes informations","green w3-block w3-theme-l1 w3-left-align");
		$btEditProfile->addIcon("settings fa-fw w3-margin-right",true,true);
		$btEditProfile->getOnClick("Users/index",".middle-column");
		
		$btEditPassword = $semantic->htmlButton("btEditPassword","Modifier mon mot de passe","orange w3-block w3-theme-l1 w3-left-align");
		$btEditPassword->addIcon("setting fa-fw w3-margin-right",true,true);
		$btEditPassword->getOnClick("Users/updatePassword",".middle-column");
		
		$lbl = $semantic->htmlLabel("lbl","Test echange...")->getOnClick("ServerExchange/index","#file");
		$lbl->addProperties("w3-button w3-block w3-dark-grey");
		$user = $this->session->get("auth");
		$this->view->setVars(["user"=>$user,"msg"=>$msg]);
		
		$this->jquery->compile($this->view);
    }

    public function hostsAction(){
    	$this->tools($this->controller,$this->action);
    	$this->jquery->get("Index/secondaryMenu/{$this->controller}/{$this->action}","#secondary-container");
		$this->jquery->compile($this->view);
    }

    public function virtualhostsAction(){
    	$this->tools($this->controller,$this->action);
    	$this->jquery->get("Index/secondaryMenu/{$this->controller}/{$this->action}","#secondary-container");
    	$this->jquery->compile($this->view);
    }

    public function newVirtualhostAction(){

    }

    public function readApacheAction(){
    	$this->readAndHighlightAll("apache", "apacheconf");
    }

    public function readNginXAction(){
    	$this->readAndHighlightAll("nginx", "javascript");
    }

    private function readAndHighlightAll($file,$language){
    	$fileContent=trim(htmlspecialchars(file_get_contents($this->view->getViewsDir()."/{$file}.cnf")));
    	echo "<pre><code class='language-{$language}'>".$fileContent."</code></pre>";
    	$this->jquery->exec("Prism.highlightAll();",true);
    	echo $this->jquery->compile($this->view);
    }

}

