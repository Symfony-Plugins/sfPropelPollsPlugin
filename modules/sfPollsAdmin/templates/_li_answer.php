<?php use_helper('Javascript') ?>
<li id="a_<?php echo $answer->getId() ?>"><?php echo $answer->getName() ?>
<?php if ($edit_links): ?>
  [<?php echo link_to_remote('delete',
           array('url'     => 'sfPollsAdmin/delAnswer?answer_id='.$answer->getId(),
                 'success' => visual_effect('fade', 'a_'.$answer->getId()))) ?>]

<?php endif; ?>
</li>