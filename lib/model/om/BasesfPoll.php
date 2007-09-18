<?php


abstract class BasesfPoll extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $title;


	
	protected $description;


	
	protected $is_published;


	
	protected $created_at;

	
	protected $collsfPollAnswers;

	
	protected $lastsfPollAnswerCriteria = null;

	
	protected $collsfPollUserAnswers;

	
	protected $lastsfPollUserAnswerCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getIsPublished()
	{

		return $this->is_published;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfPollPeer::ID;
		}

	} 
	
	public function setTitle($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = sfPollPeer::TITLE;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = sfPollPeer::DESCRIPTION;
		}

	} 
	
	public function setIsPublished($v)
	{

		if ($this->is_published !== $v) {
			$this->is_published = $v;
			$this->modifiedColumns[] = sfPollPeer::IS_PUBLISHED;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = sfPollPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->title = $rs->getString($startcol + 1);

			$this->description = $rs->getString($startcol + 2);

			$this->is_published = $rs->getBoolean($startcol + 3);

			$this->created_at = $rs->getTimestamp($startcol + 4, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfPoll object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfPoll:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfPollPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfPollPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfPoll:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfPoll:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfPollPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfPollPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfPoll:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfPollPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfPollPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collsfPollAnswers !== null) {
				foreach($this->collsfPollAnswers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfPollUserAnswers !== null) {
				foreach($this->collsfPollUserAnswers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = sfPollPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfPollAnswers !== null) {
					foreach($this->collsfPollAnswers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfPollUserAnswers !== null) {
					foreach($this->collsfPollUserAnswers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfPollPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTitle();
				break;
			case 2:
				return $this->getDescription();
				break;
			case 3:
				return $this->getIsPublished();
				break;
			case 4:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfPollPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitle(),
			$keys[2] => $this->getDescription(),
			$keys[3] => $this->getIsPublished(),
			$keys[4] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfPollPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTitle($value);
				break;
			case 2:
				$this->setDescription($value);
				break;
			case 3:
				$this->setIsPublished($value);
				break;
			case 4:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfPollPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsPublished($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfPollPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfPollPeer::ID)) $criteria->add(sfPollPeer::ID, $this->id);
		if ($this->isColumnModified(sfPollPeer::TITLE)) $criteria->add(sfPollPeer::TITLE, $this->title);
		if ($this->isColumnModified(sfPollPeer::DESCRIPTION)) $criteria->add(sfPollPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(sfPollPeer::IS_PUBLISHED)) $criteria->add(sfPollPeer::IS_PUBLISHED, $this->is_published);
		if ($this->isColumnModified(sfPollPeer::CREATED_AT)) $criteria->add(sfPollPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfPollPeer::DATABASE_NAME);

		$criteria->add(sfPollPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTitle($this->title);

		$copyObj->setDescription($this->description);

		$copyObj->setIsPublished($this->is_published);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getsfPollAnswers() as $relObj) {
				$copyObj->addsfPollAnswer($relObj->copy($deepCopy));
			}

			foreach($this->getsfPollUserAnswers() as $relObj) {
				$copyObj->addsfPollUserAnswer($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfPollPeer();
		}
		return self::$peer;
	}

	
	public function initsfPollAnswers()
	{
		if ($this->collsfPollAnswers === null) {
			$this->collsfPollAnswers = array();
		}
	}

	
	public function getsfPollAnswers($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfPollAnswers === null) {
			if ($this->isNew()) {
			   $this->collsfPollAnswers = array();
			} else {

				$criteria->add(sfPollAnswerPeer::POLL_ID, $this->getId());

				sfPollAnswerPeer::addSelectColumns($criteria);
				$this->collsfPollAnswers = sfPollAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfPollAnswerPeer::POLL_ID, $this->getId());

				sfPollAnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfPollAnswerCriteria) || !$this->lastsfPollAnswerCriteria->equals($criteria)) {
					$this->collsfPollAnswers = sfPollAnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfPollAnswerCriteria = $criteria;
		return $this->collsfPollAnswers;
	}

	
	public function countsfPollAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfPollAnswerPeer::POLL_ID, $this->getId());

		return sfPollAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfPollAnswer(sfPollAnswer $l)
	{
		$this->collsfPollAnswers[] = $l;
		$l->setsfPoll($this);
	}

	
	public function initsfPollUserAnswers()
	{
		if ($this->collsfPollUserAnswers === null) {
			$this->collsfPollUserAnswers = array();
		}
	}

	
	public function getsfPollUserAnswers($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollUserAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfPollUserAnswers === null) {
			if ($this->isNew()) {
			   $this->collsfPollUserAnswers = array();
			} else {

				$criteria->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());

				sfPollUserAnswerPeer::addSelectColumns($criteria);
				$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());

				sfPollUserAnswerPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfPollUserAnswerCriteria) || !$this->lastsfPollUserAnswerCriteria->equals($criteria)) {
					$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfPollUserAnswerCriteria = $criteria;
		return $this->collsfPollUserAnswers;
	}

	
	public function countsfPollUserAnswers($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollUserAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());

		return sfPollUserAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfPollUserAnswer(sfPollUserAnswer $l)
	{
		$this->collsfPollUserAnswers[] = $l;
		$l->setsfPoll($this);
	}


	
	public function getsfPollUserAnswersJoinsfPollAnswer($criteria = null, $con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollUserAnswerPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfPollUserAnswers === null) {
			if ($this->isNew()) {
				$this->collsfPollUserAnswers = array();
			} else {

				$criteria->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());

				$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelectJoinsfPollAnswer($criteria, $con);
			}
		} else {
									
			$criteria->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());

			if (!isset($this->lastsfPollUserAnswerCriteria) || !$this->lastsfPollUserAnswerCriteria->equals($criteria)) {
				$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelectJoinsfPollAnswer($criteria, $con);
			}
		}
		$this->lastsfPollUserAnswerCriteria = $criteria;

		return $this->collsfPollUserAnswers;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfPoll:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfPoll::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 