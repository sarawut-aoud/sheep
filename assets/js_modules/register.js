const regis = {
	data: {},
	methods: {
		addrequest: (tag) => {
			$(tag).addClass("request");
			$(tag).focus();
		},
		removeRequest: (tag) => {
			$(tag).val().length > 0
				? $(tag).removeClass("request")
				: $(tag).addClass("request");
		},
		checkinput: () => {
			let check = true;
			if (!$("#firstname").val()) {
				Swal.fire({
					icon: "error",
					title: `กรอกชื่อ`,
					showConfirmButton: false,
					timer: 1500,
				}).then(() => {
					regis.methods.addrequest("#firstname");
				});

				check = false;
			}
			return check;
		},
	},
	ajax: {
		register: async () => {
			let chk = regis.methods.checkinput();
			loading_on($("#btnregister"));
			if (chk) {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("process/register"),
					data: {
						title: $("#title").val(),
						firstname: $("#firstname").val(),
						lastname: $("#lastname").val(),
						email: $("#email").val(),
						username: $("#username").val(),
						password: $("#password").val(),
						csrf_token_ci_gen: $.cookie(csrf_cookie_name),
					},
					success: (results) => {
						if (results.status) {
							Swal.fire({
								icon: "success",
								title: results.data,
								showConfirmButton: false,
								timer: 1500,
							}).then(() => {
								window.location.href = base_url("home");
							});
						}
					},
				});
				loading_on_remove($("#btnregister"));
			}
			loading_on_remove($("#btnregister"));
		},
	},
	async init() {
		$(document).on("click", "#btnregister", async (e) => {
			await this.ajax.register();
		});
		$(document).on("keyup focus", ".input-form input", async (e) => {
			this.methods.removeRequest($(e.target));
		});
	},
};
regis.init();
