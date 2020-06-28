<div class="content">
	<div class="container">
		<div class="row">
			<!--			<div class="col-md-10 col-md-offset-2">-->

			<h2 class="text-center"><b><?= $title; ?></b></h2>

			<br/>
			<br/>

			<div class="row" style="margin-bottom: 25px;">
				<div id='notes_calendar'></div>
			</div>

			<br/>

			<!--			</div>-->
		</div>


		<div class="row">
			<div class="pb-2 mt-4 mb-2 border-bottom">
				<h2>Мои бележки</h2>

				<br/>
				<br/>

				<div class="container mb-3 mt-3">

					<table class="table table-striped table-bordered nowrap display my_notes_table text-center">
						<thead>
						<tr class="table-primary">
							<th scope="col">Дата</th>
							<th scope="col">Продължителност</th>
							<th scope="col">Местоположение</th>
							<th scope="col">Описание</th>
							<th scope="col"></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($notes as $note) { ?>
							<tr>
								<td><?php print explode(' ', $note['start'])[0]; ?></td>
								<td><?php print $note['duration_time']; ?> ч.</td>
								<td><?php print $note['location']; ?></td>
								<td><?php print $note['description']; ?></td>
								<td>
									<button type="button" id='delete_note' value="<?php print $note['id']; ?>"
											class="btn btn-danger">Изтрий
									</button>
								</td>
							</tr>
						<?php } ?>

						</tbody>
					</table>
					<br/>
					<br/>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- ADD NOTE FORM -->
<form id="add_note" action="<?php echo base_url() . 'note/add_note' ?>" method="post">
	<div class="modal-container">
		<div class="new_note fade" id="new_note" tabindex="1" role="dialog" aria-label="leaveReqestLabel"
			 data-keyboard="false" data-backdrop="static"
			 style=" width:100%; padding-right:17px; padding-left:17px;">

			<div class="modal-dialog" id="modal_dialog_new_note" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="header">
							<h3 class="modal-title" id="requestLabel">Добави бележка</h3>
						</div>
						<div class="modal-close-button">
							<button type="button" class="close closeBtn" data-dismiss="modal" aria-label="Close"
									title="Затвори"><span aria-hidden="true">×</span>
							</button>
						</div>
					</div>

					<div class="modal-body">

						<div class="form-group">
							<label for="p-in" class="col-md-4 label-heading">От:</label>
							<div class="col-md-8">
								<input class="start_time form-control" type="text" id="start_time"
									   name="start_time"
									   required readonly>
								<span class="icon">
                                             <i class="fa fa-fw fa-clock-o"></i>
                                    </span>
							</div>
						</div>

						<div class="form-group">
							<label for="p-in" class="col-md-4 label-heading">До:</label>
							<div class="col-md-8">
								<input class="end_time form-control" type="text" id="end_time" name="end_time"
									   required readonly>
								<span class="icon">
                                             <i class="fa fa-fw fa-clock-o"></i>
                                    </span>
							</div>
						</div>

						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="note_duration">Продължителност:</label>
									<input class="form-control" type="text" id="note_duration"
										   name="note_duration"
										   required readonly>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="note_location">Местоположение:</label>
									<input class="form-control" type="text" id="note_location"
										   name="note_location"
										   required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">
									<label for="p-in" class="col-md-4 label-heading" hidden>Време</label>
									<input type="datetime" data-format=" hh:MM:SS" class="duration form-control"
										   name="duration" style="display: none" readonly>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="note_description">Описание:</label>
									<textarea name="note_description" type="text"
											  class="form-control note_description"></textarea>

								</div>
							</div>
						</div>

						<div class="modal-footer">
							<input type="submit" id="new_note_submit" name="submit" class="btn btn-primary"
								   value="Запис">
							<button type="button" id="user_cancel_btn" class="btn btn-default"
									data-dismiss="modal">
								Затвори
							</button>
						</div>

					</div>
				</div>
			</div>
		</div>
</form>
