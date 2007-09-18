<?php if (isset($answer)): ?>
<?php include_partial('sfPollsAdmin/li_answer',
                      array('answer'     => $answer,
                            'edit_links' => ($count_user_answers == 0))) ?>
<?php endif; ?>