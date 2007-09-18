<?php
/**
 * sfPoll base actions
 * 
 * @author Nicolas Perriault <nperriault@gmail.com>
 **/
class BasesfPollsActions extends sfActions 
{

  /**
   * Module index
   * 
   **/
  public function executeIndex()
  {
    $this->forward('sfPolls', 'list');
  }
  
  /**
   * Poll detail view
   * 
   **/
  public function executeDetail()
  {
    $poll_id = $this->getRequestParameter('id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $this->forward404Unless($poll);
    $this->poll = $poll;
  }
  
  /**
   * Polls list
   * 
   **/
  public function executeList()
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(sfPollPeer::CREATED_AT);
    $this->polls = sfPollPeer::doSelect($c);
  }
  
  /**
   * Poll results
   * 
   **/
  public function executeResults()
  {
    $poll_id = $this->getRequestParameter('id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $this->forward404Unless($poll);
    $this->poll = $poll;
  }

  /**
   * Make a user voting for a poll
   * 
   **/
  public function executeVote()
  {
    $poll_id = $this->getRequestParameter('poll_id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $answer_id = $this->getRequestParameter('answer_id');
    $answer = sfPollAnswerPeer::retrieveByPK($answer_id);
    $this->forward404Unless($poll && $answer);
    $poll->addUserAnswer(null, $answer->getId(), $_SERVER['REMOTE_ADDR']);
    $this->setFlash('notice', 'Thanks for your vote');
    $this->redirect('@sf_propel_polls_results?id='.$poll_id);
  }

}
