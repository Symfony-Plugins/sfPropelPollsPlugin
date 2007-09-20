<?php
/**
 * sfPropelPollsPlugin components
 * 
 * @package plugins
 * @subpackage polls
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
    if (!$poll->getIsPublished())
    {
      throw new sfException('This poll is not published');
    }
    if (!$poll->getIsActive())
    {
      throw new sfException('Votes are closed on this poll');
    }
    $this->poll = $poll;
  }

}
