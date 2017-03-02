<?php


class ConfigFileGeneratorTest extends PHPUnit_Framework_TestCase {

	public function testJesaispas()
	{
		$variable="<VirtualHost {{*:80}}>
    {{properties}}
</VirtualHost>";
		$this->assertEquals(ConfigFileGenerator::configTemplate(2),$variable);
	}


}