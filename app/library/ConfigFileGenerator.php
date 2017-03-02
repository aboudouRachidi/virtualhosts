<?php
class ConfigFileGenerator{

	
	
	public function configTemplate($VHid) {
		$vh=Virtualhost::findFirst("id='{$VHid}'");		
		$stype=$vh->getServer()->getStype();
		$configTemplate=$stype->getconfigTemplate();
		$name=$vh->getName();
		$configTemplate= str_replace("name",$name,$configTemplate);
		return $configTemplate;		
	}
	
	/*public function template($VHid) {
		$vh=Virtualhost::findFirst("id='{$VHid}'");
		$vhproperties=Virtualhostproperty::find(['conditions'=>'idVirtualhost IN ('.$vh->getId().')' ]);
		
	}*/
}