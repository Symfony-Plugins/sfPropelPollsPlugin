<?php


abstract class BasesfPollAnswer extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $poll_id;


	
	protected $name;


	
	protected $votes;

	
	protected $asfPoll;

	
	protected $collsfPollUserAnswers;

	
	protected $lastsfPollUserAnswerCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getPollId()
	{

		return $this->poll_id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getVotes()
	{

		return $this->votes;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfPollAnswerPeer::ID;
		}

	} 
	
	public function setPollId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->poll_id !== $v) {
			$this->poll_id = $v;
			$this->modifiedColumns[] = sfPollAnswerPeer::POLL_ID;
		}

		if ($this->asfPoll !== null && $this->asfPoll->getId() !== $v) {
			$this->asfPoll = null;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = sfPollAnswerPeer::NAME;
		}

	} 
	
	public function setVotes($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->votes !== $v) {
			$this->votes = $v;
			$this->modifiedColumns[] = sfPollAnswerPeer::VOTES;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->poll_id = $rs->getInt($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->votes = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfPollAnswer object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollAnswer:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfPollAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfPollAnswerPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfPollAnswer:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollAnswer:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfPollAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfPollAnswer:save:post') as $callable)
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


												
			if ($this->asfPoll !== null) {
				if ($this->asfPoll->isModified()) {
					$affectedRows += $this->asfPoll->save($con);
				}
				$this->setsfPoll($this->asfPoll);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfPollAnswerPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfPollAnswerPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->asfPoll !== null) {
				if (!$this->asfPoll->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfPoll->getValidationFailures());
				}
			}


			if (($retval = sfPollAnswerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = sfPollAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getPollId();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getVotes();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfPollAnswerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPollId(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getVotes(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfPollAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setPollId($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setVotes($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfPollAnswerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPollId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setVotes($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfPollAnswerPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfPollAnswerPeer::ID)) $criteria->add(sfPollAnswerPeer::ID, $this->id);
		if ($this->isColumnModified(sfPollAnswerPeer::POLL_ID)) $criteria->add(sfPollAnswerPeer::POLL_ID, $this->poll_id);
		if ($this->isColumnModified(sfPollAnswerPeer::NAME)) $criteria->add(sfPollAnswerPeer::NAME, $this->name);
		if ($this->isColumnModified(sfPollAnswerPeer::VOTES)) $criteria->add(sfPollAnswerPeer::VOTES, $this->votes);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfPollAnswerPeer::DATABASE_NAME);

		$criteria->add(sfPollAnswerPeer::ID, $this->id);

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

		$copyObj->setPollId($this->poll_id);

		$copyObj->setName($this->name);

		$copyObj->setVotes($this->votes);


		if ($deepCopy) {
									$copyObj->setNew(false);

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
			self::$peer = new sfPollAnswerPeer();
		}
		return self::$peer;
	}

	
	public function setsfPoll($v)
	{


		if ($v === null) {
			$this->setPollId(NULL);
		} else {
			$this->setPollId($v->getId());
		}


		$this->asfPoll = $v;
	}


	
	public function getsfPoll($con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollPeer.php';

		if ($this->asfPoll === null && ($this->poll_id !== null)) {

			$this->asfPoll = sfPollPeer::retrieveByPK($this->poll_id, $con);

			
		}
		return $this->asfPoll;
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

				$criteria->add(sfPollUserAnswerPeer::ANSWER_ID, $this->getId());

				sfPollUserAnswerPeer::addSelectColumns($criteria);
				$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfPollUserAnswerPeer::ANSWER_ID, $this->getId());

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

		$criteria->add(sfPollUserAnswerPeer::ANSWER_ID, $this->getId());

		return sfPollUserAnswerPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfPollUserAnswer(sfPollUserAnswer $l)
	{
		$this->collsfPollUserAnswers[] = $l;
		$l->setsfPollAnswer($this);
	}


	
	public function getsfPollUserAnswersJoinsfPoll($criteria = null, $con = null)
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

				$criteria->add(sfPollUserAnswerPeer::ANSWER_ID, $this->getId());

				$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelectJoinsfPoll($criteria, $con);
			}
		} else {
									
			$criteria->add(sfPollUserAnswerPeer::ANSWER_ID, $this->getId());

			if (!isset($this->lastsfPollUserAnswerCriteria) || !$this->lastsfPollUserAnswerCriteria->equals($criteria)) {
				$this->collsfPollUserAnswers = sfPollUserAnswerPeer::doSelectJoinsfPoll($criteria, $con);
			}
		}
		$this->lastsfPollUserAnswerCriteria = $criteria;

		return $this->collsfPollUserAnswers;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfPollAnswer:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfPollAnswer::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 