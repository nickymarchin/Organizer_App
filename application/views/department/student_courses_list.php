<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">

				<h2 class="text-center"><b><?= $title; ?></b></h2>

				<ul class="list-group">
					<?php foreach ($categories as $category) : ?>
						<li class="list-group-item">
							<a href="#"><?php echo $category['name'] ?></a>


							<a class="btn btn-success btn-xs pull-right"
							   href="<?php echo base_url() . 'departments/send_join_request/' . $category['id']; ?>">Заяви участие</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
