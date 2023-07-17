const regis = {
	data: {},
	methods: {
		checkinput: () => {
			let check = true;

			return check;
		},
	},
	ajax: {
		register: async () => {
			let chk = regis.methods.checkinput();
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
							}).then(()=>{
                                window.location.href = base_url('home')
                            });
						}
					},
				});
			}
		},
	},
	async init() {
		$(document).on("click", "#btnregister", async (e) => {
			await this.ajax.register();
		});
	},
};
regis.init();
