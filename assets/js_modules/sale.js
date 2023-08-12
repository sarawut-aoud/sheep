const sale = {
	data: {
		rawsheeptype: [],
		dataweight: 0,
		dataprice: 0,
		dataamount: 0,
		table: "",
	},
	jquery: {
		main() {
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
		},
		async rendertable(data) {
			sale.data.table.clear().draw();
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
						sale.components.text(ev.saledate ? result : ""),
						sale.components.items(ev.rowdata),
						sale.components.text(formatCurrency(ev.pricetotal)),
					])
					.draw();
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
		async get_datasale() {
			await $.ajax({
				type: "post",
				dataType: "json",
				url: site_url("farm/get_datasale"),
				data: {
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						sale.methods.rendertable(results.data);
					}
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
			let value = obj.val();
			let type = obj.data("type");
			let amount = 0;
			let price = 0;
			let weight = 0;
			if (type == "weight") {
				weight = value;
			}
			if (type == "price") {
				price = value;
			}
			if (type == "amount") {
				amount = value;
			}
			if (content.data("action") == 1) {
				let total = weight * price;
				content.find(".total").val(formatCurrency(total));
			}
			if (content.data("action") == 2) {
				let total = amount * pricee;
				content.find(".total").val(formatCurrency(total));
			}
		});
	},
};
sale.init();
