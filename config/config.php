<?php
// Adding polls routes if option has not been disabled in app.yml
// @see http://www.symfony-project.com/book/trunk/09-Links-and-the-Routing-System#Creating%20Rules%20Without%20routing.yml
if (sfConfig::get('app_sfPropelPollsPlugin_routes_register', true) 
    && in_array('sfPolls', sfConfig::get('sf_enabled_modules')))
{
  $r = sfRouting::getInstance();
  
  # Polls list route
  $r->prependRoute('sf_propel_polls_list', 
                   '/polls',    
                   array('module' => 'sfPolls', 'action' => 'list'),
                   array('id' => '\d+'));
  
  # Poll detail (form) route
  $r->prependRoute('sf_propel_polls_detail', 
                   '/poll_detail/:id',  
                   array('module' => 'sfPolls', 'action' => 'detail'),
                   array('id' => '\d+'));
                   
  # Poll results route
  $r->prependRoute('sf_propel_polls_results', 
                   '/poll_results/:id', 
                   array('module' => 'sfPolls', 'action' => 'results'),
                   array('id' => '\d+'));
                   
  # Poll vote route
  $r->prependRoute('sf_propel_polls_vote', 
                   '/poll_vote',    
                   array('module' => 'sfPolls', 'action' => 'vote'),
                   array('id' => '\d+'));
}
