<?php
class ConfigFileGenerator{

	
	
	/*public static function configTemplate($VHid) {
		$vh=Virtualhost::findFirst("id='{$VHid}'");		
		$stype=$vh->getServer()->getStype();
		$configTemplate=$stype->getconfigTemplate();
		$name=$vh->getName();
		$configTemplate= str_replace("name",$name,$configTemplate);
		return $configTemplate;		
	}
	
	public function template($VHid) {
		$vh=Virtualhost::findFirst("id='{$VHid}'");
		$vhproperties=Virtualhostproperty::find(['conditions'=>'idVirtualhost IN ('.$vh->getId().')' ]);
		
	}*/
	public static function getConf(){
		$vh=Virtualhost::findFirst();
		$stype=$vh->getServer()->getStype();
		$configTemplate=$stype->getconfigTemplate();
		return $configTemplate;
	}
	
	public static function getValue(){
		$vh=Virtualhost::findFirst();
		$Value=Virtualhostproperty::findFirst("idVirtualhost=".$vh->getId());
		$Value->getValue();
		return $Value;
	}
	
	public static function getTemplate(){
		$vh=Virtualhost::findFirst();
		$stype=$vh->getServer()->getStype();
		$stypeProperty=Stypeproperty::findFirst("idStype=".$stype->getId());
		$stypeProperty->getTemplate();
		return $stypeProperty;
	}
	
	
}