<?php
/**
 * sfPropelPollsPlugin components
 * 
 * @author Nicolas Perriault <nperriault@gmail.com>
 */
class sfPollsComponents extends sfComponents 
{

  /**
   * Displays poll form
   * 
   * @throws sfException
   */
  public function executePoll_form()
  {
    if (!isset($this->poll_id))
    {
      throw new sfException('poll_id is missing');
    }
    $poll = sfPollPeer::retrieveByPK($this->poll_id);
    if (!$poll)
    {
      throw new sfException('Unable to retrieve poll object');
    }
    $this->poll = $poll;
  }

}
