$(document).ready(function () {

	$('.all_data_table').DataTable({
		responsive: true,

		"order": [[1, "asc"]],
		"language": {
			"emptyTable": "No data available in table",
		},
		'columnDefs': [
			{
				'targets': 0,
				'checkboxes': {
					'selectRow': true,
					'selectAll': true,
					'name': 'checkbox'
				},
				'render': function (data, type) {
					if (type === 'display') {
						data = '<label for="checkbox" class=\"custom_check\"> <input type="checkbox" id="checkbox" class="dt-checkboxes" style="width: 25px;height: 25px;left: 0;top: 0;z-index: 2"><span  class=\"check_mark\"></span> </label>';
					}

					return data;
				},
			}
		],
		'select': {
			'style': 'multi'
		},

	});
});

$(document).ready(function () {

	var table = $('.import_table').DataTable({
		responsive: true
	});

	// new $.fn.dataTable.FixedHeader(table);
});

$(document).ready(function () {

	var table = $('.my_notes_table').DataTable({
		responsive: true
	});

	// new $.fn.dataTable.FixedHeader(table);
});

$('.content_email').summernote({
	placeholder: 'Enter content here..'
});

//single user email
$(document).on('click', '#send_email_btn', function () {

	var numColumnsInRow = $(this).closest("tr").find("td").length;
	var row;
	var user_id;

	if (numColumnsInRow !== 1) {
		row = $(this).closest("tr");
		user_id = row.find($("td.id")).text();
	} else {
		row = $(this).closest("tr");
		user_id = row.prev().find($('td.id')).text();
	}

	$.ajax({
		type: "POST",
		dataType: "JSON",
		url: "http://localhost:83/test/get_user_email",
		//url: "get_user_email",
		data: {user_id: user_id},
		success: function (response) {

			var email = response[0].email;

			$("#user_email").val(email);
		},
	});

	$('#new_email').modal('show');
});

$(document).on('click', '#send_email_to_all_btn', function () {
	$('#new_email_to_all').modal('show');
});

$(document).on('click', '#send_email_to_department_btn', function () {
	$('#new_email_to_all_from_department').modal('show');
});

$(document).on('click', '#send_email_to_checked_btn', function () {

	//get checked from table
	var user_emails_checked = [];

	$('input[id="checkbox"]:checked').each(function () {
		var responsive_row = $(this).closest("tr").attr("class");
		if (responsive_row == "child") {
			var row = $(this).closest("tr");
			var email = row.prev().find(".email").val();

			user_emails_checked.push(email);
		}
	});

	var table = $('#all_data_table').DataTable();

	table.rows().nodes();

	var selectedRowsCheckboxes = table.column(0).checkboxes.selected();

	// var emails = selectedRowsCheckboxes.join(', ');

	var emails = [];

	//remove duplicate email values
	$.each(selectedRowsCheckboxes, function (i, el) {
		if ($.inArray(el, emails) === -1) emails.push(el);
	});

	$("#users_emails").val(emails);

	$('#new_email_to_checked').modal('show');

});

$(document).on('click', '#check_all_btn', function () {

	var table = $('#all_data_table').DataTable();

	if ($(this).is(":checked")) {
		table.rows().select();
	} else {
		table.rows().deselectAll();
	}

});

$(".alert-hidden").delay(2000).slideUp(200, function () {
	$(this).alert('close');
});

function toggleSidebar() {
	document.getElementById("sidebar").classList.toggle('active');
}

$(document).on('click', '#delete_note', function () {

	var id = $(this).val();

	if (confirm("Сигурни ли сте че искате да изтриете бележката?") === true) {
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "note/delete_note",
			data: {id: id},
			success: function (response) {
				window.location.reload()
			},
		});
	}

});
