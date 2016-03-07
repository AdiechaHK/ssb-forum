
<div class="main-content">
    
  <?php if(sizeof($memberList) > 0) { ?>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Message</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($memberList as $i => $member) { ?>
      <tr>
        <td><?=$curr_skip + $i + 1?></td>
        <td><?=$member->username?>
          <?php if($member->total_count != $member->read_count) { ?>
          <i class='glyphicon glyphicon-flash'></i>
          (<?=$member->total_count - $member->read_count?>)
          <?php } ?>
        </td>
        <td>
          <?=anchor('/members/message/' . $member->id, "Messages", array('class' => "btn btn-default"))?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <div>
    <?=anchor('/members/mlist/' . ($curr_skip > 0 ? $curr_skip - PAGE_SIZE: 0), "Previous", array('class' => "btn btn-default"))?>
    <?=anchor('/members/mlist/' . ($curr_skip + PAGE_SIZE), "Next", array('class' => "btn btn-default pull-right"))?>
  </div>
  <?php } else { ?>
  <div style="text-align: center;">
    <h3>No one is there !</h3>
  </div>
  <?php } ?>
</div>
