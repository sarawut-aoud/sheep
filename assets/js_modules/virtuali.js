const vir = {
	data: {
		backgroundColor: [
			"rgba(255, 99, 132)",
			"rgba(255, 159, 64)",
			"rgba(255, 205, 86)",
			"rgba(75, 192, 192)",
			"rgba(54, 162, 235)",
			"rgba(153, 102, 255)",
			"rgba(201, 203, 207)",
		],
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
		today: "",
		chart1: {
			init: null,
			data: [],
			label: [],
			color: [],
		},
		chart2: {
			init: null,
			data: [],
			label: [],
			color: [],
		},
		chart3: {
			init: null,
			data: [],
			label: [],
			color: [],
		},
		linechart: {
			init: null,
			data: [],
			label: [],
			color: [],
		},
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
			let data = vir.data.filterdate.filter((ev, i) => ev.text == "daynow")[0];
			$("#date_start").val(moment(data.value[0]).format("DD-MMM-YYYY"));
			$("#date_end").val(moment(data.value[1]).format("DD-MMM-YYYY"));
			$(document).on("click", ".btnfilter-data", async (e) => {
				let obj = $(e.target).closest(".btnfilter-data");
				$(".btnfilter-data").not(obj).removeClass("active");
				obj.addClass("active");
				let value = obj.data("action");
				if (value != "" && typeof value != "undefined") {
					let data = vir.data.filterdate.filter((ev, i) => ev.text == value)[0];
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
		itemcount(data, index) {
			let color = [
				"border-left-primary",
				"border-left-success",
				"border-left-primary",
				"border-left-danger",
			];
			return `<div class="col-xl-6 col-md-6 mb-2">
			<div class="card ${color[index]} shadow h-100 py-2 card-show-content">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="   text-uppercase mb-1">
								${data.typename}ทั้งหมด
							</div>
							<div class="h5 mb-0  text-gray-800">${data.count} ตัว</div>
						</div>
						<div class="col-auto">
							<i class="icon-sheep-icon fa-2x text-gray-300 animeted-zoom"></i>
						</div>
					</div>
				</div>
			</div>
		</div>`;
		},
	},
	methods: {
		months: (option = { count: 12 }) => {
			const month = [
				{ id: 1, name: "January" },
				{ id: 2, name: "February" },
				{ id: 3, name: "March" },
				{ id: 4, name: "April" },
				{ id: 5, name: "May" },
				{ id: 6, name: "June" },
				{ id: 7, name: "July" },
				{ id: 8, name: "August" },
				{ id: 9, name: "September" },
				{ id: 10, name: "October" },
				{ id: 11, name: "November" },
				{ id: 12, name: "December" },
			];
			let data = [];
			month.forEach((ev, idx) => {
				if (ev.id <= option.count) {
					data.push(ev.name);
				}
			});
			return data;
		},
		chart1: () => {
			let data = {
				labels: vir.data.chart1.label,
				datasets: [
					{
						data: vir.data.chart1.data,
						backgroundColor: vir.data.chart1.color,
						borderWidth: 1,
					},
				],
			};
			return data;
		},
		chart2: () => {
			let data = {
				labels: vir.data.chart2.label,
				datasets: [
					{
						data: vir.data.chart2.data,
						backgroundColor: vir.data.chart2.color,
						hoverOffset: 4,
					},
				],
			};
			return data;
		},
		chart3: () => {
			const data = vir.data.chart3.data;
			// const data = [
			// 	{ x: "Jan", sheep1: 100, sheep2: 50, sheep3: 50, sheep4: 1 },
			// 	{ x: "Feb", sheep1: 120, sheep2: 55, sheep3: 75, sheep3: 1 },
			// ];
			let item = {
				labels: vir.data.chart3.label,
				datasets: [
					{
						label: "แพะพ่อพันธุ์",
						data: data,
						parsing: {
							yAxisKey: "sheep1",
						},
					},
					{
						label: "แพะแม่พันธุ์",
						data: data,
						parsing: {
							yAxisKey: "sheep2",
						},
					},
					{
						label: "แพะขุน",
						data: data,
						parsing: {
							yAxisKey: "sheep3",
						},
					},
					{
						label: "แพะปลด",
						data: data,
						parsing: {
							yAxisKey: "sheep4",
						},
					},
					{
						label: "มูลแพะ",
						data: data,
						parsing: {
							yAxisKey: "sheep5",
						},
					},
				],
			};
			return item;
		},
		linechart: () => {
			let data = {
				labels: vir.data.linechart.label,
				datasets: [
					{
						label: "ยอดซื้อขายแพะขุน-มูลแพะ",
						data: vir.data.linechart.data,
						fill: false,
						borderColor: "rgba(75, 192, 192)",
						tension: 0.1,
					},
				],
			};
			return data;
		},
		settime(data) {
			const date = new Date(data);
			const result = date.toLocaleDateString("th-TH", {
				year: "numeric",
				month: "long",
				day: "numeric",
			});
			return result;
		},
	},
	loadchart: {
		async main() {
			vir.data.chart1.init = new Chart($("#myChart")[0], {
				type: "doughnut",
				data: vir.methods.chart1(),
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true,
						},
					},
				},
			});
			vir.data.chart2.init = new Chart($("#myChart2")[0], {
				type: "pie",
				data: vir.methods.chart2(),
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true,
						},
					},
				},
			});
			vir.data.chart3.init = new Chart($("#myChart3")[0], {
				type: "bar",
				data: vir.methods.chart3(),
				options: {
					responsive: true,
				},
			});
			vir.data.linechart.init = new Chart($("#line-chart")[0], {
				type: "line",
				data: vir.methods.linechart(),
				options: {
					responsive: true,
				},
			});
		},
	},
	ajax: {
		async get_countsheep(data) {
			vir.data.chart1.label = [];
			vir.data.chart1.data = [];
			vir.data.chart1.color = [];
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("reports/get_countsheep"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: async (results) => {
					let item = "";
					if (results.data) {
						let data = results.data;

						await data.forEach((ev, i) => {
							if (ev.count > 0) {
								vir.data.chart1.label.push(ev.typename);
								vir.data.chart1.data.push(ev.count);
								vir.data.chart1.color.push(vir.data.backgroundColor[i]);
							}
						});
						await data.forEach((ev, i) => {
							item += vir.components.itemcount(ev, i);
						});
					}

					$("#show-countitem").html(item);
				},
			});
		},
		async get_countsheep_gender(data) {
			vir.data.chart2.label = [];
			vir.data.chart2.data = [];
			vir.data.chart2.color = [];
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("reports/get_countsheep_gender"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						let data = results.data;
						vir.data.chart2.label = ["แพะเพศเมีย", "แพะเพศผู้"];
						vir.data.chart2.data.push(data.Females, data.Males);
						vir.data.chart2.color = [
							vir.data.backgroundColor[0],
							vir.data.backgroundColor[4],
						];
						$(".sheepall").text(
							parseInt(data.Females) + parseInt(data.Males) + " ตัว"
						);
					}
				},
			});
		},
		async get_sumprice(data) {
			vir.data.chart3.label = [];
			vir.data.chart3.data = [];

			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("reports/get_sumprice"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						let data = results.data;
						data.forEach((ev, i) => {
							vir.data.chart3.label.push(ev.x);
							vir.data.chart3.data.push(ev);
						});
					}
				},
			});
		},
		async get_sumtotalprice(data) {
			vir.data.linechart.label = [];
			vir.data.linechart.data = [];
			vir.data.linechart.color = [];
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("reports/get_sumtotalprice"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						let data = results.data;
						data.forEach((ev, i) => {
							vir.data.linechart.label.push(ev.month);
							vir.data.linechart.data.push(ev.sum);
						});
					}
				},
			});
		},
	},

	async init() {
		this.jquery.main();
		let data = {
			date_start: $("#date_start").val(),
			date_end: $("#date_end").val(),
		};
		$("#datetext").text(
			`ข้อมูลประจำวันที่ ${this.methods.settime(
				data.date_start
			)} ถึงวันที่ ${this.methods.settime(data.date_end)}`
		);
		await this.ajax.get_countsheep(data);
		await this.ajax.get_countsheep_gender(data);
		await this.ajax.get_sumprice(data);
		await this.ajax.get_sumtotalprice(data);

		await this.loadchart.main();

		$(document).on("click", "#show-filterbtn", (e) => {
			if ($("#showfilter")[0].style.display == "") {
				$("#showfilter").slideUp();
			} else {
				$("#showfilter").slideDown();
			}
		});
		$(document).on("click", "#search", async (e) => {
			let data = {
				date_start: $("#date_start").val(),
				date_end: $("#date_end").val(),
			};
			$("#datetext").text(
				`ข้อมูลประจำวันที่ ${this.methods.settime(
					data.date_start
				)} ถึงวันที่ ${this.methods.settime(data.date_end)}`
			);

			vir.data.chart1.init.destroy();
			vir.data.chart2.init.destroy();
			vir.data.chart3.init.destroy();
			vir.data.linechart.init.destroy();
			await this.ajax.get_countsheep(data);
			await this.ajax.get_countsheep_gender(data);
			await this.ajax.get_sumprice(data);
			await this.ajax.get_sumtotalprice(data);

			await this.loadchart.main();
		});
	},
};
vir.init();
