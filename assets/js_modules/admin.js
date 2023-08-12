const admin = {
	data: {
		table: "",
	},
	components: {
		text(data) {
			let text = data ? data : "-";
			return `<div class="text-ellipsis-scroll"><span>${text}</span></div>`;
		},
		action(data) {
			return `<button class="btn btn-warning" id="update_level" data-pd-id="${data.pd_id}"><i class="fas fa-user-cog"></i></button>`;
		},
		copylink(data) {
			return `
                <div class="d-flex flex-column gap-2 justify-content-center">
                    <div>คัดลอกลิงค์สำเร็จ</div>
                    <div class="content-copylink">
                        <div class="text-value">${data}</div>
                    </div>
                </div>
                   `;
		},
	},
	methods: {
		async renderTable(data) {
			admin.data.table.clear().draw();
			if (!data) return;
			data.forEach((ev, i) => {
				admin.data.table.row
					.add([
						admin.components.text(i + 1),
						admin.components.text(ev.fullname),
						admin.components.text(ev.phone),
						admin.components.text(ev.email),
						admin.components.action(ev),
					])
					.draw();
			});
		},
	},
	ajax: {
		async get_person() {
			await $.ajax({
				type: "GET",
				dataType: "json",
				url: site_url("admin/Setting/get_person"),
				success: async (results) => {
					if (results.data) {
						await admin.methods.renderTable(results.data.data);
						$("#countperson").text(results.data.count);
					}
				},
			});
		},
		async updatelevel(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				data: {
					pdid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				url: site_url("admin/Setting/updatelevel"),
				success: async (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							await admin.ajax.get_person();
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
	},
	async init() {
		this.data.table = $("#tbperson").DataTable({
			initComplete: function (settings) {
				initializeDataTables(settings);
			},
		});
		await this.ajax.get_person();
		$(document).on("click", "#copy-link", async (e) => {
			let btn = $(e.target).closest("#copy-link");
			let link = btn.data("link");
			Swal.fire({
				icon: "success",
				html: this.components.copylink(link),
				showConfirmButton: false,
			});
			navigator.clipboard.writeText(link);
		});
		$(document).on("click", ".content-copylink", async (e) => {
			$(e.target).closest(".content-copylink").addClass("active");
		});
		$(document).on("click", "#update_level", async (e) => {
			let btn = $(e.target).closest("#update_level");
			let pd_id = btn.data("pd-id");
			Swal.fire({
				title: "ยืนยันการให้สิทธิ์ Admin",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "ยืนยัน",
				cancelButtonText: "ยกเลิก",
			}).then((result) => {
				if (result.isConfirmed) {
					this.ajax.updatelevel(pd_id);
				}
			});
		});
	},
};
admin.init();
