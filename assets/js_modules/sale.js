const sale = {
	data: {
		rawsheeptype: [],
		dataweight: 0,
		dataprice: 0,
		dataamount: 0,
		table: "",
		cal: {
			1: {
				w: 0,
				p: 0,
				a: 0,
			},
			2: {
				w: 0,
				p: 0,
				a: 0,
			},
			2: {
				w: 0,
				p: 0,
				a: 0,
			},
			3: {
				w: 0,
				p: 0,
				a: 0,
			},
			4: {
				w: 0,
				p: 0,
				a: 0,
			},
			5: {
				w: 0,
				p: 0,
				a: 0,
			},
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
			$(document).on("click", "#show-filterbtn", (e) => {
				if ($("#showfilter")[0].style.display == "") {
					$("#showfilter").slideUp();
				} else {
					$("#showfilter").slideDown();
				}
			});
			$(document).on("show.bs.offcanvas", "#createsale", async (e) => {
				let btn = $(e.relatedTarget);
				let action = btn.data("action");
				let id = btn.data("farm-id");
				let text =
					action == "create" ? "เพิ่มรายการซื้อ-ขาย" : "แก้ไขรายการซื้อ-ขาย";
				$("#offcanvas-head").text(text);
				if (action == "update") {
				}
				$("#createsale")
					.after(` <div class="offcanvas-backdrop fade "></div>`)
					.fadeIn(300, () => {
						$(".offcanvas-backdrop").addClass("show");
					});
			});
			$(document).on("hide.bs.offcanvas", "#createsale", async (e) => {
				$(`.offcanvas-backdrop`).fadeOut(10, () => {
					$(".offcanvas-backdrop").remove();
				});
			});
			let data = sale.data.filterdate.filter((ev, i) => ev.text == "daynow")[0];
			$("#date_start").val(moment(data.value[0]).format("DD-MMM-YYYY"));
			$("#date_end").val(moment(data.value[1]).format("DD-MMM-YYYY"));
			$(document).on("click", ".btnfilter-data", async (e) => {
				let obj = $(e.target).closest(".btnfilter-data");
				$(".btnfilter-data").not(obj).removeClass("active");
				obj.addClass("active");
				let value = obj.data("action");
				if (value != "" && typeof value != "undefined") {
					let data = sale.data.filterdate.filter(
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
		input(data) {
			let item = `
            <div class="input-contents typesheepid" data-type-id="${
							data.id
						}" data-action="${data.id == 5 ? 2 : 1}">
                <div class="text-contents">
                    ${data.typename}
                </div>
                <hr style="height: 2px;">
                <div class="d-flex gap-2 w-100 ">
                    <div class="mb-3  w-100">
                        <label for="" class="form-label">จำนวน</label>
                        <input type="text" name="" id="" class="form-control IsNumberOnly text-end amount" data-type="amount" placeholder="0">
                    </div>
                    <div class="mb-3  w-100">
                        <label for="" class="form-label">กิโลกรัม</label>
                        <input type="text" name="" id="" class="form-control IsNumberOnly  text-end weight" data-type="weight" placeholder="00.00">
                    </div>
                    <div class="mb-3  w-100">
                        <label for="" class="form-label">ราคา</label>
                        <input type="text" name="" id="" class="form-control IsNumberOnly  text-end price" data-type="price" placeholder="ราคา 0">
                    </div>
                   
                </div>  
                <div class="mb-3  w-100">
                    <input type="text" name="" id="" class="form-control IsNumberOnly  text-end total" placeholder="คำนวนอัตโนมัติ" readonly>
                </div>
            </div>
            `;
			$("#createsale .contents").append(item);
		},
		text(data) {
			return `<div class="text-ellipsis-scroll text-center"><span >${data}</span></div>`;
		},
		items(data) {
			let item = ` <div class="d-flex gap-2 w-100">`;
			data.forEach((ev, i) => {
				item += `
                <div class="contents-showdatable">
                    <div class="text-center">${ev.typename}</div>
                    <div class="d-flex gap-3">
                        <div class="contents-showdatable-item">
                            <div class="text-end">จำนวน</div>
                            <div class="text-end">${ev.amount}</div>
                        </div>
                        <div class="contents-showdatable-item">
                            <div class="text-end">กิโลกรัม</div>
                            <div class="text-end">${ev.weight}</div>
                        </div>
                        <div class="contents-showdatable-item">
                            <div class="text-end">ราคา</div>
                            <div class="text-end">
                            ${formatCurrency(ev.price)}
                            </div>
                        </div>
                        <div class="contents-showdatable-item">
                            <div class="text-end">รวม</div>
                            <div class="text-end">
                            ${formatCurrency(ev.pricetotal)}
                            </div>
                        </div>
                    </div>
                </div>
            `;
			});
			item += `</div>`;
			return item;
		},
	},
	methods: {
		resetform() {
			$("#createsale .contents input").each((i, ev) => {
				$(ev).val("");
			});
			for (const [key, value] of Object.entries(sale.data.cal)) {
				for (const [k, v] of Object.entries(sale.data.cal[key])) {
					sale.data.cal[key][k] = 0;
				}
			}
		},
		async rendertable(data) {
			sale.data.table.clear().draw(false);
			if (!data) return;
			data.forEach((ev, i) => {
				const date = new Date(ev.saledate);
				const result = date.toLocaleDateString("th-TH", {
					year: "numeric",
					month: "long",
					day: "numeric",
				});
				sale.data.table.row
					.add([
						sale.components.text(i + 1),
						sale.components.text(ev.saledate ? result : ""),
						sale.components.items(ev.rowdata),
						sale.components.text(formatCurrency(ev.pricetotal)),
					])
					.draw(false);
			});
		},
	},
	ajax: {
		getsheeptype: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_typesheep"),
				data: {
					data: "all",
				},
				success: (results) => {
					if (results.data) {
						results.data.forEach((ev, i) => {
							sale.components.input(ev);
						});
					}
				},
			});
		},
		async save() {
			let data = [];
			$("#createsale .contents .input-contents").each((i, ev) => {
				data.push({
					type_id: $(ev).data("type-id"),
					amount: $(ev).find(".amount").val(),
					weight: $(ev).find(".weight").val(),
					price: $(ev).find(".price").val(),
					date: $("#sale-date").val(),
					total: $(ev).find(".total").val(),
				});
			});
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/save_sale"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกข้อมูลสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							sale.methods.resetform();
							await sale.ajax.get_datasale();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาดในการบันทึก",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
		async get_datasale(data) {
			await $.ajax({
				type: "post",
				dataType: "json",
				url: site_url("farm/get_datasale"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					sale.methods.rendertable(results.data);
				},
			});
		},
	},
	async init() {
		this.data.table = $("#tb-sheepsale").DataTable({
			initComplete: function (settings) {
				initializeDataTables(settings);
			},
		});
		await this.ajax.get_datasale();
		await this.ajax.getsheeptype();
		$("#sale-date").datepicker({
			dateFormat: "dd-M-yy",
			changeMonth: true,
			changeYear: true,
			maxDate: 0,
		});

		this.jquery.main();
		$(document).on("click", "#save-sale", async (e) => {
			Swal.fire({
				title: "ยืนยันบันทึกข้อมูล",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "ตกลง",
				cancelButtonText: "ยกเลิก",
			}).then((result) => {
				if (result.isConfirmed) {
					this.ajax.save();
				}
			});
		});

		$(document).on("keyup", ".amount,.weight,.price", async (e) => {
			let obj = $(e.target).closest("input");
			let content = obj.closest(".input-contents");
			let value = parseFloat(obj.val() != "" ? obj.val() : 0);
			let type = obj.data("type");
			let action = content.data("type-id");
			let total = 0;
			switch (action) {
				case 1:
					if (type == "weight") {
						this.data.cal[1].w = value;
					}
					if (type == "price") {
						this.data.cal[1].p = value;
					}
					if (type == "amount") {
						this.data.cal[1].a = value;
					}
					total = this.data.cal[1].w * this.data.cal[1].p;
					break;
				case 2:
					if (type == "weight") {
						this.data.cal[2].w = value;
					}
					if (type == "price") {
						this.data.cal[2].p = value;
					}
					if (type == "amount") {
						this.data.cal[2].a = value;
					}
					total = this.data.cal[2].w * this.data.cal[2].p;
					break;
				case 3:
					if (type == "weight") {
						this.data.cal[3].w = value;
					}
					if (type == "price") {
						this.data.cal[3].p = value;
					}
					if (type == "amount") {
						this.data.cal[3].a = value;
					}
					total = this.data.cal[3].w * this.data.cal[3].p;
					break;
				case 4:
					if (type == "weight") {
						this.data.cal[4].w = value;
					}
					if (type == "price") {
						this.data.cal[4].p = value;
					}
					if (type == "amount") {
						this.data.cal[4].a = value;
					}
					total = this.data.cal[4].w * this.data.cal[4].p;
					break;
				case 5:
					if (type == "weight") {
						this.data.cal[5].w = value;
					}
					if (type == "price") {
						this.data.cal[5].p = value;
					}
					if (type == "amount") {
						this.data.cal[5].a = value;
					}
					total = this.data.cal[5].a * this.data.cal[5].p;
					break;
			}

			if (content.data("action") == 1) {
				content.find(".total").val(formatCurrency(total));
			}
			if (content.data("action") == 2) {
				content.find(".total").val(formatCurrency(total));
			}
		});
		$(document).on("click", "#search", async (e) => {
			let data = {
				date_start: $("#date_start").val(),
				date_end: $("#date_end").val(),
			};

			await this.ajax.get_datasale(data);
		});
	},
};
sale.init();
