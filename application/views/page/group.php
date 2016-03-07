
<div class="main-content">
  
  <div class="row">
    <div class="col-md-12">
      <?=anchor('/dashboard', "Back to group list.", array('class' => "btn btn-info"))?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h3><?=$group->title?></h3>
      <p><?=$group->description?></p>
    </div>  
  </div>

  <?php if(sizeof($groupPostList) > 0) { ?>

  <div class="row">
    <?php foreach ($groupPostList as $groupPost) { ?>
      <div class="col-md-12">
        <strong> <?=$groupPost->username?> </strong>
        <?=$groupPost->text?>
      </div>
    <?php } ?>
  </div>
  <?php } ?>

  <?php if(sizeof($groupPostList) == 0) { ?>
  <div class="row" data-ng-if="!groupPostList.length">
    <div class="col-md-12">
      No posts found for this group
    </div>
  </div>
  <?php } ?>

  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <?=form_open('/group/post', '', array('gid' => $group->id))?>

      <textarea id="post-text" class="form-control" name="text"></textarea>
      <br/>
      <button class="btn btn-success pull-right" type="submit">Post</button>
      <?=form_close()?>
    </div>
  </div>
</div>