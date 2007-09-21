<?php echo input_hidden_tag('poll_id', $poll->getId()) ?>
<?php
$user_answer = $poll->getUserAnswer($user_id);
$user_answer_id = $user_answer ? $user_answer->getAnswerId() : NULL;
?>
<?php foreach ($poll->getAnswers() as $answer): ?>
  <p id="poll_<?php echo $poll->getId() ?>_answer_<?php echo $answer->getId() ?>">
    <?php $dom_id = 'choice_'.$poll->getId().'_'.$answer->getId() ?>
    <?php echo radiobutton_tag('answer_id', 
                               $answer->getId(), 
                               ($user_answer_id === $answer->getId()),
                               'id='.$dom_id) ?>
    <label for="<?php echo $dom_id ?>">
      <?php echo $answer->getName() ?>
    </label>
  </p>
<?php endforeach; ?>
<p>
  <?php echo submit_tag(__('Vote')) ?>
  <?php echo link_to('View results', 
                     '@sf_propel_polls_results?id='.$poll->getId()) ?>
</p>