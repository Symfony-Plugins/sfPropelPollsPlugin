<?php if (isset($sf_poll) && !$sf_poll->isNew()): ?>
  <h3><?php echo __('Answers list') ?></h3>
  <?php $answers = $sf_poll->getAnswers() ?>
  <ul id="answers">
  <?php foreach ($answers as $answer): ?>
    <?php include_partial('sfPollsAdmin/li_answer', array('answer' => $answer)) ?>
  <?php endforeach; ?>
  </ul>
  <?php if (count($answers) == 0): ?>
    <p><?php echo __('No answer for this poll yet') ?>.</p>
  <?php endif; ?>
  <?php echo button_to_remote(__('Add a possible answer to this poll'),
             array('url'      => 'sfPollsAdmin/addAnswer?poll_id='.
                                 $sf_poll->getId(),
                   'with'     => "'answer_text=' + escape(prompt('".__('Enter answer text')."'))",
                   'update'   => 'answers',
                   'position' => 'bottom',
                   'complete' => visual_effect('highlight', 'answers'))) ?>

<?php else: ?>
  <p><?php echo __('Please save your poll first') ?>.</p>
<?php endif; ?>