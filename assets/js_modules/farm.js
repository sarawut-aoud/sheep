const farm = {
	data: {},
	components: {},
	Jquery: {
		main: () => {
			$(document).on("show.bs.offcanvas", "#updatefarm", async (e) => {
				$("#updatefarm")
					.after(` <div class="offcanvas-backdrop fade "></div>`)
					.fadeIn(300, () => {
						$(".offcanvas-backdrop").addClass("show");
					});
			});
			$(document).on("hidden.bs.offcanvas", "#updatefarm", async (e) => {
				$(`.offcanvas-backdrop`).fadeOut(300, () => {
					$(".offcanvas-backdrop").remove();
				});
			});
		},
	},
	methods: {},
	ajax: {},
	async inti() {
        this.Jquery.main()
    },
};
farm.inti();
