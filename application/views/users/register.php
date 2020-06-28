<div class="main-body">
    <div class="container">

        <?php echo validation_errors(); ?>

        <?php echo form_open('users/register'); ?>

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h2 class="text-heading"><?= $title; ?></h2>

                <div class="form-group">
                    <label>Име и фамилия</label>
                    <input type="text" class="form-control" name="name" placeholder="Име" autofocus>
                </div>

				<div class="form-group">
					<label>Роля</label>
					<select name="role_id" class="form-control" required>
						<option disabled selected value> -- изберете роля --</option>
						<?php foreach ($roles as $role): ?>
							<option value="<?php echo $role['id']; ?>"><?php echo $role['role_name']; ?> </option>
						<?php endforeach; ?>
					</select>
				</div>

                <div class="form-group">
                    <label>Имейл</label>
                    <input type="email" class="form-control" name="email" placeholder="Имейл">
                    <small id="emailHelp" class="form-text text-muted">Няма да споделяме Вашият имейл с никого.
                    </small>
                </div>

                <div class="form-group">
                    <label>Потребителско име</label>
                    <input type="text" class="form-control" name="username" placeholder="Потребителско име">
                </div>

                <div class="form-group">
                    <label>Парола</label>
                    <input type="password" class="form-control" name="password" placeholder="Парола">
                </div>

                <div class="form-group">
                    <label>Потвърди Паролата</label>
                    <input type="password" class="form-control" name="password2" placeholder="Потвърди Паролата">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
