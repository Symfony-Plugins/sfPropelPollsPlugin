<?php if (isset($sf_poll) && !$sf_poll->isNew()): ?>
  <?php $count_user_answers = $sf_poll->getCountVotes() ?>
  <h3>Poll results</h3>
  <?php if ($count_user_answers > 0): ?>
    <table style="width:100%">
      <tr>
        <th>Choice</th>
        <th>Result</th>
      </tr>
    <?php foreach ($sf_poll->getResults() as $answer_id => $answer_result): ?>
      <tr>
        <td><?php echo $answer_result['name'] ?></td>
        <td>
          <div style="background:blue;width:<?php echo $answer_result['percent'] ?>px">&nbsp;</div>
          <?php echo $answer_result['percent'] ?>%
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  <?php endif; ?>
  
  <h3>Answers list</h3>
  <?php $answers = $sf_poll->getAnswers() ?>
  <ul id="answers">
  <?php foreach ($answers as $answer): ?>
    <?php include_partial('sfPollsAdmin/li_answer', array('answer' => $answer)) ?>
  <?php endforeach; ?>
  </ul>
  <?php if (count($answers) == 0): ?>
    <p>No answer for this poll yet.</p>
  <?php endif; ?>
  <?php echo button_to_remote('Add a possible answer to this poll',
             array('url'      => 'sfPollsAdmin/addAnswer?poll_id='.
                                 $sf_poll->getId(),
                   'with'     => "'answer_text=' + escape(prompt('Enter answer text'))",
                   'update'   => 'answers',
                   'position' => 'bottom',
                   'complete' => visual_effect('highlight', 'answers'))) ?>

<?php else: ?>
  <p>Please save your poll first</p>
<?php endif; ?>