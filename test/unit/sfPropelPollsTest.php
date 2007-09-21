<?php
// initializes testing framework
$app = 'frontend';
$sf_root = dirname(__FILE__).'/../../../..';
require_once($sf_root.'/lib/symfony/vendor/lime/lime.php');
include($sf_root.'/test/bootstrap/functional.php');

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

// start tests
$t = new lime_test(26, new lime_output_color());

// Load plugin configuration
include(dirname(__FILE__).'/../../config/schemaConfig.php');
$user_class = $config['user_class'];

if (is_null($user_class) or !class_exists($user_class))
{
  throw new Exception('You did not provide a valid user_class parameter. See README.');
}

// Test users creation (we are in a test environment, eh ?)
$users = array();
try
{
  for ($i=1; $i<=7; $i++)
  {
    $u = new $user_class();
    $u->setUsername('TestUser'.$i);
    $u->save();
    $users[$i] = $u;
  }
}
catch (Exception $e)
{
  $t->fail($e->getMessage());
}

$user1_id = $users[1]->getId();
$user2_id = $users[2]->getId();
$user3_id = $users[3]->getId();
$user4_id = $users[4]->getId();
$user5_id = $users[5]->getId();
$user6_id = $users[6]->getId();
$user7_id = $users[7]->getId();

// Poll creation
$poll = new sfPoll();
$poll->setTitle('Are you a man or a women ?');
$poll->setDescription('A poll for testing purpose.');
$poll->setIsPublished(true);
$poll->setIsActive(true);
$poll->save();
$t->is($poll->getId() > 0, true, 'save() Poll created');

$a1 = $poll->addAnswer('Male');
$a2 = $poll->addAnswer('Female');
$t->ok(in_array('Male', $poll->getPossibleAnswers()), 'getPossibleAnswers() option 1 retrieved');
$t->ok(in_array('Female', $poll->getPossibleAnswers()), 'getPossibleAnswers() option 2 retrieved');

// Poll is deactivated. Can a user vote ?
$poll->setIsActive(false);
$poll->save();
$can_vote = true;
try
{
  $poll->addVote($a1->getId(), $user1_id);
}
catch (sfPropelPollsException $e)
{
  $can_vote = false;
}
$t->is($can_vote, false, 'addVote() User cannot vote on a deactivated poll');

// Reactivate poll
$poll->setIsActive(true);
$poll->save();

// Users vote (2 say 'Male', 3 say 'Female')
$poll->addVote($a1->getId(), $user1_id);
$t->is($poll->getUserAnswer($user1_id)->getId(), 
       $a1->getId(), 
       'getUserAnswer() user 1 has voted '.$poll->getUserAnswer($user1_id)->getName());

$poll->addVote($a1->getId(), $user2_id);
$t->is($poll->getUserAnswer($user2_id)->getId(), $a1->getId(), 'getUserAnswer() user 2 has voted '.$poll->getUserAnswer($user2_id)->getName());

$poll->addVote($a2->getId(), $user3_id);
$t->is($poll->getUserAnswer($user3_id)->getId(), $a2->getId(), 'getUserAnswer() user 3 has voted '.$poll->getUserAnswer($user3_id)->getName());

$poll->addVote($a2->getId(), $user4_id);
$t->is($poll->getUserAnswer($user4_id)->getId(), $a2->getId(), 'getUserAnswer() user 4 has voted '.$poll->getUserAnswer($user4_id)->getName());

$poll->addVote($a2->getId(), $user5_id);
$t->is($poll->getUserAnswer($user5_id)->getId(), $a2->getId(), 'getUserAnswer() user 5 has voted '.$poll->getUserAnswer($user5_id)->getName());

// Poll votes count
$t->is($poll->getCountVotes(), 5, 'getCountVotes() user votes count ok');

// Poll results
$results = $poll->getResults();
$male_results   = $results[$a1->getId()];
$female_results = $results[$a2->getId()];

$t->is($male_results['count'],      2, 'getResults() counts OK');
$t->is($female_results['count'],    3, 'getResults() counts OK');

$t->is($male_results['percent'],   40, 'getResults() percent OK');
$t->is($female_results['percent'], 60, 'getResults() percent OK');

// More users vote
// Users vote (1 says 'Male', 1 says 'Female')
$poll->addVote($a1->getId(), $user6_id);
$poll->addVote($a2->getId(), $user7_id);
$t->is($poll->getCountVotes(), 7, 'getCountVotes() user votes count ok');

// New poll results
$results = $poll->getResults();
$male_results   = $results[$a1->getId()];
$female_results = $results[$a2->getId()];

$t->is($male_results['count'],   3, 'getResults() counts OK');
$t->is($female_results['count'], 4, 'getResults() counts OK');

$t->is(round($male_results['percent'], 2),   42.86, 'getResults() percent OK');
$t->is(round($female_results['percent'], 2), 100 - 42.86, 'getResults() percent OK');

// User 1 try to revote
$revote_error = false;
try
{
  $poll->addVote($a2->getId(), $user1_id);
}
catch (sfPropelPollsException $e)
{
  $revote_error = true;
}
$t->is($revote_error, true, 'addVote() A user cannot revote');
$t->is($poll->getUserAnswer($user1_id)->getId(), $a1->getId(), 'getUserAnswer() for user 1 same after he tried to change');
$t->is($poll->getCountVotes(), 7, 'getCountVotes() user votes count still ok');

// New poll results
$results = $poll->getResults();
$male_results   = $results[$a1->getId()];
$female_results = $results[$a2->getId()];

$t->is($male_results['count'],   3, 'getResults() counts OK');
$t->is($female_results['count'], 4, 'getResults() counts OK');

$t->is(round($male_results['percent'], 2),   42.86, 'getResults() percent OK');
$t->is(round($female_results['percent'], 2), 100 - 42.86, 'getResults() percent OK');

// Clean test poll
$poll->delete();

// Delete test users, because we are clean people
foreach ($users as $user)
{
  $user->delete();
}  
