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
   * @return String
   **/
  public function __toString()
  {
    return $this->getTitle();
  }
  
  /**
   * Add a sfPollAnswer object related to current sfPoll object instance
   *
   * @param  string  $answer_text
   * @return sfPollAnswer
   * @throws sfPropelPollsException
   **/
  public function addAnswer($answer_text)
  {
    if ($this->isNew() or is_null($this->getId()))
    {
      throw new sfPropelPollsException('You cannot add an answer to an unsaved poll');
    }
    $answer = sfPollAnswerPeer::getOrCreate($this->getId(), $answer_text);
    $answer->setsfPoll($this);
    $answer->setName($answer_text);
    $answer->save();
    return $answer;
  }
  
  /**
   * Add sfPollAnswer objects related to current sfPoll object instance from 
   * an array of answer text strings
   *
   * @param  array  $answers
   * @throws sfPropelPollsException
   **/
  public function addAnswers($answers)
  {
    if ($this->isNew() or is_null($this->getId()))
    {
      throw new sfPropelPollsException('You cannot add an answer to an unsaved poll');
    }
    foreach ($answers as $answer_text)
    {
      $this->addAnswer(trim($answer_text));
    }
  }

  /**
   * Add a sfPollUserAnswer object related to current sfPoll object instance
   * 
   * @param  int     $answer_id   sfPollAnswer PK
   * @param  int     $user_id     User PK (optional)
   * @throws sfPropelPollsException
   **/
  public function addVote($answer_id, $user_id = null)
  {
    if ($this->isNew() or is_null($this->getId()))
    {
      throw new sfPropelPollsException('You cannot add a user answer to an unsaved poll');
    }
    
    if ($this->getIsPublished() !== true)
    {
      throw new sfPropelPollsException('This poll is not currently published');
    }
    
    if ($this->getIsActive() !== true)
    {
      throw new sfPropelPollsException('Votes on this poll are closed');
    }

    $answer = sfPollAnswerPeer::retrieveByPK($answer_id);
    if (!$answer)
    {
      throw new sfPropelPollsException('Unable to retrieve answer associated to poll');
    }

    if ($answer->getPollId() !== $this->getId())
    {
      throw new sfPropelPollsException('The answer provided is not associated with current poll');
    }

    if (!is_null($user_id))
    {
      if ($this->hasUserVoted($user_id))
      {
        throw new sfPropelPollsException('User has already voted for this poll');
      }
      else
      {
        $user_answer = new sfPollUserAnswer();
        $user_answer->setPollId($this->getId());
        $user_answer->setAnswerId($answer_id);
        $user_answer->setUserId($user_id);
        $user_answer->save();
        $answer->incrementVotesCount();
      }
    }
    else
    {
      // We apply the vote without any check in db
      // I guess you'll use a cookie in your controller to avoid cheating
      $answer->incrementVotesCount();
    }
  }

  /**
   * Retrieves total number of votes
   *
   * @return int
   * @throws sfPropelPollsException
   **/
  public function getCountVotes()
  {
    $answers = $this->getAnswers();
    if (is_null($answers) or count($answers) === 0)
    {
      return 0;
    }
    $count_votes = 0;
    foreach ($answers as $answer)
    {
      $count_votes += $answer->getVotes();
    }
    return $count_votes;
  }
  
  /**
   * Retrieves poll answers
   * 
   * @return array of sfPollAnswer objects
   */
  public function getAnswers()
  {
    $c = new Criteria();
    $c->add(sfPollAnswerPeer::POLL_ID, $this->getId());
    return sfPollAnswerPeer::doSelect($c);
  }

  /**
   * Retrieves all possible answers strings for this poll
   *
   * @return array
   **/
  public function getPossibleAnswers()
  {
    $answers = $this->getAnswers();
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
    $results = array();
    $total = $this->getCountVotes();
    foreach ($this->getAnswers() as $answer)
    {
      $votes = $answer->getVotes();
      $percent = $total > 0 ? $votes * 100 / $total : 0;
      $percent = round($percent, sfConfig::get('app_sfPolls_percent_precision', 2));
      $results[$answer->getId()] = array('name'    => $answer->getName(),
                                         'count'   => $votes,
                                         'percent' => $percent);
    }
    return $results;
  }
  
  /**
   * Retrieves user answer from a user PK
   * 
   * @param  int  $user_id  User PK
   * @return sfPollAnswer
   */  
  public function getUserAnswer($user_id=null)
  {
    if (is_null($user_id))
    {
      return null;
    }
    $c = new Criteria();
    $c->addJoin(sfPollUserAnswerPeer::ANSWER_ID, sfPollAnswerPeer::ID);
    $c->add(sfPollUserAnswerPeer::USER_ID, $user_id);
    $c->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());
    return sfPollAnswerPeer::doSelectOne($c);
  }
  
  /**
   * Checks if a user has already voted
   * 
   * @param  int  $user_id
   * @return boolean
   * @throws sfPropelPollsException
   */
  public function hasUserVoted($user_id=null)
  {
    if (is_null($user_id))
    {
      return false;
    }
    $c = new Criteria();
    $c->add(sfPollUserAnswerPeer::POLL_ID, $this->getId());
    $c->add(sfPollUserAnswerPeer::USER_ID, $user_id);
    return (sfPollUserAnswerPeer::doCount($c) > 0);
  }
  
}
