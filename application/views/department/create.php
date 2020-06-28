<div class="content">
    <div class="container">
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center"><?= $title; ?></h2>

            <?php echo validation_errors(); ?>

            <?php echo form_open('departments/create'); ?>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>

            </form>

        </div>
    </div>
</div>