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
   * or an IP Address
   *
   * @param  int     $poll_id
   * @param  int     $user_id
   * @param  string  IP address (optional)
   * @return sfPollUserAnswer
   **/
  public static function getOrCreate($poll_id, $user_id, $ip_address=NULL)
  {
    $c = new Criteria();
    
    if (!is_int($poll_id) or $poll_id == 0)
    {
      throw new PropelException('A poll id must be provided');
    }
    else
    {
      $c->add(self::POLL_ID, $poll_id);
    }

    if ($ip_address && preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $ip_address))
    {
      $c->add(self::IP_ADDRESS, $ip_address);
    }
    else
    {
      $c->add(self::USER_ID, $user_id);
    }
    $a = self::doSelectOne($c);
    return is_null($a) ? new sfPollUserAnswer() : $a;
  }

}
