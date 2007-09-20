<?php
/**
 * Subclass for representing a row from the 'sf_polls_answers' table.
 *
 * @package plugins.sfPropelPollsPlugin.lib.model
 */ 
class sfPollAnswer extends BasesfPollAnswer
{

  /**
   * Increments votes counting and saves the object
   * 
   * @return BasesfPollAnswer::save()
   */
  public function incrementVotesCount()
  {
    $this->setVotes($this->getVotes() + 1);
    return parent::save();
  }

}
