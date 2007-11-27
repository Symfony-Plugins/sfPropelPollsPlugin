<?php use_helper('Text', 'I18N') ?>
<h2><?php echo __('Polls list') ?></h2>
<?php if (isset($polls) && count($polls) > 0): ?>
<dl id="polls_list">
  <?php foreach ($polls as $poll): ?>
  <dt>
    <p>
      <?php echo link_to($poll->getTitle(), 
                         '@sf_propel_polls_detail?id='.$poll->getId()) ?>
    </p>
  </dt>
  <?php if ($poll->getDescription()): ?>
  <dd>
    <p><?php echo simple_format_text($poll->getDescription()) ?></p>
  </dd>
  <?php endif; ?>
  <dd>
    <p><?php echo link_to('View results', 
                          '@sf_propel_polls_results?id='.$poll->getId()) ?></p>
  </dd>
  <?php endforeach; ?>
</dl>
<?php endif; ?>