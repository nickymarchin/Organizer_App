<!DOCTYPE html>
<?php //$this->load->view('templates/header');?>
<!-- container -->
<html>
<head>
	<title>Университетска система - Органайзер</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
		  integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Toastr CSS -->
	<link rel="stylesheet" type="text/css" href="<?php print base_url(); ?>assets/vendor/toastr/build/toastr.css"
		  rel="stylesheet">
	<!-- Fullcalendar -->
	<link rel="stylesheet" type="text/css"
		  href='<?php print base_url(); ?>assets/vendor/fullcalendar/fullcalendar.min.css'/>
	<link rel="stylesheet" type="text/css"
		  href='<?php print base_url(); ?>assets/vendor/fullcalendar/fullcalendar.print.min.css' media='print'/>

	<!-- Data tables -->
	<link rel="stylesheet" type="text/css"
		  href="<?php print base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css"
		  href="<?php print base_url(); ?>assets/vendor/datatables/responsive.dataTables.min.css"/>
	<link type="text/css"
		  href="<?php print base_url(); ?>assets/vendor/jquery-datatables-checkboxes-1.2.11/css/dataTables.checkboxes.css"
		  rel="stylesheet"/>

	<!-- include summernote css/js -->
	<link rel="stylesheet" type="text/css"
		  href="<?php print base_url(); ?>assets/vendor/summernote-master/dist/summernote-lite.css">

	<link rel="stylesheet" type="text/css"
		  href="<?php print base_url(); ?>assets/css/template.css">

</head>
<body>

<nav class="header-navbar">

	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="nav navbar-nav">

			<?php if ($this->session->userdata('logged_in')): ?>

				<!--				<li class="nav-item">-->
				<!--					<a class="nav-link"-->
				<!--					   href="--><?php //echo base_url() . 'list'; ?><!--">--><?php //echo($this->session->userdata('username') . ' - ' . $this->session->userdata('role')); ?>
				<!--						<span-->
				<!--							class="sr-only">(current)</span></a>-->
				<!---->
				<!--				</li>-->
				<li>
					<a class="nav-link"> <?php echo($this->session->userdata('username') . ' - ' . $this->session->userdata('role')); ?> </a>
					<span
						class="sr-only">(current)</span>
				</li>
			<?php endif; ?>
		</ul>

		<ul class="nav navbar-nav navbar-right">

			<?php if (!$this->session->userdata('logged_in')): ?>
				<li>
					<a class="nav-link" href="<?php echo base_url() . 'users/login'; ?>">Вход<span
							class="sr-only">(current)</span></a>
				</li>
				<li>
					<a class="nav-link" href="<?php echo base_url() . 'users/register'; ?>">Регистрация<span
							class="sr-only">(current)</span></a>
				</li>
			<?php endif; ?>

			<?php if ($this->session->userdata('logged_in')): ?>
				<li>
					<a class="nav-link" href="<?php echo base_url() . 'users/logout'; ?>"
					>Изход<span class="sr-only">(current)</span></a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</nav>

<?php if ($this->session->userdata('logged_in')): ?>

	<div id="sidebar">

		<!--		<a>-->
		<!--			<div class="toggle-btn" onclick="toggleSidebar()">-->
		<!--				<span></span>-->
		<!--				<span></span>-->
		<!--				<span></span>-->
		<!--			</div>-->
		<!--		</a>-->

		<ul>
			<?php if ($this->session->userdata('role') == 'Администратор'): ?>
				<li>
                <span class="glyphicon glyphicon-bell" aria-hidden="true">
                <a class="nav-link" href="<?php echo base_url() . 'departments/get_all_requests_for_approval'; ?>">Заявки<span class="sr-only">(current)</span></a>
                </span>
				</li>
				<li class="nav-item">
				<span class="glyphicon glyphicon-list" aria-hidden="true">
				<a class="nav-link" href="<?php echo base_url() . 'test/getUsersList'; ?>">Всички Студенти<span
						class="sr-only">(current)</span></a>
				</li>

				<li>
                <span class="glyphicon glyphicon-user" aria-hidden="true">
                <a class="nav-link" href="<?php echo base_url() . 'departments'; ?>">
                   Всички Курсове<span class="sr-only">(current)</span></a>
                </span>
				</li>
			<?php endif; ?>

			<?php if ($this->session->userdata('role') == 'Преподавател'): ?>
				<li>
                <span class="glyphicon glyphicon-info-sign" aria-hidden="true">
                <a class="nav-link" href="<?php echo base_url() . 'departments/get_requests_for_approval'; ?>">
                   Заявки от студенти<span class="sr-only">(current)</span></a>
                </span>
				</li>
				<li class="nav-item">
				<span class="glyphicon glyphicon-list" aria-hidden="true">
				<a class="nav-link"
				   href="<?php echo base_url() . 'test/get_students_by_creator_id/' . $this->session->userdata('user_id'); ?>">Мои Студенти<span
						class="sr-only">(current)</span></a>
				</li>

				<li>
                <span class="glyphicon glyphicon-user" aria-hidden="true">
                <a class="nav-link"
				   href="<?php echo base_url() . 'departments/get_my_courses/' . $this->session->userdata('user_id'); ?>">
                   Мои Курсове<span class="sr-only">(current)</span></a>
                </span>
				</li>
			<?php endif; ?>

			<?php if ($this->session->userdata('role') == 'Студент'): ?>
				<li>
                <span class="glyphicon glyphicon-home" aria-hidden="true">
					<a class="nav-link" href="<?php echo base_url() . 'test/get_courses_student_is_in'; ?>">Начало</a>
                </span>
				</li>
				<li>
                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true">
					<a class="nav-link" href="<?php echo base_url() . 'departments/student_courses_to_join'; ?>">Курсове</a>
                </span>
				</li>
			<?php endif; ?>

			<li>
                <span class="glyphicon glyphicon-envelope" aria-hidden="true">
                <a class="nav-link" href="<?php echo base_url() . 'users/emails_sent'; ?>">
                    Имейли от мен<span class="sr-only">(current)</span></a>
                </span>
			</li>

			<?php if ($this->session->userdata('role') == 'Преподавател' || $this->session->userdata('role') == 'Администратор'): ?>
				<li>
                <span class="glyphicon glyphicon-edit" aria-hidden="true">
					<a class="nav-link" href="<?php echo base_url() . 'test/create'; ?>">Добави Студент</a>
                </span>
				</li>
			<?php endif; ?>

			<li>
				<span class="glyphicon glyphicon-calendar" aria-hidden="true">
                <a class="nav-link" href="<?php echo base_url() . 'note'; ?>">Календар</a>
                </span>
			</li>

			<?php if ($this->session->userdata('role') == 'Преподавател' || $this->session->userdata('role') == 'Администратор'): ?>
				<li>
                	<span class="glyphicon glyphicon-open" aria-hidden="true">
                		<a class="nav-link" href="<?php echo base_url() . 'test'; ?>">Импортиране</a>
                	</span>
				</li>
			<?php endif; ?>

		</ul>
	</div>

<?php endif; ?>
