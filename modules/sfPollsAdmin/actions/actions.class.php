<?php
/**
 * sfPollsAdmin actions
 * 
 * @package    plugins
 * @subpackage polls
 * @author     Nicolas Perriault <nperriault@gmail.com>
 **/
class sfPollsAdminActions extends autoSfPollsAdminActions 
{  
  
  /**
   * Displays a poll answer creation form through an ajax call
   * 
   **/
  public function executeAddAnswer()
  {
    $answer_text   = $this->getRequestParameter('answer_text');
    $answer_text   = $answer_text === 'null' ? NULL : $answer_text;
    $poll_id       = $this->getRequestParameter('poll_id');
    $poll          = sfPollPeer::retrieveByPK($poll_id);
    $answer_exists = sfPollAnswerPeer::exists($poll_id, $answer_text);
    $this->count_user_answers = $poll->getCountVotes();
    if ($poll && trim($answer_text) != '' && !$answer_exists)
    {
      $this->answer = $poll->addAnswer($answer_text);
    }
  }
  
  /**
   * Deletes a poll answer through an ajax call
   * 
   **/
  public function executeDelAnswer()
  {
    $answer_id = $this->getRequestParameter('answer_id');
    $answer    = sfPollAnswerPeer::retrieveByPK($answer_id);
    $this->forward404Unless($answer);
    $answer->delete();
    return sfView::NONE;
  }
  
  /**
   * Displays a poll answer edition result through an ajax call
   * 
   **/
  public function executeEditAnswer()
  {
    $answer_id = $this->getRequestParameter('answer_id');
    $answer_text = $this->getRequestParameter('answer_text');
    $answer = sfPollAnswerPeer::retrieveByPK($answer_id);
    if (!is_null($answer_text) && trim($answer_text) != '')
    {
      $answer->setName(trim($answer_text));
      $answer->save();
    }
    return $this->renderText($answer->getName());
  }
  
}
