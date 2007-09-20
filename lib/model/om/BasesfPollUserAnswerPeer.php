<?php


abstract class BasesfPollUserAnswerPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_polls_users_answers';

	
	const CLASS_DEFAULT = 'plugins.sfPropelPollsPlugin.lib.model.sfPollUserAnswer';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_polls_users_answers.ID';

	
	const POLL_ID = 'sf_polls_users_answers.POLL_ID';

	
	const ANSWER_ID = 'sf_polls_users_answers.ANSWER_ID';

	
	const USER_ID = 'sf_polls_users_answers.USER_ID';

	
	const CREATED_AT = 'sf_polls_users_answers.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'PollId', 'AnswerId', 'UserId', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (sfPollUserAnswerPeer::ID, sfPollUserAnswerPeer::POLL_ID, sfPollUserAnswerPeer::ANSWER_ID, sfPollUserAnswerPeer::USER_ID, sfPollUserAnswerPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'poll_id', 'answer_id', 'user_id', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'PollId' => 1, 'AnswerId' => 2, 'UserId' => 3, 'CreatedAt' => 4, ),
		BasePeer::TYPE_COLNAME => array (sfPollUserAnswerPeer::ID => 0, sfPollUserAnswerPeer::POLL_ID => 1, sfPollUserAnswerPeer::ANSWER_ID => 2, sfPollUserAnswerPeer::USER_ID => 3, sfPollUserAnswerPeer::CREATED_AT => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'poll_id' => 1, 'answer_id' => 2, 'user_id' => 3, 'created_at' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfPropelPollsPlugin/lib/model/map/sfPollUserAnswerMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfPropelPollsPlugin.lib.model.map.sfPollUserAnswerMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfPollUserAnswerPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(sfPollUserAnswerPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfPollUserAnswerPeer::ID);

		$criteria->addSelectColumn(sfPollUserAnswerPeer::POLL_ID);

		$criteria->addSelectColumn(sfPollUserAnswerPeer::ANSWER_ID);

		$criteria->addSelectColumn(sfPollUserAnswerPeer::USER_ID);

		$criteria->addSelectColumn(sfPollUserAnswerPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(sf_polls_users_answers.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_polls_users_answers.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfPollUserAnswerPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfPollUserAnswerPeer::populateObjects(sfPollUserAnswerPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollUserAnswerPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfPollUserAnswerPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfPollUserAnswerPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfPollUserAnswerPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinsfPoll(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinsfPollAnswer(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinMember(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinsfPoll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfPollPeer::addSelectColumns($c);

		$c->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfPollPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfPoll(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfPollUserAnswer($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinsfPollAnswer(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfPollAnswerPeer::addSelectColumns($c);

		$c->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfPollAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfPollAnswer(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfPollUserAnswer($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinMember(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		MemberPeer::addSelectColumns($c);

		$c->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = MemberPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getMember(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfPollUserAnswer($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$criteria->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);

		$criteria->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol2 = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfPollPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfPollPeer::NUM_COLUMNS;

		sfPollAnswerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfPollAnswerPeer::NUM_COLUMNS;

		MemberPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + MemberPeer::NUM_COLUMNS;

		$c->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$c->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);

		$c->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = sfPollPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfPoll(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfPollUserAnswer($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1);
			}


					
			$omClass = sfPollAnswerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfPollAnswer(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addsfPollUserAnswer($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initsfPollUserAnswers();
				$obj3->addsfPollUserAnswer($obj1);
			}


					
			$omClass = MemberPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getMember(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addsfPollUserAnswer($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initsfPollUserAnswers();
				$obj4->addsfPollUserAnswer($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptsfPoll(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);

		$criteria->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptsfPollAnswer(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$criteria->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptMember(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPollUserAnswerPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$criteria->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);

		$rs = sfPollUserAnswerPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptsfPoll(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol2 = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfPollAnswerPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfPollAnswerPeer::NUM_COLUMNS;

		MemberPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + MemberPeer::NUM_COLUMNS;

		$c->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);

		$c->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfPollAnswerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfPollAnswer(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfPollUserAnswer($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1);
			}

			$omClass = MemberPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getMember(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addsfPollUserAnswer($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initsfPollUserAnswers();
				$obj3->addsfPollUserAnswer($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptsfPollAnswer(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol2 = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfPollPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfPollPeer::NUM_COLUMNS;

		MemberPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + MemberPeer::NUM_COLUMNS;

		$c->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$c->addJoin(sfPollUserAnswerPeer::USER_ID, MemberPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfPollPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfPoll(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfPollUserAnswer($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1);
			}

			$omClass = MemberPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getMember(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addsfPollUserAnswer($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initsfPollUserAnswers();
				$obj3->addsfPollUserAnswer($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptMember(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfPollUserAnswerPeer::addSelectColumns($c);
		$startcol2 = (sfPollUserAnswerPeer::NUM_COLUMNS - sfPollUserAnswerPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfPollPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfPollPeer::NUM_COLUMNS;

		sfPollAnswerPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfPollAnswerPeer::NUM_COLUMNS;

		$c->addJoin(sfPollUserAnswerPeer::POLL_ID, sfPollPeer::ID);

		$c->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfPollUserAnswerPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfPollPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfPoll(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfPollUserAnswer($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initsfPollUserAnswers();
				$obj2->addsfPollUserAnswer($obj1);
			}

			$omClass = sfPollAnswerPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfPollAnswer(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addsfPollUserAnswer($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initsfPollUserAnswers();
				$obj3->addsfPollUserAnswer($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfPollUserAnswerPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollUserAnswerPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfPollUserAnswerPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(sfPollUserAnswerPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfPollUserAnswerPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfPollUserAnswerPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollUserAnswerPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfPollUserAnswerPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(sfPollUserAnswerPeer::ID);
			$selectCriteria->add(sfPollUserAnswerPeer::ID, $criteria->remove(sfPollUserAnswerPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfPollUserAnswerPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfPollUserAnswerPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(sfPollUserAnswerPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(sfPollUserAnswerPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfPollUserAnswer) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfPollUserAnswerPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(sfPollUserAnswer $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfPollUserAnswerPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfPollUserAnswerPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(sfPollUserAnswerPeer::DATABASE_NAME, sfPollUserAnswerPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfPollUserAnswerPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(sfPollUserAnswerPeer::DATABASE_NAME);

		$criteria->add(sfPollUserAnswerPeer::ID, $pk);


		$v = sfPollUserAnswerPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(sfPollUserAnswerPeer::ID, $pks, Criteria::IN);
			$objs = sfPollUserAnswerPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfPollUserAnswerPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfPropelPollsPlugin/lib/model/map/sfPollUserAnswerMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfPropelPollsPlugin.lib.model.map.sfPollUserAnswerMapBuilder');
}
