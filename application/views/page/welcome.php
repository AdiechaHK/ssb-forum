  <?php if(isset($noti_msg)) { ?>
  <div class="ssb-popup-backdrop">
    <div class="ssb-popup animated zoomIn">
      <strong>Message:</strong><br/>
      <?=$noti_msg?>
    </div>
  </div>
  <?php } ?>
  <div class="container">

    <div class="header">
      <button type="button" class="navbar-toggle collapsed guest-topmenu" data-toggle="collapse" data-target="#login-form" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <i class="glyphicon glyphicon-log-inglyphicon glyphicon-log-in"></i>
      </button>
      <h3 class="">SSB Forum</h3>
    </div>

    <div class="collapse navbar-collapse" id="login-form">
      
      <!-- <form class="form-inline pull-right" novalidate> -->
      <?=form_open('auth/login', array('class'=>"form-inline pull-right"))?>
        <div class="form-group">
          <h4>Login</h4>
        </div>
        <div class="form-group">
          <label class="sr-only" for="loginEmail">Email address</label>
          <input type="email" class="form-control" id="loginEmail" placeholder="Email" name="email">
        </div>
        <div class="form-group">
          <label class="sr-only" for="loginPassword">Password</label>
          <input type="password" class="form-control" id="loginPassword" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-default">Login</button>
      <?=form_close()?>
      <!-- </form> -->
    </div>
  

    <hr/>
    <div class="row">
      <div class="col-md-7">
        <div class="quote">
          "If death strikes, before I prove my blood, I swear I'll kill death." <br/>
          <span class="pull-right">– Capt. Manoj Kumar Pandey</span>
        </div>
      </div>
      <div class="col-md-4 register">
		<?=form_open('auth/register')?>
          <h4>Registration</h4>
          <hr/>
          <div class="form-group">
            <label for="regUsername">Username</label>
            <input type="text" class="form-control" id="regUsername" placeholder="Enter username" name="username">
          </div>

          <div class="form-group">
            <label for="regEmail">Email address</label>
            <input type="email" class="form-control" id="regEmail" placeholder="Enter email" name="email">
          </div>

          <div class="form-group">
            <label for="regPassword">Password</label>
            <input type="password" class="form-control" id="regPassword" placeholder="Enter password" name="password">
          </div>

          <div class="form-group">
            <label for="regBatch">Batch</label>
            <select class="form-control" id="regBatch" placeholder="Select batch" name="batch">
            <?php foreach ($batches as $batch) { ?>
              <option value="<?=$batch->id?>"><?=$batch->name?></option>
            <?php } ?>
            </select>
          </div>

          <button data-ng-click="register()" class="btn btn-primary">Register</button>

        <?=form_close()?>
      </div>
      <div class="col-md-1"></div>
    </div>
  </div>