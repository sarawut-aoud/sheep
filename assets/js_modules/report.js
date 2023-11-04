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
		badge: {
			v1: [],
			v2: [],
			v3: [],
			v4: [],
			v5: [],
			m1: [],
			m2: [],
			m3: [],
			m4: [],
			m5: [],
			t: [],
		},
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
				report.data.table2.row
					.add([
						report.components.text(i + 1),
						report.components.text(ev.fullname),
						this.items(ev.data),
					])
					.draw(false);
			});
			$("#badge-item-v1").text(`${this.sum(report.data.badge.v1)} ตัว`);
			$("#badge-item-v2").text(`${this.sum(report.data.badge.v2)} ตัว`);
			$("#badge-item-v3").text(`${this.sum(report.data.badge.v3)} ตัว`);
			$("#badge-item-v4").text(`${this.sum(report.data.badge.v4)} `);
			$("#badge-item-v5").text(`${this.sum(report.data.badge.v5)} ตัว`);
			$("#badge-item-m1").text(
				`${formatCurrency(this.sum(report.data.badge.m1))}`
			);
			$("#badge-item-m2").text(
				`${formatCurrency(this.sum(report.data.badge.m2))}`
			);
			$("#badge-item-m3").text(
				`${formatCurrency(this.sum(report.data.badge.m3))}`
			);
			$("#badge-item-m4").text(
				`${formatCurrency(this.sum(report.data.badge.m4))}`
			);
			$("#badge-item-m5").text(
				`${formatCurrency(this.sum(report.data.badge.m5))}`
			);
			$("#badge-item-t").text(
				`${formatCurrency(this.sum(report.data.badge.t))}`
			);
		},
		items(data) {
			let item = `<div class="d-flex flex-column gap-2">`;
			item += `<div class="d-item item-header">
						<div class="item-topic">วัน เดือน ปี</div>
						<div class="d-flex flex-column gap-1 item-topic">
							<div>พ่อพันธุ์</div>
							<div><small>จำนวน / รวม</small></div>
						</div>
						<div class="d-flex flex-column gap-1 item-topic">
							<div>แม่พันธุ์ </div>
							<div><small>จำนวน / รวม</small></div>
						</div>
						<div class="d-flex flex-column gap-1 item-topic">
							<div>แพะปลด พ่อ-แม่</div>
							<div><small>จำนวน / รวม</small></div>
						</div>
						<div class="d-flex flex-column gap-1 item-topic">
							<div>แพะขุน</div>
							<div><small>จำนวน / รวม</small></div>
						</div>
						<div class="d-flex flex-column gap-1 item-topic">
							<div>มูลแพะ</div>
							<div><small>จำนวน / รวม</small></div>
						</div>
						<div>รวมเงิน(บาท)</div>
					</div>`;
			if (data.length > 0) {
				let value1 = [];
				let value2 = [];
				let value3 = [];
				let value4 = [];
				let value5 = [];
				let m1 = [];
				let m2 = [];
				let m3 = [];
				let m4 = [];
				let m5 = [];
				let total = [];
				item += `<div class="d-list-item">`;
				data.forEach((ev, index) => {
					report.data.badge.v1.push(parseFloat(ev.rowdata[0].amount));
					report.data.badge.v2.push(parseFloat(ev.rowdata[1].amount));
					report.data.badge.v3.push(parseFloat(ev.rowdata[2].amount));
					report.data.badge.v4.push(parseFloat(ev.rowdata[3].amount));
					report.data.badge.v5.push(parseFloat(ev.rowdata[4].amount));
					report.data.badge.m1.push(parseFloat(ev.rowdata[0].price));
					report.data.badge.m2.push(parseFloat(ev.rowdata[1].price));
					report.data.badge.m3.push(parseFloat(ev.rowdata[2].price));
					report.data.badge.m4.push(parseFloat(ev.rowdata[3].price));
					report.data.badge.m5.push(parseFloat(ev.rowdata[4].price));
					report.data.badge.t.push(parseFloat(ev.pricetotal));

					value1.push(parseFloat(ev.rowdata[0].amount));
					m1.push(parseFloat(ev.rowdata[0].price));

					value2.push(parseFloat(ev.rowdata[1].amount));
					m2.push(parseFloat(ev.rowdata[2].price));

					value3.push(parseFloat(ev.rowdata[3].amount));
					m3.push(parseFloat(ev.rowdata[3].price));

					value4.push(parseFloat(ev.rowdata[3].amount));
					m4.push(parseFloat(ev.rowdata[3].price));

					value5.push(parseFloat(ev.rowdata[4].amount));
					m5.push(parseFloat(ev.rowdata[4].price));

					total.push(parseFloat(ev.pricetotal));

					item += `<div class="d-item list-item">
								<div>${moment(ev.saledate).format("DD-MMM-YYYY")}</div>
								<div class="d-flex flex-column gap-1">
									<div class="text-end">${ev.rowdata[0].amount} / ${formatCurrency(
						ev.rowdata[0].price
					)}</div>
								</div>
								<div class="d-flex flex-column gap-1">
									<div class="text-end">${ev.rowdata[1].amount} / ${formatCurrency(
						ev.rowdata[1].price
					)}</div>
								</div>
								<div class="d-flex flex-column gap-1">
									<div class="text-end">${ev.rowdata[2].amount} / ${formatCurrency(
						ev.rowdata[2].price
					)}</div>
								</div>
								<div class="d-flex flex-column gap-1">
									<div class="text-end">${ev.rowdata[3].amount} / ${formatCurrency(
						ev.rowdata[3].price
					)}</div>
								</div>
								<div class="d-flex flex-column gap-1">
									<div class="text-end">${ev.rowdata[4].amount} / ${formatCurrency(
						ev.rowdata[4].price
					)}</div>
								</div>
								<div>${formatCurrency(ev.pricetotal)}</div>
							</div>`;
				});
				item += `<div class="d-item ">
						<div>ยอดรวม</div>
						<div class=" list-item">
							${this.sum(value1)} / ${formatCurrency(this.sum(m1))}
						</div>
						<div class=" list-item ">
							${this.sum(value2)} / ${formatCurrency(this.sum(m2))}
						</div>
						<div class=" list-item">
							${this.sum(value3)} / ${formatCurrency(this.sum(m3))}
						</div>
						<div class=" list-item">
							${this.sum(value4)} / ${formatCurrency(this.sum(m4))}
						</div>
						<div class=" list-item">
							${this.sum(value5)} / ${formatCurrency(this.sum(m5))}
						</div>
						<div class="list-item">${formatCurrency(this.sum(total))}</div>
				</div>`;
				item += `</div>`;
			} else {
				item += `<div class="d-item-nodata">
							<div><i class="fas fa-database"></i> ไม่มีข้อมูล</div>
					  	</div>`;
			}
			item += `</div>`;
			return item;
		},
		sum(myNums) {
			return myNums.reduce((accumulator, currentValue) => {
				return accumulator + currentValue;
			}, 0);
		},
	},
	ajax: {
		async get_data(data) {
			report.data.badge.v1 = [];
			report.data.badge.v2 = [];
			report.data.badge.v3 = [];
			report.data.badge.v4 = [];
			report.data.badge.v5 = [];
			report.data.badge.m1 = [];
			report.data.badge.m2 = [];
			report.data.badge.m3 = [];
			report.data.badge.m4 = [];
			report.data.badge.m5 = [];
			report.data.badge.t = [];
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
				// dom: "<'all-report-wrapper'<'left col-sm-12 col-12'Bl><'right'f>>rtip",
				// // "bPaginate": false,
				// buttons: [
				// 	{
				// 		extend: "excel",

				// 		title: $(`tb-report`).data("title"),
				// 		customize: function (xlsx) {
				// 			var sheet = xlsx.xl.worksheets["sheet1.xml"];
				// 			$(
				// 				'row c[r^="A"], row c[r^="B"], row c[r^="C"], row c[r^="D"],row c[r^="E"],row c[r^="F"],row c[r^="G"],row c[r^="H"]',
				// 				sheet
				// 			).attr("s", "51");
				// 		},
				// 	},
				// ],
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
