<?php


class ConfigFileGeneratorTest extends PHPUnit_Framework_TestCase {

	/*public function testJesaispas()
	{
		$variable="<VirtualHost {{name}}>
    {{properties}}
</VirtualHost>";
		echo ConfigFileGenerator::configTemplate(2);
		$this->assertEquals(ConfigFileGenerator::configTemplate(2),$variable);
		return $this;
	}*/

	public function testgetConf(){
		//ConfigFileGenerator::getConf();
		$this->assertNotNull(ConfigFileGenerator::getConf());
	}
	
	public function testgetValue(){
		//ConfigFileGenerator::getConf();
		$this->assertNotNull(ConfigFileGenerator::getValue());
	}
	
	public function testgetTemplate(){
		//ConfigFileGenerator::getConf();
		$this->assertNotNull(ConfigFileGenerator::getTemplate());
	}

}