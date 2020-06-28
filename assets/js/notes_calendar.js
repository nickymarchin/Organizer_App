$(document).ready(function () {

	var today = new Date();
	var yesterday = new Date().setDate(today.getDate() - 1);

	$('#notes_calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'settimana,agendaDay'
		},
		defaultDate: moment(new Date(), 'YYYY-MM-DD'),
		locale: 'bg',
		navLinks: true, // can click day/week names to navigate views
		selectable: true,
		selectHelper: false,
		minTime: '06:00:00',
		maxTime: '19:30:00',
		//slotDuration: "00:30:01",// Property for showing full and full and half hours
		views: {
			settimana: {
				type: 'agendaWeek',
				duration: {
					days: 7
				},
				title: 'Седмичен',
				columnFormat: 'dddd DD.MM', // Format the day to only show full name and date (colum)
				hiddenDays: [0, 6], // Hide Sunday and Saturday
				slotLabelFormat: ['H:mm']//Format the view of hours how to display (rows)
			},
			agendaDay: {
				type: 'agendaDay',
				duration: {
					days: 7
				},
				title: 'Седмичен',
				columnFormat: 'dddd DD.MM', // Format the day to only show full name and date (colum)
				hiddenDays: [0, 6], // Hide Sunday and Saturday
				slotLabelFormat: ['H:mm']//Format the view of hours how to display (rows)
			},
		},
		defaultView: 'settimana',
		select: function (start, end) {
			var title = prompt('Event Title:');
			var noteData;
			if (title) {
				noteData = {
					title: title,
					start: start,
					end: end
				};
				$('#notes_calendar').fullCalendar('renderEvent', noteData, true);
			}
			$('#notes_calendar').fullCalendar('unselect');
		},
		//forbid to request holidays from the prevision days
		selectConstraint: 'businessHours',

		//forbid to request holidays from the prevision days
		eventConstraint: 'businessHours',

		allDaySlot: false,

		responsive: true,

		height: "auto",

		//Get the events from database by Controller function -get_hours_holiday() .
		events: {
			url: 'note/get_notes',
			editable: false,
			type: 'json',
			data: {
				custom_param1: 'username',
				custom_param2: 'description',
				custom_param3: 'location'
			},

		},
		businessHours: [{
			// days of week. an array of zero-based day of week integers (0=Sunday)
			dow: [1, 2, 3, 4, 5], // Monday - Friday

			start: '06:00', // a start time
			end: '19:00', // an end time (
		},

		],

		select: function (start, end, allDay) {

			//var yester_day = getYesterdayDay();
			//var yester_month = getYesterdayMonth();

			var formatStart = $.datepicker.formatDate('yy-mm-dd', new Date(start));
			var formatToday = $.datepicker.formatDate('yy-mm-dd', new Date());

			if (formatStart < formatToday) {

				toastr.options = {
					"closeButton": true,
					"timeOut": "2000"
				};
				toastr.error('Бележка за изминал период не може да бъде въведена!');

				return;
			}


			var end_time = $.fullCalendar.formatDate(end, 'DD.MM.Y H:mm');
			var start_time = $.fullCalendar.formatDate(start, 'DD.MM.Y H:mm');

			var difference = moment(end_time, "DD.MM.Y H:mm").diff(moment(start_time, "DD.MM.Y H:mm"));

			var duration = moment.duration(difference);

			var formatDifference = duration.get("hours") + ":" + duration.get("minutes") + ":" + duration.get("seconds");

			var duration_view_difference;

			if (duration.get("hours") < 1) {
				duration_view_difference = duration.get("minutes") + " минути";
			} else if (duration.get("hours") == 1 && duration.get("minutes") != 0) {
				duration_view_difference = duration.get("hours") + " час и " + duration.get("minutes") + " минути";
			} else if (duration.get("hours") == 1 && duration.get("minutes") == 0) {
				duration_view_difference = duration.get("hours") + " час";
			} else if (duration.get("hours") > 1 && duration.get("minutes") != 0) {
				duration_view_difference = duration.get("hours") + " часа и " + duration.get("minutes") + " минути";
			} else {
				duration_view_difference = duration.get("hours") + " часа";
			}


			$('#new_note #note_duration').val(duration_view_difference);
			$('#new_note .start_time').val(start_time);
			$('#new_note .end_time').val(end_time);
			$('#new_note .duration').val(formatDifference);
			$('#new_note').modal('show');

		},

		//Adding new property to the events for more additional information in the view
		//This is used to show the custom property from database to the view
		eventRender: function (event, element, view) {
			element.find(".fc-content")
				.append("" + event.username).append("<br>" + event.description).append('<br><span class="glyphicon glyphicon-tag" aria-hidden="true"> ' + event.location + '</div>');
		},

	});

	jQuery.datetimepicker.setLocale('bg');

});
