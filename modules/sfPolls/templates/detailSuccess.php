<?php use_helper('Text', 'I18N') ?>
<?php if (isset($poll)): ?>
<h3><?php echo $poll->getTitle() ?></h3>
<?php if ($poll->getDescription()): ?>
  <?php echo simple_format_text($poll->getDescription()) ?>
<?php endif; ?>

<?php echo form_tag('@sf_propel_polls_vote') ?>
  <?php echo input_hidden_tag('poll_id', $poll->getId()) ?>
  <?php $user_answer_id = isset($user_answer) ? $user_answer->getAnswerId() : null ?>
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
</form>
<?php endif; ?>