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
$t = new lime_test(23, new lime_output_color());

try
{
  // Poll creation
  $poll = new sfPoll();
  $poll->setTitle('A test poll : Are you a man or a women ?');
  $poll->save();
  $a1 = $poll->addAnswer('Male');
  $a2 = $poll->addAnswer('Female');

  $t->ok(in_array('Male', $poll->getPossibleAnswers()), 'getPossibleAnswers() option 1 retrieved');
  $t->ok(in_array('Female', $poll->getPossibleAnswers()), 'getPossibleAnswers() option 2 retrieved');

  // Users vote (2 say 'Male', 3 say 'Female')
  $poll->addUserAnswer(1, $a1->getId());
  $poll->addUserAnswer(2, $a1->getId());
  $poll->addUserAnswer(3, $a2->getId());
  $poll->addUserAnswer(4, $a2->getId());
  $poll->addUserAnswer(5, $a2->getId());
  $t->is($poll->getCountUserAnswers(), 5, 'getCountUserAnswers() user votes count ok');

  // Checks users answers
  $t->is($poll->getUserAnswer(1)->getAnswerId(), $a1->getId(), 'getUserAnswer() for user 1 ok');
  $t->is($poll->getUserAnswer(2)->getAnswerId(), $a1->getId(), 'getUserAnswer() for user 2 ok');
  $t->is($poll->getUserAnswer(3)->getAnswerId(), $a2->getId(), 'getUserAnswer() for user 3 ok');
  $t->is($poll->getUserAnswer(4)->getAnswerId(), $a2->getId(), 'getUserAnswer() for user 4 ok');
  $t->is($poll->getUserAnswer(5)->getAnswerId(), $a2->getId(), 'getUserAnswer() for user 5 ok');

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
  $poll->addUserAnswer(6, $a1->getId());
  $poll->addUserAnswer(7, $a2->getId());
  $t->is($poll->getCountUserAnswers(), 7, 'getCountUserAnswers() user votes count ok');

  // New poll results
  $results = $poll->getResults();
  $male_results   = $results[$a1->getId()];
  $female_results = $results[$a2->getId()];

  $t->is($male_results['count'],   3, 'getResults() counts OK');
  $t->is($female_results['count'], 4, 'getResults() counts OK');

  $t->is(round($male_results['percent'], 2),   42.86, 'getResults() percent OK');
  $t->is(round($female_results['percent'], 2), 100 - 42.86, 'getResults() percent OK');

  // User PK=1 changes his vote
  $poll->addUserAnswer(1, $a2->getId());
  $t->is($poll->getUserAnswer(1)->getAnswerId(), $a2->getId(), 'getUserAnswer() for user 1 ok after he changed');
  $t->is($poll->getCountUserAnswers(), 7, 'getCountUserAnswers() user votes count still ok');

  // New poll results
  $results = $poll->getResults();
  $male_results   = $results[$a1->getId()];
  $female_results = $results[$a2->getId()];

  $t->is($male_results['count'],   2, 'getResults() counts OK');
  $t->is($female_results['count'], 5, 'getResults() counts OK');

  $t->is(round($male_results['percent'], 2),   28.57, 'getResults() percent OK');
  $t->is(round($female_results['percent'], 2), 71.43, 'getResults() percent OK');

}
catch (Exception $e)
{
  $t->fail('Exception thrown : ' . $e->getMessage());
}

// Clean test poll
$poll->delete();
