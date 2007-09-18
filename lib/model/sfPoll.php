<?php
/**
 * Subclass for representing a row from the 'sf_polls' table.
 *
 * @package plugins.sfPropelPollsPlugin.lib.model
 */
class sfPoll extends BasesfPoll
{

  /**
   * Add a sfPollAnswer object related to current sfPoll object instance
   *
   * @param  string  $answer_text
   * @return sfPollAnswer
   * @throws PropelException
   **/
  public function addAnswer($answer_text)
  {
    if ($this->isNew() or is_null($this->getId()))
    {
      throw new PropelException('You cannot add an answer to an unsaved poll');
    }
    $answer = sfPollAnswerPeer::getOrCreate($this->getId(), $answer_text);
    $answer->setsfPoll($this);
    $answer->setName($answer_text);
    $answer->save();
    return $answer;
  }

  /**
   * Add a sfPollUserAnswer object related to current sfPoll object instance
   *
   * @param  int     $user_id     Typically an integer representing a User PK
   * @param  int     $answer_id   sfPollAnswer PK
   * @param  string  $ip_address  IP address (optionnal)
   * @return sfPollUserAnswer
   * @throws PropelException
   **/
  public function addUserAnswer($user_id, $answer_id, $ip_address=NULL)
  {
    if ($this->isNew() or is_null($this->getId()))
    {
      throw new PropelException('You cannot add a user answer to an unsaved poll');
    }

    $answer = sfPollAnswerPeer::retrieveByPK($answer_id);
    if (!$answer)
    {
      throw new PropelException('Unable to retrieve answer associated to poll');
    }

    if ($answer->getPollId() !== $this->getId())
    {
      throw new PropelException('The answer provided is not associated with current poll');
    }

    # Checks if user has already voted
    $user_answer = sfPollUserAnswerPeer::getOrCreate($this->getId(), $user_id, $ip_address);
    $user_answer->setPollId($this->getId());
    $user_answer->setAnswerId($answer_id);
    $user_answer->setUserId($user_id);
    $user_answer->setIpAddress($ip_address);
    $user_answer->save();
    return $user_answer;
  }

  /**
   * Proxy method for countsfPollUserAnswers to use through admin generator
   *
   * @return int
   **/
  public function getCountUserAnswers()
  {
    return $this->countsfPollUserAnswers();
  }

  /**
   * Retrieves all possible answers strings for this poll
   *
   * @return array
   **/
  public function getPossibleAnswers()
  {
    $answers = $this->getsfPollAnswers();
    $results = array();
    foreach ($answers as $answer)
    {
      $results[] = $answer->getName();
    }
    return $results;
  }

  /**
   * Retrieves poll results
   *
   * @return array
   **/
  public function getResults()
  {
    $c = new Criteria();
    $c->add(sfPollAnswerPeer::POLL_ID, $this->getId());
    $c->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);
    $c->clearSelectColumns();
    $c->addSelectColumn(sfPollAnswerPeer::ID);
    $c->addSelectColumn(sfPollAnswerPeer::NAME);
    $c->addAsColumn('count_votes', 'COUNT('.sfPollUserAnswerPeer::ID.')');
    $c->addAsColumn('total_votes', '(SELECT COUNT('.sfPollUserAnswerPeer::ID.') FROM '.sfPollUserAnswerPeer::TABLE_NAME.' WHERE '.sfPollUserAnswerPeer::POLL_ID.'='.$this->getId().')');
    $c->addGroupByColumn(sfPollUserAnswerPeer::ANSWER_ID);
    $rs = sfPollAnswerPeer::doSelectRS($c);
    $results = array();
    while ($rs->next())
    {
      $count   = $rs->getString(3);
      $total   = $rs->getString(4);
      if (!$total)
      {
        break; // Avoid division by zero
      }
      $id = $rs->getString(1);
      $percent = $count * 100 / $total;
      $results[$id] = array('name'    => $rs->getString(2),
                            'count'   => $count,
                            'percent' => $percent);
    }
    foreach ($this->getsfPollAnswers() as $answer)
    {
      if (!array_key_exists($answer->getId(), $results))
      {
        $results[$answer->getId()] = array('name'    => $answer->getName(),
                                           'count'   => 0,
                                           'percent' => 0);
      }
    }
    return $results;
  }

  /**
   * Get the answer provided by an user from its PK or IP address
   *
   * @param  int     $user_id
   * @param  string  $ip_address (optional)
   * @return sfPollUserAnswer or NULL
   **/
  public function getUserAnswer($user_id, $ip_address=NULL)
  {
    $c = new Criteria();
    if ($ip_address)
    {
      $c->add(sfPollUserAnswerPeer::IP_ADDRESS, $ip_address);
    }
    else
    {
      $c->add(sfPollUserAnswerPeer::USER_ID, $user_id);
    }
    $c->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());
    return sfPollUserAnswerPeer::doSelectOne($c);
  }

}
