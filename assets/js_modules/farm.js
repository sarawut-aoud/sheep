const farm = {
	data: {
		rawsheeptype: null,
		rawdatafarm: [],
		action: "",
		famrid: "",
	},
	components: {
		content: (data) => {
			return `<div class="row mb-3 ">
						<div class="d-flex justify-content-end">
							<button type="button" class=" mb-3 btn btn-warning font-m" data-farm-id="${
								data.id
							}" data-action="update" data-bs-toggle="offcanvas" data-bs-target="#updatefarm" aria-controls="updatefarm">แก้ไขข้อมูลฟาร์ม</button>
						</div>
						<div class="row mb-3">
							<div class=" mb-3">
								<div class="v-label h-100  w-icon">
									<div class="icon">
										<i class="fas fa-warehouse"></i>
									</div>
									<div class="contents">
										<div class="label">ชื่อฟาร์ม</div>
										<div class="text-value">${data.farmname}</div>
									</div>
								</div>
							</div>
							<div class=" mb-3">
								<div class="v-label h-100  w-icon">
									<div class="icon">
										<i class="fas fa-tag"></i>
									</div>
									<div class="contents">
										<div class="label">เจ้าของฟาร์ม</div>
										<div class="text-value">${data.farmer}</div>
									</div>
								</div>
							</div>
							<div class=" mb-3">
								<div class="v-label h-100  w-icon">
									<div class="icon">
										<i class="fas fa-map-marker-alt"></i>
									</div>
									<div class="contents">
										<div class="label">ที่ตั้งฟาร์ม</div>
										<div class="text-value">${data.address} ${data.location}</div>
									</div>
								</div>
							</div>
							${farm.methods.rendersheep(data.sheep)}
						</div>	
					</div>
					<hr>
			`;
		},
	},
	Jquery: {
		main: () => {
			$(document).on("show.bs.offcanvas", "#updatefarm", async (e) => {
				let btn = $(e.relatedTarget);
				let action = btn.data("action");
				let id = btn.data("farm-id");
				farm.data.action = action;
				let text = action == "create" ? "เพิ่มข้อมูลฟาร์ม" : "แก้ไขข้อมูลฟาร์ม";
				$("#offcanvas-headerupdatefarm").text(text);
				if (action == "update") {
					farm.data.famrid = id;
					farm.ajax.get_farmbyid(id);
				}
				$("#updatefarm")
					.after(` <div class="offcanvas-backdrop fade "></div>`)
					.fadeIn(300, () => {
						$(".offcanvas-backdrop").addClass("show");
					});
			});
			$(document).on("hide.bs.offcanvas", "#updatefarm", async (e) => {
				$(`.offcanvas-backdrop`).fadeOut(10, () => {
					$(".offcanvas-backdrop").remove();
				});
				$("#farmname").val("");
				$("#farmername").val("");
				$("#address").val("");
				$("#province").val("").trigger("change");
				$("#amphoe").val("").trigger("change");
				$("#district").val("").trigger("change");
			});
			$(document).on("keypress", ".isNumberOnly", async (e) => {
				let input = $(e.target).val();

				if (input.length > 3) {
					return false;
				}
			});
		},
	},
	methods: {
		async loadinit() {
			await farm.ajax.loacation();
			await farm.ajax.getsheeptype();
			await farm.ajax.get_farm();
			await farm.methods.renderfarm(farm.data.rawdatafarm);
		},
		async renderfarm(data) {
			let item = "";
			if (!data) return;
			data.forEach((ev, i) => {
				item += farm.components.content(ev);
			});
			$("#show-content-detail-farm").html(item);
		},
		rendersheep(data) {
			let item = "";
			if (!data) return;
			data.forEach((ev, i) => {
				item += `<div class=" mb-3">
				<div class="v-label h-100  w-icon">
					<div class="icon">
						<i class="icon-sheep-icon"></i>
					</div>
					<div class="contents">
						<div class="label">${ev.typename}</div>
						<div class="text-value">${ev.sheep_count} ตัว</div>
					</div>
				</div>
			</div>`;
			});
			return item;
		},
		renderinputsheeptype: async (data) => {
			if (!data) return;
			let item = "";
			data.forEach((ev, i) => {
				item += `
				<div class="mb-3 ">
					<label for="sheep_type${ev.id}" class="form-label">จำนวน${ev.typename} <small>(ตัว)</small></label>
					<input type="text" class="form-control isNumberOnly sheeptype" data-type-id="${ev.id}" name=""  maxlength="3" id="sheep_type${ev.id}" min="0" max="100" data-type-id="${ev.id}"  placeholder="0">
				</div>
				`;
			});
			$("#show-sheeptype").html(item);
		},
		resetform() {
			$("#updatefarm input").each((i, ev) => {
				$(ev).val("");
			});
			$("#updatefarm textarea").each((i, ev) => {
				$(ev).val("");
			});
		},
	},
	ajax: {
		getsheeptype: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_typesheep"),
				success: (results) => {
					if (results.data) {
						farm.data.rawsheeptype = results.data;
					}
				},
			});
		},
		loacation: async () => {
			let district = [],
				amphoe = [],
				province = [];
			await $.ajax({
				method: "get",
				url: site_url("api/getlocation"),
				dataType: "json",
				success: function (results) {
					if (results.result.district) {
						district = results.result.district;
					}
					if (results.result.amphoe) {
						amphoe = results.result.amphoe;
					}

					province = [
						{
							id: "",
							text: "เลือก",
						},
					];
					if (results.result.province) {
						results.result.province.forEach((ev, i) => {
							province.push({
								id: ev.province_id,
								text: ev.nameTh,
							});
						});
					}
					$("#province").select2({
						data: province,
						dropdownParent: $("#updatefarm"),
					});
					$("#province").change(function () {
						var ar_amphoe = [
							{
								id: "",
								text: "เลือก",
							},
						];
						var proID = $("#province").find(":selected").val();
						for (var i = 0; i < amphoe.length; i++) {
							if (amphoe[i].province_id == proID) {
								ar_amphoe.push({
									id: amphoe[i].amphoe_id,
									text: amphoe[i].nameTh,
								});
							}
						}
						if (ar_amphoe.length > 0) {
							$("#amphoe").select2().empty();
						}
						$("#amphoe").select2({
							data: ar_amphoe,
							dropdownParent: $("#updatefarm"),
						});
					});

					$("#amphoe").change(function () {
						var amID = $("#amphoe").find(":selected").val();

						var ar_district = [
							{
								id: "",
								text: "เลือก",
							},
						];
						for (var i = 0; i < district.length; i++) {
							if (district[i].amphoe_id == amID) {
								ar_district.push({
									id: district[i].district_id,
									text: district[i].district_name_local,
								});
							}
						}

						if (ar_district.length > 0) {
							$("#district").select2().empty();
						}
						$("#district").select2({
							data: ar_district,
							dropdownParent: $("#updatefarm"),
						});
					});

					$("#district").change(function () {
						var theID = $("#district").find(":selected").val();

						for (var i = 0; i < district.length; i++) {
							if (district[i].district_id == theID) {
								$("#zipcode").val(district[i].zipcode);
							}
						}
					});

					$("#province").val($("#province").attr("value")).trigger("change");
					$("#amphoe").val($("#amphoe").attr("value")).trigger("change");
					$("#district").val($("#district").attr("value")).trigger("change");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					Swal.fire("Error Edit!", "Please try again", "error");
				},
			});
		},
		async savefarm() {
			let sheep = [];
			$(".sheeptype").each((i, ev) => {
				sheep.push({
					id: $(ev).data("type-id"),
					value: $(ev).val(),
				});
			});
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/savefarm"),
				data: {
					farmname: $("#farmname").val(),
					farmername: $("#farmername").val(),
					address: $("#address").val(),
					province: $("#province").val(),
					amphoe: $("#amphoe").val(),
					district: $("#district").val(),
					sheep: sheep,
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
							$("#updatefarm").offcanvas("hide");
							farm.methods.resetform();
							await farm.methods.loadinit();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาด",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
		async updatefarm(id) {
			let sheep = [];
			$(".sheeptype").each((i, ev) => {
				sheep.push({
					id: $(ev).data("type-id"),
					value: $(ev).val(),
				});
			});
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/updatefarm"),
				data: {
					farmid:id,
					farmname: $("#farmname").val(),
					farmername: $("#farmername").val(),
					address: $("#address").val(),
					province: $("#province").val(),
					amphoe: $("#amphoe").val(),
					district: $("#district").val(),
					sheep: sheep,
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
							$("#updatefarm").offcanvas("hide");
							farm.methods.resetform();
							await farm.methods.loadinit();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาด",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
		async get_farm() {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_farm"),
				success: (results) => {
					if (results.data) {
						farm.data.rawdatafarm = results.data;
					}
				},
			});
		},
		async get_farmbyid(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/get_farmbyid"),
				data: {
					id: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						let data = results.data;
						$("#farmname").val(data.farmname);
						$("#farmername").val(data.farmer);
						$("#address").val(data.address);
						$("#province").val(data.province_id).trigger("change");
						$("#amphoe").val(data.amphoe_id).trigger("change");
						$("#district").val(data.distirct_id).trigger("change");
					}
				},
			});
		},
	},
	async inti() {
		$(".select2").select2();
		await this.ajax.loacation();
		await this.ajax.getsheeptype();
		await this.ajax.get_farm();

		await this.methods.renderfarm(this.data.rawdatafarm);
		this.Jquery.main();

		$(document).on("click", "#save-farm-data", async (e) => {
			if (this.data.action == "create") {
				this.ajax.savefarm();
			} else {
				this.ajax.updatefarm(this.data.famrid);
			}
		});
	},
};
farm.inti();
