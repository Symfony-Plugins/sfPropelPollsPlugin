<?php


abstract class BasesfPollUserAnswer extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $poll_id;


	
	protected $answer_id;


	
	protected $user_id;


	
	protected $ip_address;


	
	protected $created_at;

	
	protected $asfPoll;

	
	protected $asfPollAnswer;

	
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

	
	public function getAnswerId()
	{

		return $this->answer_id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getIpAddress()
	{

		return $this->ip_address;
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
			$this->modifiedColumns[] = sfPollUserAnswerPeer::ID;
		}

	} 
	
	public function setPollId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->poll_id !== $v) {
			$this->poll_id = $v;
			$this->modifiedColumns[] = sfPollUserAnswerPeer::POLL_ID;
		}

		if ($this->asfPoll !== null && $this->asfPoll->getId() !== $v) {
			$this->asfPoll = null;
		}

	} 
	
	public function setAnswerId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->answer_id !== $v) {
			$this->answer_id = $v;
			$this->modifiedColumns[] = sfPollUserAnswerPeer::ANSWER_ID;
		}

		if ($this->asfPollAnswer !== null && $this->asfPollAnswer->getId() !== $v) {
			$this->asfPollAnswer = null;
		}

	} 
	
	public function setUserId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = sfPollUserAnswerPeer::USER_ID;
		}

	} 
	
	public function setIpAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ip_address !== $v) {
			$this->ip_address = $v;
			$this->modifiedColumns[] = sfPollUserAnswerPeer::IP_ADDRESS;
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
			$this->modifiedColumns[] = sfPollUserAnswerPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->poll_id = $rs->getInt($startcol + 1);

			$this->answer_id = $rs->getInt($startcol + 2);

			$this->user_id = $rs->getInt($startcol + 3);

			$this->ip_address = $rs->getString($startcol + 4);

			$this->created_at = $rs->getTimestamp($startcol + 5, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfPollUserAnswer object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollUserAnswer:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfPollUserAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfPollUserAnswerPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfPollUserAnswer:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfPollUserAnswer:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfPollUserAnswerPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfPollUserAnswerPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfPollUserAnswer:save:post') as $callable)
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

			if ($this->asfPollAnswer !== null) {
				if ($this->asfPollAnswer->isModified()) {
					$affectedRows += $this->asfPollAnswer->save($con);
				}
				$this->setsfPollAnswer($this->asfPollAnswer);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfPollUserAnswerPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfPollUserAnswerPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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

			if ($this->asfPollAnswer !== null) {
				if (!$this->asfPollAnswer->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfPollAnswer->getValidationFailures());
				}
			}


			if (($retval = sfPollUserAnswerPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfPollUserAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getAnswerId();
				break;
			case 3:
				return $this->getUserId();
				break;
			case 4:
				return $this->getIpAddress();
				break;
			case 5:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfPollUserAnswerPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPollId(),
			$keys[2] => $this->getAnswerId(),
			$keys[3] => $this->getUserId(),
			$keys[4] => $this->getIpAddress(),
			$keys[5] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfPollUserAnswerPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setAnswerId($value);
				break;
			case 3:
				$this->setUserId($value);
				break;
			case 4:
				$this->setIpAddress($value);
				break;
			case 5:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfPollUserAnswerPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPollId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAnswerId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIpAddress($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfPollUserAnswerPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfPollUserAnswerPeer::ID)) $criteria->add(sfPollUserAnswerPeer::ID, $this->id);
		if ($this->isColumnModified(sfPollUserAnswerPeer::POLL_ID)) $criteria->add(sfPollUserAnswerPeer::POLL_ID, $this->poll_id);
		if ($this->isColumnModified(sfPollUserAnswerPeer::ANSWER_ID)) $criteria->add(sfPollUserAnswerPeer::ANSWER_ID, $this->answer_id);
		if ($this->isColumnModified(sfPollUserAnswerPeer::USER_ID)) $criteria->add(sfPollUserAnswerPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(sfPollUserAnswerPeer::IP_ADDRESS)) $criteria->add(sfPollUserAnswerPeer::IP_ADDRESS, $this->ip_address);
		if ($this->isColumnModified(sfPollUserAnswerPeer::CREATED_AT)) $criteria->add(sfPollUserAnswerPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfPollUserAnswerPeer::DATABASE_NAME);

		$criteria->add(sfPollUserAnswerPeer::ID, $this->id);

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

		$copyObj->setAnswerId($this->answer_id);

		$copyObj->setUserId($this->user_id);

		$copyObj->setIpAddress($this->ip_address);

		$copyObj->setCreatedAt($this->created_at);


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
			self::$peer = new sfPollUserAnswerPeer();
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

	
	public function setsfPollAnswer($v)
	{


		if ($v === null) {
			$this->setAnswerId(NULL);
		} else {
			$this->setAnswerId($v->getId());
		}


		$this->asfPollAnswer = $v;
	}


	
	public function getsfPollAnswer($con = null)
	{
				include_once 'plugins/sfPropelPollsPlugin/lib/model/om/BasesfPollAnswerPeer.php';

		if ($this->asfPollAnswer === null && ($this->answer_id !== null)) {

			$this->asfPollAnswer = sfPollAnswerPeer::retrieveByPK($this->answer_id, $con);

			
		}
		return $this->asfPollAnswer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfPollUserAnswer:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfPollUserAnswer::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 