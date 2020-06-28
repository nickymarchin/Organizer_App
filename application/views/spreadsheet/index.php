<section class="showcase">
    <div class="row">
        <div class="col-md-12 col-lg-4"></div>
        <div class="col-md-12 col-lg-4">
            <div class="b-text-wall">
                <h3><b>Импортиране на студенти от файл</b></h3>
                <h4><b>(.xlsx, .xls, .csv)</b></h4>

                <?php if ($this->session->flashdata('invalidImport') != NULL): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php print $this->session->flashdata('invalidImport'); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($errorMsg)): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php print $errorMsg; ?>
                    </div>
                <?php endif; ?>

                <?php if (form_error('fileURL')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php print form_error('fileURL'); ?>
                    </div>
                <?php } ?>

                <form action="<?php echo base_url() . 'test/upload'; ?>" class="excel-upl" id="excel-upl"
                      enctype="multipart/form-data" method="post" accept-charset="utf-8">

					<label>Избери курс</label>
					<select name="department_id" class="form-control" required>
						<?php foreach ($departments as $department): ?>
							<option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
						<?php endforeach; ?>
					</select>

                    <div class="row padall">
                        <div class=" order-lg-1">
                            <input type="file" class="custom-file-input" id="validatedCustomFile" name="fileURL">
                        </div>
                    </div>
                    <button type="submit" name="import" class="btn btn-primary">Импортиране</button>

                </form>
            </div>
        </div>
        <div class="col-md-12 col-lg-4"></div>
    </div>
</section>




