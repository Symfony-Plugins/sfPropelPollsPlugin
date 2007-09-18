<?php use_helper('Text') ?>
<h3><?php echo $poll->getTitle() ?></h3>
<?php if ($poll->getDescription()): ?>
  <?php echo simple_format_text($poll->getDescription()) ?>
<?php endif; ?>
<?php foreach ($poll->getResults() as $answer_id => $answer_result): ?>
  <p>
    <?php echo $answer_result['name'] ?> : <?php echo $answer_result['percent'] ?>%
  </p>
<?php endforeach; ?>