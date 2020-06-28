<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">

				<?php if ($this->session->flashdata('deleteSuccess') != NULL): ?>
					<div class="alert alert-success alert-dismissible alert-hidden" role="alert" style="width: 547px">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<?php print $this->session->flashdata('deleteSuccess'); ?>
					</div>
				<?php endif; ?>

				<h2 class="text-center"><b><?= $title; ?></b></h2>

				<ul class="list-group">
					<?php foreach ($requests as $request) : ?>

						<li class="list-group-item">
							<a href="#"><?php echo $request['student_name'] ?></a>

							<a href="#"><?php echo $request['course_name'] ?></a>

							<a class="btn btn-danger btn-xs pull-right" href="#">Не</a>
							<a class="btn btn-success btn-xs pull-right" href="#">Да</a>
						</li>

					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
