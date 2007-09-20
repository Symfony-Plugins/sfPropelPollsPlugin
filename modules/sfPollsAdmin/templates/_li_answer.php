<?php use_helper('Javascript') ?>
<li id="a_<?php echo $answer->getId() ?>">
  <span id="a_<?php echo $answer->getId() ?>_text">
    <?php echo $answer->getName() ?>
  </span>
  [<?php echo link_to_remote('delete',
           array('url'     => 'sfPollsAdmin/delAnswer?answer_id='.$answer->getId(),
                 'confirm' => 'Are you sure?',
                 'success' => visual_effect('fade', 'a_'.$answer->getId()))) ?>]
  [<?php echo link_to_remote('edit',
             array('url'      => 'sfPollsAdmin/editAnswer?answer_id='.
                                 $answer->getId(),
                   'with'     => "'answer_text=' + escape(prompt('Enter answer text', '".str_replace("'", "\'", $answer->getName())."'))",
                   'update'   => 'a_'.$answer->getId().'_text',
                   'complete' => visual_effect('highlight', 'a_'.$answer->getId().'_text'))) ?>]
</li>