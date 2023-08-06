const sheep = {
	data: {
		rawsheeptype: [],
		rawfarm: [],
	},
	components: {
		item(index) {
			let item = `
            <hr style="height:2px;">
            <div class="box-content page-rlt" data-index="${index}">
                 <div class="item-remove"><i class="fas fa-trash-alt"></i></div>
                        <div class="d-flex flex-column flex-lg-row gap-3 w-100 mb-3">
                            <div class="mb-3">
                                <label for="" class="form-label">รหัสแพะ</label>
                                <input type="text" name="" id="sheepcode_${index}" maxlength="10" class="form-control sheepcode" placeholder="A001" aria-describedby="helpId">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ชื่อแพะ</label>
                                <input type="text" name="" id="sheepname_${index}" class="form-control sheepname" placeholder="ชื่อแพะ" aria-describedby="helpId">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ประเภทแพะ</label>
                                <select name="" id="sheeptype_${index}" class="form-control select2 sheeptype"></select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">ฟาร์มต้นทาง</label>
                                <select name="" id="farmselect_${index}" class="form-control select2 farmselect"></select>
                            </div>
                        </div>

                        <div class="d-flex gap-3 w-100 mb-3">
                            <div class="form-check d-flex gap-2">
                                <input class="form-check-input gender-type" data-index="${index}" type="checkbox" value="1" id="male_${index}">
                                <label class="form-check-label" for="male_${index}">
                                    ตัวผู้
                                </label>
                            </div>
                            <div class="form-check d-flex gap-2">
                                <input class="form-check-input gender-type" data-index="${index}" type="checkbox" value="2" id="female_${index}">
                                <label class="form-check-label" for="female_${index}">
                                    ตัวเมีย
                                </label>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-lg-row gap-3 w-100">
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">อายุ (เดือน)</label>
                                <input type="text" name="" id="old_${index}" class="form-control old isNumberOnly"  placeholder="10" aria-describedby="helpId">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">น้ำหนัก (กก.)</label>
                                <input type="text" name="" id="weight_${index}" class="form-control weight isNumberOnly" placeholder="00.00" aria-describedby="helpId">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">ส่วนสูง (ซม.)</label>
                                <input type="text" name="" id="height_${index}" class="form-control height isNumberOnly" placeholder="100" aria-describedby="">
                            </div>
                        </div>
                    </div>`;
			$("#content-data").append(item);
			sheep.methods.rendertype(index, sheep.data.rawsheeptype);
			sheep.methods.renderfarm(index, sheep.data.rawfarm);
		},
	},
	methods: {
		rendertype(row, data) {
			$(`#sheeptype_${row}`).select2({
				placeholder: "เลือกประเภทแพะ",
				data: data,
			});
		},
		renderfarm(row, data) {
			$(`#farmselect_${row}`).select2({
				placeholder: "เลือกฟาร์มต้นทาง",
				data: data,
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
						results.data.forEach((ev, i) => {
							sheep.data.rawsheeptype.push({
								id: ev.id,
								text: ev.typename,
							});
						});
					}
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
				},
			});
		},
		async save() {
			let data = [];
			let chk = true;
			let msg = "";
			$(`.sheepcode`).each((i, ev) => {
				if ($(ev).val() == "") {
					msg += `<br> -  โปรดกรอกข้อมูลรหัสแพะช่องที่ ${i + 1}`;
					chk = false;
					return;
				}
			});
			$(`.sheepname`).each((i, ev) => {
				if ($(ev).val() == "") {
					msg += `<br> - โปรดกรอกข้อมูลชื่อแพะช่องที่ ${i + 1}`;
					chk = false;
					return;
				}
			});

			$(".box-content").each((i, ev) => {
				data.push({
					sheepcode: $(`#sheepcode_${i}`).val(),
					sheepname: $(`#sheepname_${i}`).val(),
					sheeptype: $(`#sheeptype_${i}`).val(),
					farm: $(`#farmselect_${i}`).val(),
					gender: $(`.gender-type[data-index='${i}']:checked`).val(),
					old: $(`#old_${i}`).val(),
					weight: $(`#weight_${i}`).val(),
					height: $(`#height_${i}`).val(),
				});
			});
			loading_on($("#savesheep"));
			if (chk) {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("farm/savesheep"),
					data: {
						data,
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
								location.reload();
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
						loading_on_remove($("#savesheep"));
					},
				});
			} else {
				Swal.fire({
					icon: "error",
					title: `เกิดข้อผิดพลาดยังกรอกข้อมูลไม่ครบ<br>${msg}`,
					showConfirmButton: false,
					timer: 1500,
				});
			}

			loading_on_remove($("#savesheep"));
		},
	},
	async init() {
		await this.ajax.getsheeptype();
		await this.ajax.get_farmlist();
		this.methods.rendertype(0, this.data.rawsheeptype);
		this.methods.renderfarm(0, this.data.rawfarm);
		$(document).on("click", "#addboxContent", async (e) => {
			let index = $(".box-content").length;
			this.components.item(index);

			$(".box-content").last()[0].scrollIntoView({
				behavior: "smooth",
				block: "end",
				inline: "nearest",
			});
		});
		$(document).on("click", ".item-remove", async (e) => {
			let obj = $(e.target).closest(".item-remove");
			obj.closest(".box-content").slideUp(300, () => {
				obj.closest(".box-content").remove();
				$("#content-data").find("hr").last().remove();
			});
		});
		$(document).on("change", ".gender-type", async (e) => {
			let obj = $(e.target).closest(".gender-type");
			let index = obj.data("index");
			$(`.gender-type[data-index="${index}"]`).not(obj).prop("checked", false);
		});
		$(document).on("click", "#savesheep", async (e) => {
			this.ajax.save();
		});
	},
};
sheep.init();
