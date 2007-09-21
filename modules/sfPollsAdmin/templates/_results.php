<?php if (isset($sf_poll)): ?>
  <?php $count_votes = $sf_poll->getCountVotes() ?>
  <?php if ($count_votes > 0): ?>
    <table style="width:100%">
      <tr>
        <th><?php echo __('Choice') ?></th>
        <th><?php echo __('Result') ?></th>
      </tr>
    <?php foreach ($sf_poll->getResults() as $answer_id => $answer_result): ?>
      <?php $barw = $answer_result['percent'] == 0 ? 1: $answer_result['percent'] ?>
      <tr height="1em">
        <td><?php echo $answer_result['name'] ?></td>
        <td>
          <div style="background:blue;width:<?php echo $barw ?>px">&nbsp;</div>
          <?php echo $answer_result['percent'] ?>%
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
  <?php endif; ?>
<?php endif; ?>