<section class="showcase">
	<div class="container">

		<?php if ($this->session->flashdata('emailSuccess') != NULL): ?>
			<div class="alert alert-success alert-dismissible alert-hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('emailSuccess'); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('emailsToAll') != NULL): ?>
			<div class="alert alert-success alert-dismissible alert-hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('emailsToAll'); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('deleteSuccess') != NULL): ?>
			<div class="alert alert-success alert-dismissible alert-hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('deleteSuccess'); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('updateSuccess') != NULL): ?>
			<div class="alert alert-success alert-dismissible alert-hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('updateSuccess'); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('user_loggedin') != NULL): ?>
			<div class="alert alert-success alert-dismissible alert-hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('user_loggedin'); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('emailsToAllDepartment') != NULL): ?>
			<div class="alert alert-success alert-dismissible alert-hidden" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php print $this->session->flashdata('emailsToAllDepartment'); ?>
			</div>
		<?php endif; ?>

		<div class="pb-2 mt-4 mb-2 border-bottom">

			<?php if (isset($id)): ?>
				<h2 class="text-center"><?php echo $department_name ?></h2>
			<?php else: ?>
				<h2 class="text-center"><b>Студенти</b></h2>
				<!--                <a href="--><?php //echo base_url() . 'test/create'; ?><!--" class="btn btn-info btn-md">Add New Row</a>-->
				<!--                <a href="--><?php //echo base_url() . 'test'; ?><!--" class="btn btn-info btn-md">Import Data From File</a>-->
			<?php endif; ?>
			<br/>
			<br/>
			<div class="container mb-3 mt-3">
				<table id="all_data_table"
					   class="table table-striped table-bordered display all_data_table text-center"
					   style="width: 200%;">
					<thead>
					<tr class="table-primary">
						<th class="text-center" scope="col"></th>
						<!--						<th class="text-center" scope="col">Име</th>-->
						<th class="hidden">Id</th>
						<th class="text-wrap" scope="col">Име</th>
						<th class="text-center" scope="col">Имейл</th>
						<th class="text-center" scope="col">Курс</th>
						<th class="text-center" scope="col">Група</th>
						<th class="text-center" scope="col">Факултетен номер</th>
						<th class="text-center" scope="col"></th>
						<th class="text-center" scope="col"></th>
						<th class="text-center" scope="col"></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($usersList as $key => $element): ?>
						<tr>
							<td><?php print $element['email']; ?></td>
							<!--							<td class="first_name">-->
							<?php //print $element['first_name']; ?><!--</td>-->
							<td class="id" hidden><?php echo $element['id']; ?></td>
							<td class="last_name"><?php print $element['first_name'] . ' ' . $element['last_name']; ?></td>
							<td class="email"><?php print $element['email']; ?></td>
							<td class="department"><?php print $element['name'] ?></td>
							<?php if ($this->session->userdata('role') == 'Преподавател'): ?>
								<td class="group"><a href="<?php echo base_url() . 'test/get_students_by_group/' . $element['group']; ?>"><?php print $element['group'] ?></a></td>
							<?php else: ?>
								<td class="group"><?php print $element['group'] ?></td>
							<?php endif; ?>
							<td class="fac_no"><?php print $element['fac_no']; ?></td>
							<td>
								<button type="button" class="btn btn-success btn-sm" id="send_email_btn">Изпрати имейл
								</button>
							</td>
							<td>
								<a href="<?php echo base_url() . 'test/edit/' . $element['id']; ?>"
								   class="btn btn-info btn-sm" id="edit_import">Редактирай</a>
							</td>
							<td>
								<a href="<?php echo base_url() . 'test/delete/' . $element['id']; ?>"
								   class="btn btn-danger btn-sm"
								   onclick="return confirm('Are you sure?')"
								   id="delete_import">Изтрий</a>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<br/>
			</div>

			<div class="row padall border-bottom">
				<div class="col-lg-12">
					<div class="float-right">

						<?php if (isset($id)): ?>
							<?php if ($id != NULL): ?>
								<a href="#" id="send_email_to_department_btn" class="btn btn-primary btn-md">Send Email
									to
									Department</a>
							<?php endif; ?>
						<?php else: ?>
							<a href="#" id="send_email_to_all_btn" class="btn btn-primary btn-md">Изпрати имейл до
								всички студенти</a>
						<?php endif; ?>
						<a href="#" id="send_email_to_checked_btn" class="btn btn-primary btn-md">Изпрати имейл до
							избраните студенти</a>
					</div>
				</div>
			</div>
			<br/>
			<br/>
		</div>
</section>

<!--MODAL FORMS FOR EMAILS-->

