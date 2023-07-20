const profile = {
	data: {
		pd_id: $("#pd_id").val(),
	},
	components: {},
	methods: {},
	ajax: {},
	async init() {
		$(document).on("click", ".box-camera-image", async (e) => {
           
			if (!mobile) {
				$("#upload-picture").modal("show");
			}else{
				$("#upload-picture").offcanvas("toggle");

            }
		});
	},
};
profile.init();
