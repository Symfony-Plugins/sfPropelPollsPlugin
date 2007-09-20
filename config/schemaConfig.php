<?php
// Default values
$config = array(
  'connection'                => 'propel',
  'user_table'                => 'sf_guard_user',
  'user_id'                   => 'id',
  'user_class'                => 'sfGuardUser',
  'polls_table'               => 'sf_polls',
  'polls_answers_table'       => 'sf_polls_answers',
  'polls_users_answers_table' => 'sf_polls_users_answers',
);

// Check custom project values
if (is_readable($config_file = sfConfig::get('sf_config_dir').'/sfPropelPollsPlugin.yml'))
{
  $user_config = sfYaml::load($config_file);
  if(isset($user_config['schema']))
  {
    $config = array_merge($config, $user_config['schema']);
  }
}

