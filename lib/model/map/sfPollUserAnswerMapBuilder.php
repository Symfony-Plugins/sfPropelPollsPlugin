<?php



class sfPollUserAnswerMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelPollsPlugin.lib.model.map.sfPollUserAnswerMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_polls_users_answers');
		$tMap->setPhpName('sfPollUserAnswer');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('POLL_ID', 'PollId', 'int', CreoleTypes::INTEGER, 'sf_polls', 'ID', false, null);

		$tMap->addForeignKey('ANSWER_ID', 'AnswerId', 'int', CreoleTypes::INTEGER, 'sf_polls_answers', 'ID', false, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'member', 'ID', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 