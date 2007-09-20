<?php
/**
 * sfPropelPolls exception class
 * 
 * @package plugins
 * @subpackage polls
 * @author Nicolas Perriault
 */
class sfPropelPollsException extends sfException
{

  /**
   * Class constructor.
   *
   * @param string The error message
   * @param int    The error code
   */
  public function __construct($message = null, $code = 0)
  {
    $this->setName('sfPropelPollsException');
    parent::__construct(sprintf('%s: %s', $this->getName(), $message), $code);
  }
  
}
