<div class="main-content">
  
  <h3><?=$friend->username?></h3>
  <hr/>

  <?php if(sizeof($messageList) > 0) { ?>
    <div class="row">
      <?php foreach ($messageList as $message) { ?>
        <div class="col-md-12" >
          <strong><?=$message->sender?></strong>
          <?=$message->message?>
        </div>      
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="row">
      <div class="col-md-12">
        No conversation found yet !
      </div>      
    </div>
  <?php }  ?>

  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <?=form_open('/members/post_message', '', array('reciever' => $friend->id))?>
      <textarea id="message-text" class="form-control" name="message"></textarea>
      <br/>
      <button class="btn btn-success pull-right" type="submit">Send</button>
      <?=form_close()?>
    </div>
  </div>
</div>
