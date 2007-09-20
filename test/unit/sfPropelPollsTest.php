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
$t = new lime_test(24, new lime_output_color());

// test members retrieval (ugly method inside)
$c = new Criteria();
$c->setLimit(7);
$users = MemberPeer::doSelect($c);
$i = 1;
foreach ($users as $u)
{
  eval("\$user$i = ".$u->getId().";");
  $i++;
}

// Poll creation
$poll = new sfPoll();
$poll->setTitle('A test poll : Are you a man or a women ?');
$poll->setIsPublished(true);
$poll->setIsActive(true);
$poll->save();
$a1 = $poll->addAnswer('Male');
$a2 = $poll->addAnswer('Female');

$t->ok(in_array('Male', $poll->getPossibleAnswers()), 'getPossibleAnswers() option 1 retrieved');
$t->ok(in_array('Female', $poll->getPossibleAnswers()), 'getPossibleAnswers() option 2 retrieved');

// Users vote (2 say 'Male', 3 say 'Female')
$poll->addVote($a1->getId(), $user1);
$poll->addVote($a1->getId(), $user2);
$poll->addVote($a2->getId(), $user3);
$poll->addVote($a2->getId(), $user4);
$poll->addVote($a2->getId(), $user5);
$t->is($poll->getCountVotes(), 5, 'getCountVotes() user votes count ok');

// Checks users answers
$t->is($poll->getUserAnswer($user1)->getId(), $a1->getId(), 'getUserAnswer() user 1 has voted '.$poll->getUserAnswer($user1)->getName());
$t->is($poll->getUserAnswer($user2)->getId(), $a1->getId(), 'getUserAnswer() user 2 has voted '.$poll->getUserAnswer($user2)->getName());
$t->is($poll->getUserAnswer($user3)->getId(), $a2->getId(), 'getUserAnswer() user 3 has voted '.$poll->getUserAnswer($user3)->getName());
$t->is($poll->getUserAnswer($user4)->getId(), $a2->getId(), 'getUserAnswer() user 4 has voted '.$poll->getUserAnswer($user4)->getName());
$t->is($poll->getUserAnswer($user5)->getId(), $a2->getId(), 'getUserAnswer() user 5 has voted '.$poll->getUserAnswer($user5)->getName());

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
$poll->addVote($a1->getId(), $user6);
$poll->addVote($a2->getId(), $user7);
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
  $poll->addVote($a2->getId(), $user1);
}
catch (sfPropelPollsException $e)
{
  $revote_error = true;
}
$t->is($revote_error, true, 'addVote() A user cannot revote');
$t->is($poll->getUserAnswer($user1)->getId(), $a1->getId(), 'getUserAnswer() for user 1 same after he tried to change');
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
