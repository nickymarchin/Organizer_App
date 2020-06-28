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
					<?php foreach ($categories as $category) : ?>
						<li class="list-group-item">
							<a href="<?php echo base_url() . 'test/getUsersList/' . $category['id']; ?>"><?php echo $category['name'] ?></a>
<!--							<a href="--><?php //echo base_url() . 'list'; ?><!--">--><?php //echo $category['name'] ?><!--</a>-->

							<a class="btn btn-danger btn-xs pull-right"
							   href="<?php echo base_url() . 'departments/delete/' . $category['id']; ?>">Изтрий курс</a>
<!--							<a class="btn btn-info btn-xs pull-right"-->
<!--							   href="#">Групи в курса</a>-->
						</li>
					<?php endforeach; ?>
				</ul>
				<a class="btn btn-success btn-sm btn-block btn-add"
				   href="<?php echo base_url() . 'departments/create'; ?>">Добави Курс</a>

			</div>
		</div>
	</div>
</div>
