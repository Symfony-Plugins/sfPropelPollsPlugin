<?php use_helper('Text', 'Javascript') ?>
<?php if (isset($poll)): ?>
<div id="cmp_poll_<?php echo $poll->getId() ?>">
  <h2><?php echo $poll->getTitle() ?></h2>
  <?php if ($poll->getDescription()): ?>
    <?php echo simple_format_text($poll->getDescription()) ?>
  <?php endif; ?>
  <?php echo form_remote_tag(array('url'    => '@sf_propel_polls_vote',
                                   'update' => 'cmp_poll_'.$poll->getId())) ?>
    <?php include_partial('sfPolls/poll_form_elements', array('poll'   => $poll)) ?>
  </form>
</div>
<?php endif; ?>