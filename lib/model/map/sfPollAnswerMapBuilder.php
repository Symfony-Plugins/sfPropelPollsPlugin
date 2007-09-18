<?php



class sfPollAnswerMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelPollsPlugin.lib.model.map.sfPollAnswerMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('sf_polls_answers');
		$tMap->setPhpName('sfPollAnswer');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('POLL_ID', 'PollId', 'int', CreoleTypes::INTEGER, 'sf_polls', 'ID', false, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('VOTES', 'Votes', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 