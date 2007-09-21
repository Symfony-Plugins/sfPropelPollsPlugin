<?php use_helper('Text', 'Poll') ?>
<h3><?php echo $poll->getTitle() ?></h3>
<?php if ($poll->getDescription()): ?>
  <?php echo simple_format_text($poll->getDescription()) ?>
<?php endif; ?>
<?php if ($poll->getIsActive() !== true): ?>
  <p><?php echo __('Votes for this poll are closed') ?>.</p>
<?php endif; ?>
<?php if (isset($poll_results) && count($poll_results) > 0): ?>
<ol class="sf_poll_results">
<?php foreach ($poll_results as $answer_id => $answer_result): ?>
  <li><?php echo $answer_result['name'] ?>: 
    <strong style="border-width:<?php echo poll_get_bar_width($answer_result['percent']) ?>px;">
      <?php echo $answer_result['percent'] ?>%</strong>
  </li>
<?php endforeach; ?>
</ol>
<?php else: ?>
<p><?php echo __('This poll has no available answers to show the results for')?>.</p>
<?php endif; ?>