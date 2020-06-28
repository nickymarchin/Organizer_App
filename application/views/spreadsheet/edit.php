<div class="showcase">
    <div class="container">

        <h2 class="text-heading"><b><?php echo $title; ?></b></h2>

        <div class="col-md-4 col-md-offset-4">

            <?php echo validation_errors(); ?>

            <?php echo form_open('test/update'); ?>

            <input type="hidden" name="id" value="<?php echo $import[0]['id']; ?>">

            <div class="form-group">
                <label>Име</label>
                <input type="text" class="form-control" name="first_name" id="first_name"
                       placeholder="Въведете име" value="<?php echo $import[0]['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Фамилия</label>
                <input type="text" class="form-control" name="last_name" id="last_name"
                       placeholder="Въведете фамилия" value="<?php echo $import[0]['last_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Имейл</label>
                <input type="email" class="form-control" name="email" id="email"
                       placeholder="Въведете имейл" value="<?php echo $import[0]['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Курс</label>
                <select name="department_id" class="form-control" required>
                    <option value="<?php echo $import[0]['department_id']; ?>"><?php echo $current_department[0]['name']; ?></option>
                    <?php foreach ($departments as $department): ?>
                        <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
			<div class="form-group">
				<label>Група</label>
				<input class="form-control" name="group" id="group" placeholder="Група"
					   value="<?php echo $import[0]['group']; ?>" required>
			</div>
            <div class="form-group">
                <label>Факултетен номер</label>
                <input class="form-control" name="fac_no" id="fac_no" placeholder="Факултетен номер"
                       value="<?php echo $import[0]['fac_no']; ?>" required>
            </div>
            <button type="submit" class="btn btn-info btn-block">Submit</button>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
