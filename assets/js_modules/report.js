pdfMake.fonts = {
	THSarabun: {
		normal: "THSarabun.ttf",
		bold: "THSarabun-Bold.ttf",
		italics: "THSarabun-Italic.ttf",
		bolditalics: "THSarabun-BoldItalic.ttf",
	},
};
let l = window.location.pathname.split("/").length;
const _path = window.location.pathname.split("/")[l - 1];
const report = {
	data: {
		path: _path,

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
		table2: null,
	},
	jquery: {
		main() {
			if (mobile) {
				$("#showfilter").css("display", "none");
				$("#show-filterbtn").css("display", "unset");
			} else {
				$("#show-filterbtn").css("display", "none");
				$("#showfilter").css("display", "unset");
			}
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
	components: {
		text(data) {
			return `<div class="text-ellipsis-scroll"><span>${data}</span></div>`;
		},
	},
	methods: {
		async rendertable(data) {
			report.data.table.clear().draw();
			if (!data) return;
			data.forEach((ev, i) => {
				report.data.table.row
					.add([
						report.components.text(i + 1),
						report.components.text(moment(ev.saledate).format("DD-MMM-YYYY")),
						report.components.text(
							`${ev.rowdata[0].amount} / ${formatCurrency(ev.rowdata[0].price)}`
						),
						report.components.text(
							`${ev.rowdata[1].amount} / ${formatCurrency(ev.rowdata[1].price)}`
						),
						report.components.text(
							`${ev.rowdata[2].amount} / ${formatCurrency(ev.rowdata[2].price)}`
						),
						report.components.text(
							`${ev.rowdata[3].amount} / ${formatCurrency(ev.rowdata[3].price)}`
						),
						report.components.text(
							`${ev.rowdata[4].amount} / ${formatCurrency(ev.rowdata[4].price)}`
						),
						report.components.text(formatCurrency(ev.pricetotal)),
					])
					.draw(false);
			});
		},
		async rendertableAll(data) {
			report.data.table2.clear().draw();
			if (!data) return;
			data.forEach((ev, i) => {
				if (ev.data.length > 0) {
					ev.data.forEach((e, index) => {
						report.data.table2.row
							.add([
								report.components.text(i + 1),
								report.components.text(ev.fullname),
								report.components.text(
									moment(e.saledate).format("DD-MMM-YYYY")
								),
								report.components.text(
									`${e.rowdata[0].amount} / ${formatCurrency(
										e.rowdata[0].price
									)}`
								),
								report.components.text(
									`${e.rowdata[1].amount} / ${formatCurrency(
										e.rowdata[1].price
									)}`
								),
								report.components.text(
									`${e.rowdata[2].amount} / ${formatCurrency(
										e.rowdata[2].price
									)}`
								),
								report.components.text(
									`${e.rowdata[3].amount} / ${formatCurrency(
										e.rowdata[3].price
									)}`
								),
								report.components.text(
									`${e.rowdata[4].amount} / ${formatCurrency(
										e.rowdata[4].price
									)}`
								),
								report.components.text(formatCurrency(e.pricetotal)),
							])
							.draw(false);
					});
				} else {
					console.log(1);
					report.data.table2.row
						.add([
							report.components.text(i + 1),
							report.components.text(ev.fullname),
							report.components.text("-"),
							report.components.text("-"),
							report.components.text("-"),
							report.components.text("-"),
							report.components.text("-"),
							report.components.text("-"),
							report.components.text(0),
						])
						.draw(false);
				}
			});
		},
	},
	ajax: {
		async get_data(data) {
			let url = site_url("reports/get_data");
			if (report.data.path == "sale_purchase_all") {
				url = site_url("reports/get_dataReport");
			}
			await $.ajax({
				type: "post",
				dataType: "json",
				url: url,
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: async (results) => {
					if (report.data.path == "sale_purchase_all") {
						await report.methods.rendertableAll(results.data);
					} else {
						await report.methods.rendertable(results.data);
					}
				},
			});
		},
	},
	async init() {
		this.jquery.main();
		if (this.data.path == "sale_purchase_all") {
			$("#tb-report2").css("display", "");
			$("#tb-report").css("display", "none");
			report.data.table2 = $("#tb-report2").DataTable({
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
				],
				order: [[0, "asc"]],
			});
		} else {
			report.data.table = $("#tb-report").DataTable({
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
				],
				order: [[0, "asc"]],
			});
			$("#tb-report2").css("display", "none");
			$("#tb-report").css("display", "");
		}
		$(document).on("click", "#show-filterbtn", (e) => {
			if ($("#showfilter")[0].style.display == "") {
				$("#showfilter").slideUp();
			} else {
				$("#showfilter").slideDown();
			}
		});
		$(document).on("click", ".show-all-rows", async (e) => {
			$(".dataTables_length select").val(-1).trigger("change");
		});

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

		$(document).on("click", "#search", async (e) => {
			$("#exportpdf").remove();
			let date_start = $("#date_start").val();
			let date_end = $("#date_end").val();
			let data = {
				date_start: date_start,
				date_end: date_end,
			};

			$(".all-report-wrapper .dt-buttons.btn-group").append(
				'<button class="btn btn-secondary " id="exportpdf" data-bs-toggle="modal" data-bs-target="#showpdfview" type="button"><span>PDF</span></button>'
			);
			await this.ajax.get_data(data);
		});
	},
};
report.init();
