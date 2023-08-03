const sheep = {
	data: {},
	components: {
		item(index) {
			return `
            <hr style="height:2px;">
            <div class="box-content page-rlt" data-index="${index}">
                 <div class="item-remove"><i class="fas fa-trash-alt"></i></div>
                        <div class="d-flex flex-column flex-lg-row gap-3 w-100 mb-3">
                            <div class="mb-3">
                                <label for="" class="form-label">รหัสแพะ</label>
                                <input type="text" name="" id="sheepcode_${index}" class="form-control sheepcode" placeholder="A001" aria-describedby="helpId">
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
                                <input type="text" name="" id="old_${index}" class="form-control old" placeholder="10" aria-describedby="helpId">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">น้ำหนัก (กก.)</label>
                                <input type="text" name="" id="weight_${index}" class="form-control weight" placeholder="00.00" aria-describedby="helpId">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="" class="form-label">ส่วนสูง (ซม.)</label>
                                <input type="text" name="" id="height_${index}" class="form-control height" placeholder="100" aria-describedby="">
                            </div>
                        </div>
                    </div>`;
		},
	},
	methods: {},
	ajax: {},
	async init() {
		$(document).on("click", "#addboxContent", async (e) => {
			let index = $(".box-content").length;
			$("#content-data").append(this.components.item(index));

			$(".box-content").last()[0].scrollIntoView({
				behavior: "smooth",
				block: "end",
				inline: "nearest",
			});
		});
		$(document).on("click", ".item-remove", async (e) => {
			let obj = $(e.target).closest(".item-remove");
			obj.closest(".box-content").remove();
			$("#content-data").find("hr").last().remove();
		});
		$(document).on("change", ".gender-type", async (e) => {
			let obj = $(e.target).closest(".gender-type");
			let index = obj.data("index");
			$(`.gender-type[data-index="${index}"]`).not(obj).prop("checked", false);
		});
	},
};
sheep.init();