<!-- MODAL FOR ONE -->
<form id="new_email_form" action="<?php echo base_url() . 'email/singleUserMail' ?>" method="post">
	<div class="modal-container">
		<div class="new_email fade" id="new_email" tabindex="1" role="dialog" aria-label="leaveReqestLabel"
			 data-keyboard="false" data-backdrop="static"
			 style=" width:100%; padding-right:17px; padding-left:17px;">
			<div class="modal-dialog" id="modal_dialog_new_user" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="header">
							<h3 class="modal-title" id="requestLabel">Send Email</h3>
						</div>
						<div class="modal-close-button">
							<button type="button" class="close closeBtn" data-dismiss="modal" aria-label="Close"
									title="Затвори"><span aria-hidden="true">×</span>
							</button>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="user_email">Email:</label>
									<input class="form-control " type="text" id="user_email" name="user_email"
										   required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="email_subject">Subject:</label>
									<input class="form-control" type="text" id="email_subject" name="email_subject"
										   required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="content_email">Content:</label>
									<textarea name="content_email" type="text"
											  class="form-control content_email"></textarea>

								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="submit" id="user_submit_btn" name="submit" class="btn btn-primary"
								   value="Изпрати">
							<button type="button" id="user_cancel_btn" class="btn btn-default" data-dismiss="modal">
								Затвори
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
</form>

<!-- MODAL FOR ALL -->
<form id="new_email_form" action="<?php echo base_url() . 'email/sendEmailToAll' ?>" method="post">
	<div class="modal-container">
		<div class="new_email fade" id="new_email_to_all" tabindex="1" role="dialog" aria-label="leaveReqestLabel"
			 data-keyboard="false" data-backdrop="static"
			 style=" width:100%; padding-right:17px; padding-left:17px;">
			<div class="modal-dialog" id="modal_dialog_new_user" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="header">
							<h3 class="modal-title" id="requestLabel">Send Email To All</h3>
						</div>
						<div class="modal-close-button">
							<button type="button" class="close closeBtn" data-dismiss="modal" aria-label="Close"
									title="Затвори"><span aria-hidden="true">×</span>
							</button>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="email_subject">Subject:</label>
									<input class="form-control" type="text" id="email_subject" name="email_subject"
										   required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="content_email">Content:</label>
									<textarea name="content_email" type="text"
											  class="form-control content_email"></textarea>

								</div>
							</div>
						</div>
					</div>

					<br/>
					<br/>

					<div class="modal-footer">
						<input type="submit" id="user_submit_btn" name="submit" class="btn btn-primary"
							   value="Изпрати">
						<button type="button" id="user_cancel_btn" class="btn btn-default" data-dismiss="modal">
							Затвори
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- MODAL FOR ALL FROM DEPARTMENT-->
<?php if (isset($id)): ?>
	<form id="new_email_form" action="<?php echo base_url() . 'email/send_emails_to_all/' . $id ?>"
		  method="post">
		<div class="modal-container">
			<div class="new_email fade" id="new_email_to_all_from_department" tabindex="1" role="dialog"
				 aria-label="leaveReqestLabel"
				 data-keyboard="false" data-backdrop="static"
				 style=" width:100%; padding-right:17px; padding-left:17px;">
				<div class="modal-dialog" id="modal_dialog_new_user" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<div class="header">
								<h3 class="modal-title" id="requestLabel">Send Email To All From Department</h3>
							</div>
							<div class="modal-close-button">
								<button type="button" class="close closeBtn" data-dismiss="modal" aria-label="Close"
										title="Затвори"><span aria-hidden="true">×</span>
								</button>
							</div>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<div class="col">
									<div class="col-md-12 ui-front">

										<label class="label_default" for="email_subject">Subject:</label>
										<input class="form-control" type="text" id="email_subject" name="email_subject"
											   required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col">
									<div class="col-md-12 ui-front">

										<label class="label_default" for="content_email">Content:</label>
										<textarea name="content_email" type="text"
												  class="form-control content_email"></textarea>

									</div>
								</div>
							</div>
						</div>

						<br/>
						<br/>

						<div class="modal-footer">
							<input type="submit" id="user_submit_btn" name="submit" class="btn btn-primary"
								   value="Изпрати">
							<button type="button" id="user_cancel_btn" class="btn btn-default" data-dismiss="modal">
								Затвори
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php endif; ?>

<!-- MODAL FOR CHECkED -->
<form id="new_email_form" action="<?php echo base_url() . 'email/sendEmailToChecked' ?>" method="post">
	<div class="modal-container">
		<div class="new_email fade" id="new_email_to_checked" tabindex="1" role="dialog" aria-label="leaveReqestLabel"
			 data-keyboard="false" data-backdrop="static"
			 style=" width:100%; padding-right:17px; padding-left:17px;">
			<div class="modal-dialog" id="modal_dialog_new_user" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<div class="header">
							<h3 class="modal-title" id="requestLabel">Send Email To Checked</h3>
						</div>
						<div class="modal-close-button">
							<button type="button" class="close closeBtn" data-dismiss="modal" aria-label="Close"
									title="Затвори"><span aria-hidden="true">×</span>
							</button>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="users_emails">Emails:</label>
									<input class="form-control " type="text" id="users_emails" name="users_emails"
										   required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="email_subject">Subject:</label>
									<input class="form-control" type="text" id="email_subject" name="email_subject"
										   required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col">
								<div class="col-md-12 ui-front">

									<label class="label_default" for="content_email">Content:</label>
									<textarea name="content_email" type="text"
											  class="form-control content_email"></textarea>

								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<input type="submit" id="user_submit_btn" name="submit" class="btn btn-primary"
							   value="Изпрати">
						<button type="button" id="user_cancel_btn" class="btn btn-default" data-dismiss="modal">
							Затвори
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

