const sheep = {
	data: {
		table: null,
		rawsheeptype: [],
		rawfarm: [],
		sheepid: "",
	},
	methods: {},
	components: {
		gender(data) {
			let icon = "";
			let type = "";
			if (data == "1") {
				icon = '<i class="fas fa-mars text-primary"></i> ';
				type = "ผู้";
			} else {
				icon = '<i class="fas fa-venus text-danger"></i> ';
				type = "เมีย";
			}
			return `${icon} เพศ ${type}`;
		},
		action(data) {
			let item = `
            <div class="d-flex gap-2">
                <button data-bs-toggle="offcanvas" data-bs-target="#update_sheep" aria-controls="update_sheep" type="button" class="btn btn-warning" id="update-data" data-sid="${data.s_id}" title="แก้ไขข้อมูล"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger" id="deletedata" data-sid="${data.s_id}" title="ลบข้อมูล" ><i class="fas fa-trash"></i></button>
            </div>
            `;
			return item;
		},
	},
	ajax: {
		async getall() {
			await $.ajax({
				type: "GET",
				dataType: "json",
				url: site_url("farm/getall"),
				success: (results) => {
					sheep.data.table.clear().draw();
					if (results.data) {
						let data = results.data;
						data.forEach((ev, i) => {
							sheep.data.table.row
								.add([
									ev.sheepcode,
									ev.sheepname,
									sheep.components.gender(ev.gender),
									ev.old + " เดือน",
									ev.weight + " ก.ก.",
									ev.height + " ซ.ม.",
									ev.typename,
									ev.farmname,
									sheep.components.action(ev),
								])
								.draw();
						});
					}
				},
			});
		},
		async delete(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/deletesheep"),
				data: {
					sid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "ลบข้อมูลแพะเรียบร้อย",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							await sheep.ajax.getall();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาดในการลบข้อมูล",
							showConfirmButton: false,
							timer: 1500,
						});
						location.reload();
					}
				},
			});
		},
		getsheeptype: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_typesheep"),
				success: (results) => {
					if (results.data) {
						results.data.forEach((ev, i) => {
							sheep.data.rawsheeptype.push({
								id: ev.id,
								text: ev.typename,
							});
						});
					}
					$("#type-id").select2({
						data: sheep.data.rawsheeptype,
						dropdownParent: $("#update_sheep").parent(),
					});
				},
			});
		},
		get_farmlist: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_farmlist"),
				success: (results) => {
					if (results.data) {
						results.data.forEach((ev, i) => {
							sheep.data.rawfarm.push({
								id: ev.id,
								text: ev.farmname,
							});
						});
					}
					$("#farm-id").select2({
						data: sheep.data.rawfarm,
						dropdownParent: $("#update_sheep").parent(),
					});
				},
			});
		},
		async getsheepid(id) {
			$(`.gender-type`).prop("checked", false);
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/getsheepid"),
				data: {
					sid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},

				success: (results) => {
					if (results.data) {
						let data = results.data;
						$("#sheepcode").val(data.sheepcode);
						$("#sheepname").val(data.sheepname);
						$(`.gender-type[value="${data.gender}"]`).prop("checked", true);
						$("#old").val(data.old);
						$("#weight").val(data.weight);
						$("#height").val(data.height);
						$("#type-id").val(data.sheep_type).trigger("change");
						$("#farm-id").val(data.farm_id).trigger("change");
					}
				},
			});
		},
		async update() {
			let btn = $("#savesheep");
			loading_on(btn);
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/sheepupdate"),
				data: {
					sid: sheep.data.sheepid,
					sheepcode: $(`#sheepcode`).val(),
					sheepname: $(`#sheepname`).val(),
					sheeptype: $(`#type-id`).val(),
					farm: $(`#farm-id`).val(),
					gender: $(`.gender-type:checked`).val(),
					old: $(`#old`).val(),
					weight: $(`#weight`).val(),
					height: $(`#height`).val(),
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							await sheep.ajax.getall();
							$("#update_sheep").offcanvas("hide");
							$("#update_sheep input:not(.gender-type)").each((i, ev) => {
								$(ev).val("");
							});
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาด",
							showConfirmButton: false,
							timer: 1500,
						});
						location.reload();
					}
					loading_on_remove(btn);
				},
			});
		},
	},
	async init() {
		await this.ajax.get_farmlist();
		await this.ajax.getsheeptype();
		this.data.table = $("#tb-viewsheep").DataTable();
		await this.ajax.getall();
		$(document).on("click", "#deletedata", async (e) => {
			let btn = $(e.target);
			let id = btn.data("sid");
			Swal.fire({
				icon: "info",
				title: "ต้องการลบข้อมูลแพะหรือไม่ ?",
				showCancelButton: true,
				confirmButtonText: "ตกลง",
				cancelButtonText: `ยังก่อน`,
			}).then(async (result) => {
				if (result.isConfirmed) {
					await this.ajax.delete(id);
				}
			});
		});
		$(document).on("show.bs.offcanvas", "", async (e) => {
			let btn = $(e.relatedTarget);
			let id = btn.data("sid");
			this.data.sheepid = id;
			await this.ajax.getsheepid(id);
		});
		$(document).on("change", ".gender-type", async (e) => {
			let obj = $(e.target).closest(".gender-type");
			$(`.gender-type`).not(obj).prop("checked", false);
		});
		$(document).on("click", "#btnupdate_sheep", async (e) => {
			Swal.fire({
				icon: "info",
				title: "ยืนยันแก้ไขข้อมูล ?",
				showCancelButton: true,
				confirmButtonText: "ตกลง",
				cancelButtonText: `ยกเลิก`,
			}).then(async (result) => {
				if (result.isConfirmed) {
					await this.ajax.update();
				}
			});
		});
	},
};
sheep.init();
