pdfMake.fonts = {
	THSarabun: {
		normal: "THSarabun.ttf",
		bold: "THSarabun-Bold.ttf",
		italics: "THSarabun-Italic.ttf",
		bolditalics: "THSarabun-BoldItalic.ttf",
	},
};
const report = {
	data: {
		filterdate: [
			{ text: "daynow", value: [moment(), moment()] },
			{
				text: "weeknow",
				value: [moment().startOf("week"), moment().endOf("week")],
			},
			{
				text: "monthnow",
				value: [moment().startOf("month"), moment().endOf("month")],
			},
			{
				text: "quarternow",
				value: [moment().startOf("quarter"), moment().endOf("quarter")],
			},
			{
				text: "yearnow",
				value: [moment().startOf("year"), moment().endOf("year")],
			},
		],
		table: null,
	},
	jquery: {
		main() {
			let data = report.data.filterdate.filter(
				(ev, i) => ev.text == "daynow"
			)[0];
			$("#date_start").val(moment(data.value[0]).format("DD-MMM-YYYY"));
			$("#date_end").val(moment(data.value[1]).format("DD-MMM-YYYY"));
			$(document).on("click", ".btnfilter-data", async (e) => {
				let obj = $(e.target).closest(".btnfilter-data");
				$(".btnfilter-data").not(obj).removeClass("active");
				obj.addClass("active");
				let value = obj.data("action");
				if (value != "" && typeof value != "undefined") {
					let data = report.data.filterdate.filter(
						(ev, i) => ev.text == value
					)[0];
					$("#date_start").val(moment(data.value[0]).format("DD-MMM-YYYY"));
					$("#date_end").val(moment(data.value[1]).format("DD-MMM-YYYY"));
				}
			});
			$("#datepicker").daterangepicker(
				{
					showDropdowns: true,
					ranges: {
						เมื่อวาน: [
							moment().subtract(1, "days"),
							moment().subtract(1, "days"),
						],
						"7 วันที่แล้ว": [moment().subtract(6, "days"), moment()],
						"30 วันที่แล้ว": [moment().subtract(29, "days"), moment()],
						เดือนที่แล้ว: [
							moment().subtract(1, "month").startOf("month"),
							moment().subtract(1, "month").endOf("month"),
						],
					},
					locale: {
						format: "DD/MM/YYYY",
						separator: " - ",
						applyLabel: "Apply",
						cancelLabel: "Cancel",
						fromLabel: "From",
						toLabel: "To",
						customRangeLabel: "Custom",
						weekLabel: "W",
						daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
						monthNames: [
							"January",
							"February",
							"March",
							"April",
							"May",
							"June",
							"July",
							"August",
							"September",
							"October",
							"November",
							"December",
						],
						firstDay: 1,
					},
					alwaysShowCalendars: true,
					startDate: moment().format("DD/MM/YYYY"),
					endDate: moment().format("DD/MM/YYYY"),
					opens: "left",
				},
				function (start, end, label) {
					$("#date_start").val(moment(start).format("DD-MMM-YYYY"));
					$("#date_end").val(moment(end).format("DD-MMM-YYYY"));
				}
			);
			$(document).on("click", "#datepicker", (e) => {
				e.stopPropagation();
			});
			$(document).on("click", ".date-range-show", (e) => {
				e.stopPropagation();
				$(" #datepicker").trigger("click");
			});
		},
	},
	components: {},
	methods: {},
	ajax: {},
	async init() {
		this.jquery.main();

		$(document).on("click", ".show-all-rows", async (e) => {
			$(".dataTables_length select").val(-1).trigger("change");
		});
		this.data.table = $("#tb-report").DataTable({
			initComplete: function (settings) {
				initializeDataTables(settings);
			},
			lengthMenu: [
				[10, 25, 50, -1],
				["10 แถว", "25 แถว", "50 แถว", "ทั้งหมด"],
			],
			fixedColumns: true,
			dom: "<'all-report-wrapper'<'left col-sm-12 col-12'Bl><'right'f>>rtip",
			// "bPaginate": false,
			buttons: [
				{
					extend: "copy",
					title: $(`tb-report`).data("title"),
				},
				{
					extend: "csv",
					title: $(`tb-report`).data("title"),
				},
				{
					extend: "excel",

					title: $(`tb-report`).data("title"),
					customize: function (xlsx) {
						var sheet = xlsx.xl.worksheets["sheet1.xml"];
						$(
							'row c[r^="A"], row c[r^="B"], row c[r^="C"], row c[r^="D"],row c[r^="E"],row c[r^="F"],row c[r^="G"],row c[r^="H"]',
							sheet
						).attr("s", "51");
					},
				},
				{
					extend: "print",
					title: $(`tb-report`).data("title"),
				},
			],
			order: [[0, "asc"]],
		});
		$(".all-report-wrapper .dt-buttons.btn-group").append(
			'<button class="btn btn-secondary " id="exportpdf" data-bs-toggle="modal" data-bs-target="#showpdfview" type="button"><span>PDF</span></button>'
		);
		$(document).on("show.bs.modal", "#showpdfview", async (e) => {
			let date_start = $("#date_start").val();
			let date_end = $("#date_end").val();
			let data = "?date_start=" + date_start;
			data += "&date_end=" + date_end;
			pdf_viewer({
				url: site_url("reports/exportpdf" + data),
				canvas: $("#showpdfview #showpdf")[0],
			});
		});
	},
};
report.init();
