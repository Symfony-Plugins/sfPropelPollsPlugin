<?php
/**
 * Subclass for performing query and update operations on the 'sf_polls_users_answers' table.
 *
 * @package plugins.sfPropelPollsPlugin.lib.model
 */
class sfPollUserAnswerPeer extends BasesfPollUserAnswerPeer
{

  /**
   * Get or create a new sfPollUserAnswer regarding a poll id and a user PK
   *
   * @param  int     $poll_id  Poll PK
   * @param  int     $user_id  User PK
   * @return sfPollUserAnswer
   **/
  public static function getOrCreate($poll_id, $user_id)
  {
    if (!is_int($poll_id) or $poll_id == 0)
    {
      throw new PropelException('A poll id must be provided');
    }
    
    if (!is_int($user_id) or $user_id == 0)
    {
      throw new PropelException('A user id must be provided');
    }
    
    $c = new Criteria();
    $c->add(self::POLL_ID, $poll_id);
    $c->add(self::USER_ID, $user_id);
    $a = self::doSelectOne($c);
    return is_null($a) ? new sfPollUserAnswer() : $a;
  }

}
