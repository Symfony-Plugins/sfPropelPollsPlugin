<?php
/**
 * Subclass for performing query and update operations on the 'sf_polls_answers' table.
 *
 * @package plugins.sfPropelPollsPlugin.lib.model
 */ 
class sfPollAnswerPeer extends BasesfPollAnswerPeer
{

  /**
   * Checks if an answer already exists for a given poll
   * 
   * @param  int     $poll_id
   * @param  string  $answer_text
   * @return boolean
   **/
  public static function exists($poll_id, $answer_text)
  {
    $c = new Criteria();
    $c->add(self::POLL_ID, $poll_id);
    $c->add(self::NAME, $answer_text);
    return (self::doCount($c) > 0);
  }
  
  /**
   * Retrieves or create an answer for a given poll
   * 
   * @param  int     $poll_id
   * @param  string  $answer_text
   * @return sfPollAnswer
   **/
  public static function getOrCreate($poll_id, $answer_text)
  {
    $c = new Criteria();
    $c->add(self::POLL_ID, $poll_id);
    $c->add(self::NAME, $answer_text);
    $a = self::doSelectOne($c);
    return $a ? $a : new sfPollAnswer();
  }

}
