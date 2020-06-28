<section class="showcase">
	<div class="container">

		<?php if ($this->session->flashdata('importSuccess') != NULL): ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('importSuccess'); ?>
			</div>
		<?php endif; ?>

		<div class="pb-2 mt-4 mb-2 border-bottom">
			<h2>Данни за студенти:</h2>

			<br/>
			<br/>

			<div class="container mb-3 mt-3">

				<table class="table table-striped table-bordered nowrap display import_table text-center">
					<thead>
					<tr class="table-primary">
						<th scope="col">Име</th>
						<th scope="col">Фамилия</th>
						<th scope="col">Имейл</th>
						<th scope="col">Факултетен номер</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($dataInfo as $key => $element) { ?>
						<tr>
							<td><?php print $element['first_name']; ?></td>
							<td><?php print $element['last_name']; ?></td>
							<td><?php print $element['email']; ?></td>
							<td><?php print $element['fac_no']; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

				<br/>
				<br/>

			</div>

			<div class="row padall border-bottom">
				<div class="col-lg-12">
					<div class="float-right">

						<?php if ($this->session->userdata('role') == 'Преподавател'): ?>
							<a href="<?php echo base_url() . 'test'; ?>" class="btn btn-info btn-sm"><i
									class="fa fa-file-upload"></i>Импортиране на още данни</a>

							<a href="<?php echo base_url() . 'test/get_students_by_creator_id/' . $this->session->userdata('user_id'); ?>" class="btn btn-primary btn-sm"><i
									class="fa fa-file-upload"></i>Виж всички мои студенти</a>
						<?php else: ?>
							<a href="<?php echo base_url() . 'test'; ?>" class="btn btn-info btn-sm"><i
									class="fa fa-file-upload"></i>Импортиране на още данни</a>

							<a href="<?php echo base_url() . 'test/getUsersList'; ?>" class="btn btn-primary btn-sm"><i
									class="fa fa-file-upload"></i>Виж всички студенти</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
</section>

