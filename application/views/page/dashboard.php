

<div class="main-content">

<!--   <?php if(sizeof($groups) > 0) { ?>
  <div class="row">
    <?php foreach ($groups as $i => $group) { ?>
    <div class="col-md-3">
      <div class="group-block">
        <h4> <?=$group->title?> </h4>
        <p> <?=$group->description?> </p>
        <?=anchor('/group/show/' . $group->id,
          "Details " . ($group->total_count == $group->read_count ?"":"<i class=\"glyphicon glyphicon-flash\"></i>"),
          array('class' => "btn btn-default"))?>
      </div>
    </div>
      <?php if($i % 4 == 3) { ?>
        <div class="clearfix"></div>
        <br/> 
      <?php }?>
    <?php } ?>
  </div>
  <?php } else { ?>
  <div style="text-align: center;">
    <h3>No groups found</h3>
  </div>
  <?php } ?> -->

  <div class="Grid">
  <?php foreach ($groups as $i => $group) { ?>
    <div class="Grid-cell">
      <h4> <?=$group->title?> </h4>
      <p> <?=$group->description?> </p>
      <?=anchor('/group/show/' . $group->id,
        "Details " . ($group->total_count == $group->read_count ?"":"<i class=\"glyphicon glyphicon-flash\"></i>"),
        array('class' => "btn btn-default"))?>
    </div>

    <?php if($i % 4 == 3) { ?>
    </div>
    <div class="Grid">
    <?php } ?>

  <?php } ?>

    <br/>
  </div>


https://Adiecha_HK@bitbucket.org/Adiecha_HK/invoice-app.git

git@bitbucket.org:Adiecha_HK/invoice-app.git

https://Adiecha_HK@bitbucket.org/Adiecha_HK/chat-app.git

git@bitbucket.org:Adiecha_HK/chat-app.git