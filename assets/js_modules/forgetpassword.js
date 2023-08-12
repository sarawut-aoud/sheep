const fg = {
	data: {},
	methods: {},
	ajax: {
		async checkemail(value) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("process/checkemail"),
				data: {
					email: value,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (!results.status) {
						Swal.fire({
							icon: "info",
							title: results.msg,
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
		async forgetpassword() {
			await $.ajax({
				type: "",
				dataType: "json",
				url: site_url("Home/sendforgetpassword"),
				data: {
					email: $("#email").val(),
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {},
			});
		},
	},
	async init() {
		$(document).on("blur", "#email", async (e) => {
			this.ajax.checkemail($(e.target).val());
		});
		$(document).on("click", "#sendemail", async (e) => {
			this.ajax.forgetpassword();
		});
	},
};
fg.init();
