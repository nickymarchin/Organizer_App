<div class="main-body">
    <div class="container">
        <?php if ($this->session->flashdata('user_registered') != NULL): ?>
            <div class="alert alert-success alert-dismissible alert-hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times</button>
                <?php print $this->session->flashdata('user_registered'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('login_failed') != NULL): ?>
            <div class="alert alert-danger alert-dismissible alert-hidden" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times</button>
                <?php print $this->session->flashdata('login_failed'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('user_loggedout') != NULL): ?>
            <div class="alert alert-success alert-dismissible alert-hidden " role="alert">
                <button type="button" class="close" data-dismiss="alert">&times</button>
                <?php print $this->session->flashdata('user_loggedout'); ?>
            </div>
        <?php endif; ?>

        <?php echo form_open('users/login'); ?>
        <div class="sign-in-wrapper">
            <div class="col-md-4 col-md-offset-4">

                <h2 class="text-heading"><?php echo $title ?></h2>

                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required
                           autofocus>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required
                           autofocus>
                </div>

                <button type="submit" class=" btn btn-primary btn-block">Вход</button>

            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
