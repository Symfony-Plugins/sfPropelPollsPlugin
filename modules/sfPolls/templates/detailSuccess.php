<?php use_helper('Text') ?>
<?php if (isset($poll)): ?>
<h3><?php echo $poll->getTitle() ?></h3>
<?php if ($poll->getDescription()): ?>
  <?php echo simple_format_text($poll->getDescription()) ?>
<?php endif; ?>

<?php echo form_tag('@sf_propel_polls_vote') ?>
  <?php include_partial('sfPolls/poll_form_elements', array('poll' => $poll)) ?>
</form>
<?php endif; ?>