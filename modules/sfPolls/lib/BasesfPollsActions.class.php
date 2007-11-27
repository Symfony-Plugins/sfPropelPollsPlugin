<?php
/**
 * sfPoll base actions
 * 
 * @package plugins
 * @subpackage polls
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
    $this->forward404Unless($poll, 'Unable to retrieve poll id='.$poll_id);
    
    // Here we check if current poll is currently published
    $this->forward404Unless($poll->getIsPublished() === true, 
                            'Poll is not currently published');
    
    // Here we check if current poll is active for voting
    if ($poll->getIsActive() === false)
    {
      $this->redirect('@sf_propel_polls_results?id='.$poll->getId());
    }
    
    // Here we check if a user has already voted for this poll
    // If so, we redirect him to the results view
    $user_id = sfPropelPollsToolkit::getUserPK();
    $cookie_name = 'poll'.$poll->getId();
    if (!is_null($this->getRequest()->getCookie($cookie_name)) 
        or $poll->hasUserVoted($user_id))
    {
      $this->redirect('@sf_propel_polls_results?id='.$poll->getId());
    }
    
    $this->poll = $poll;
    $this->user_answer = $poll->getUserAnswer(sfPropelPollsToolkit::getUserPK());
  }
  
  /**
   * Polls list
   * 
   **/
  public function executeList()
  {
    $c = new Criteria();
    $c->add(sfPollPeer::IS_PUBLISHED, true);
    $c->addDescendingOrderByColumn(sfPollPeer::CREATED_AT);
    $this->polls = sfPollPeer::doSelect($c);
  }
  
  /**
   * This method is executed before every action. Here we load the I18N helper
   * if it is not enabled in settings.yml. 
   * 
   */
  public function preExecute()
  {
    $loaded_helpers = sfConfig::get('sf_standard_helpers', array());
    if (!in_array('I18N', $loaded_helpers))
    {
      sfLoader::loadHelpers('I18N');
    }
    return parent::preExecute();
  }
  
  /**
   * Poll results
   * 
   **/
  public function executeResults()
  {
    $poll_id = $this->getRequestParameter('id');
    $poll = sfPollPeer::retrieveByPK($poll_id);
    $this->forward404Unless($poll && $poll->getIsPublished(), 
                            'Unexistant or unpublished poll #'.$poll_id);
    $this->poll = $poll;
    $this->poll_results = $poll->getResults();
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
    
    if (is_null($answer_id)) // user has forgotten to check a vote option
    {
      $this->setFlash('notice', sfContext::getInstance()->getI18N()->__('You must check a vote option'));
      $this->redirect('@sf_propel_polls_detail?id='.$poll->getId());
    }
    
    $answer = sfPollAnswerPeer::retrieveByPK($answer_id);
    $this->forward404Unless($poll, 'Unable to retrieve poll id='.$poll_id);
    $this->forward404Unless($answer, 'Unable to retrieve answer id='.$answer_id);
    
    // Add vote for current user
    $user_id = sfPropelPollsToolkit::getUserPK();
    $cookie_name = 'poll'.$poll->getId();
    if (!is_null($this->getRequest()->getCookie($cookie_name)) 
        or $poll->hasUserVoted($user_id))
    {
      $this->setFlash('notice', sfContext::getInstance()->getI18N()->__('You have already voted for this poll'));
      $this->redirect('@sf_propel_polls_detail?id='.$poll->getId());
    }
    else
    {
      // Cookie expires in 10 years (yeah, ten)
      $cookie_expires = date('Y-m-d H:i:s', time() + (86400 * 365 * 10));
      $this->getResponse()->setCookie($cookie_name, $answer->getId(), $cookie_expires);
    }
    
    try
    {
      $poll->addVote($answer->getId(), $user_id);
      $message = sfContext::getInstance()->getI18N()->__('Thanks for your vote');
    }
    catch (Exception $e)
    {
      $message = sfContext::getInstance()->getI18N()->__('Something went wrong, we were unable to store your vote.');
      sfLogger::getInstance()->err('Polling error: '.$e->getMessage());
    }
    
    // Redirect with message
    $this->setFlash('notice', $message);
    $this->redirect('@sf_propel_polls_results?id='.$poll->getId());
  }

}
