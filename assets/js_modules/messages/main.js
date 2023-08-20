import { emoji } from "./emoji.js";
const message = {
	data: {
		image: base_url("/assets/images/blank_person.jpg"),
	},
	methods: {},
	components: {
		main: () => {
			let item = `
            <div id="chat-messages">
                <div class="content-message">
                    <div class="content-bar">
                        <div class="person">
                            <div class="all-person">
            
                            </div>
                        </div>
                    </div>
            
                    <div class="content-person ">
            
                        <div class="person-item">
                            <div class="image-person"><img src="${message.data.image}"></div>
                            <div class="text new">
                                <div class="name">Sarawut Aoudkla</div>
                                <div class="sub-text">
                                    <div class="messages">มีอะไรหรอป่าว</div>
                                    <div class="time-content">22:42</div>
                                </div>
                            </div>
                        </div>
                        <div class="person-item">
                            <div class="image-person"><img src="${message.data.image}"></div>
                            <div class="text">
                                <div class="name">Sarawut Aoudkla</div>
                                <div class="sub-text">
                                    <div class="messages">มีอะไรหรอป่าว</div>
                                    <div class="time-content">22:42</div>
                                </div>
                            </div>
                        </div>
            
                    </div>
                </div>
            </div>
            `;
			return item;
		},
		messagelist: async () => {
			let item = `
            <div class="content-bar page-rtl">
                <div class="person">
                    <div class="all-person">
                    </div>
                </div>
            </div>
    
            <div class="content-person ">
    
                <div class="person-item">
                    <div class="image-person"><img src="${message.data.image}"></div>
                    <div class="text new">
                        <div class="name">Sarawut Aoudkla</div>
                        <div class="sub-text">
                            <div class="messages">มีอะไรหรอป่าว</div>
                            <div class="time-content">22:42</div>
                        </div>
                    </div>
                </div>
                <div class="person-item">
                    <div class="image-person"><img src="${message.data.image}"></div>
                    <div class="text">
                        <div class="name">Sarawut Aoudkla</div>
                        <div class="sub-text">
                            <div class="messages">มีอะไรหรอป่าว</div>
                            <div class="time-content">22:42</div>
                        </div>
                    </div>
                </div>
    
            </div>
    `;
			return item;
		},
		messagebyid: async () => {
			let item = `<div class="content-bar page-rtl">
            <div class="back" id="backtolist"><i class="fas fa-bars"></i></div>
            <div class="image">
                <img src="${message.data.image}">
                <div class="status"></div>
            </div>
            <div class="text">
                <div class="sub-text font--xl">Sarawut Aoudkla</div>
                <div class="sub-text font--md">Today at 11:00</div>
            </div>
        </div>

        <div class="content-chat page-rtl">
            <div class="chat">
                <div class="today">
                    <div class="text">Today at 12:30</div>
                </div>
                <div class="messages">
                    <div class="content-messages">
                        <div class="d-flex gap-2 align-items-end justify-content-end">
                            <div class="read-right "><i class="fas fa-check"></i></div>
                            <div class="messages--shadow m-right">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Dolorem aspernatur sit 👋🏻👋🏻
                            </div>
                        </div>
                        <div class="time-right">13:24</div>
                    </div>
                    <div class="content-messages">
                        <div class="d-flex gap-2 align-items-end">
                            <div class="messages--shadow m-left">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Dolorem aspernatur sit 🤣🤣
                            </div>
                        </div>

                        <div class="time-left">13:25</div>
                    </div>
                    <div class="content-messages">
                        <div class="d-flex gap-2 align-items-end justify-content-end">
                            <div class="messages--shadow m-right">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                Dolorem aspernatur sit 👋🏻👋🏻
                            </div>
                        </div>

                        <div class="time-right">13:25</div>
                    </div>
                    <div class="content-messages">

                        <div class="messages--shadow m-left">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Dolorem aspernatur sit 🤣🤣
                        </div>
                        <div class="time-left">13:30</div>

                    </div>
                    <div class="content-messages">
                            <div class="messages--shadow m-left ">
                                <div class="typing">
                                    <i class="fas fa-circle animetion--1"></i>
                                    <i class="fas fa-circle animetion--2"></i>
                                    <i class="fas fa-circle animetion--3"></i>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-input">
            <div class="content-option-left">
                <div class="icon"><i class="fas fa-camera"></i></div>
                <div class="icon showEmoji"><i class="fas fa-laugh-beam"></i></div>
                <div class="icon fileclip"><i class="fas fa-paperclip"></i>
                    <input type="file" hidden id="file-input"  accept="image/*,.pdf">
                    </div>
            </div>
            <div class="data-input">
                <div contenteditable="true" type="text" class="form-control input-message" id="chat_message"
                    required placeholder="Type your message !"></div>
            </div>
            <div class="content-option-right">
                <div class="icon " id="sendmessage"><i class="fas fa-paper-plane"></i></div>
                <div class="icon d-none"><i class="fas fa-microphone"></i></div>
            </div>
        </div>`;
			return item;
		},
	},
	ajax: {
		getperson: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("message/getperson"),
				success: (results) => {
					let item = "";
					if (results.data) {
						let data = results.data;
						data.forEach((ev, i) => {
							let img = ev.picture ? base_url(ev.picture) : message.data.image;
							item += ` <div data-pd-id="${ev.pd_id}" class="images"><img src="${img}">  </div>`;
						});
					}
					$(".person .all-person ").html(item);
				},
			});
		},
		async get_messageid(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url(),
				data: {
					pd_id: id,
				},
				success: (results) => {},
			});
		},
	},
	async init() {
		await this.ajax.getperson();
		let item1 = "";
		for (let i = 0; i < 10; i++) {
			item1 += ` <div class="person-item page-rtl">
                        <div class="image-person"><img src="${message.data.image}"></div>
                        <div class="text new">
                            <div class="name">Sarawut Aoudkla</div>
                            <div class="sub-text">
                                <div class="messages">มีอะไรหรอป่าว</div>
                                <div class="time-content">22:42</div>
                            </div>
                        </div>
                    </div>
                    <div class="person-item page-rtl">
                        <div class="image-person"><img src="${message.data.image}"></div>
                        <div class="text">
                            <div class="name">Sarawut Aoudkla</div>
                            <div class="sub-text">
                                <div class="messages">มีอะไรหรอป่าว</div>
                                <div class="time-content">22:42</div>
                            </div>
                        </div>
                    </div>`;
		}
		$(".content-person ").html(item1);

		$(document).on("click", "#backtolist", async (e) => {
			let item = await this.components.messagelist();
			$(".content-message").html(item);
			let item1 = "";
			for (let i = 0; i < 10; i++) {
				item1 += ` <div class="person-item page-rtl">
			            <div class="image-person"><img src="${message.data.image}"></div>
			            <div class="text new">
			                <div class="name">Sarawut Aoudkla</div>
			                <div class="sub-text">
			                    <div class="messages">มีอะไรหรอป่าว</div>
			                    <div class="time">22:42</div>
			                </div>
			            </div>
			        </div>
			        <div class="person-item page-rtl">
			            <div class="image-person"><img src="${message.data.image}"></div>
			            <div class="text">
			                <div class="name">Sarawut Aoudkla</div>
			                <div class="sub-text">
			                    <div class="messages">มีอะไรหรอป่าว</div>
			                    <div class="time">22:42</div>
			                </div>
			            </div>
			        </div>`;
			}
			$(".content-person ").html(item1);
			await this.ajax.getperson();
		});
		$(document).on("click", ".all-person .images", async (e) => {
			let pd_id = $(e.target).closest(".images").data("pd-id");
			let item = await this.components.messagebyid();
			$(".content-message").html(item);
		});
		$(document).on("click", ".person-item", async (e) => {
			let pd_id = $(e.target).closest(".person-item").data("pd-id");
			let item = await this.components.messagebyid();
			$(".content-message").html(item);
		});
		$(document).on("click", ".fileclip", async (e) => {
			$("#file-input")[0].click();
		});
		$("#file-input").on("click", function (e) {
			e.stopPropagation();
		});
		$(document).on("change", "#file-input", async (e) => {
			let files = e.target.files[0];
			let size = (files.size / 1024).toFixed(2);
			let type = files.type.split("/");
			let type_length = files.type.split("/").length;
		});
		$(document).on("click", ".showEmoji", async (e) => {
			let item = `<div class="content-emoji">
                    <div class="emoji-item">
                        ${await emoji.emoji()}
                    </div>
                    </div>`;
			if ($(".content-emoji").length == 0) {
				$(".content-option-left ").prepend(item);
			} else {
				$(".content-emoji").remove();
			}
		});
		let item_emo = [];
		$(document).on("click", ".emoji-data", async (e) => {
			let obj = $(e.target).closest(".emoji-data");
			item_emo.push(obj.data("emoji"));
			$("#chat_message").text(item_emo);
			let text2 = $("#chat_message").text();
			$("#chat_message").text(text2.replaceAll(",", ""));
		});
		$(document).on("click", "#sendmessage", (e) => {
			let data = $("#chat_message").html();
			if (!data) {
				$("#chat_message").focus();
				return;
			}
			let date = new Date();
			let item = `
                            <div class="content-messages">
                                <div class="d-flex gap-2 align-items-end justify-content-end">
                                    <div class="messages--shadow m-right">
                                        ${data}
                                    </div>
                                </div>
                                <div class="time-right">${date.getHours()}:${date.getMinutes()}</div>
                            </div>
                            `;
			$(".content-chat .chat .messages").append(item);
			$("#chat_message").text("");
			item_emo = [];
			$(".content-messages").last()[0].scrollIntoView({ behavior: "smooth" });
		});
		$(document).on("focus", "#chat_message", (e) => {
			$(".content-emoji").remove();
		});

		$(document).on("click", ".sidebaropenmessage", async (e) => {
			$(".content-wrapper-scroll").css("position", "relative");
			if ($(".content-wrapper-scroll #chat-messages").length == 0) {
				$(".content-wrapper-scroll").prepend(this.components.main());
				setTimeout(() => {
					$(".content-wrapper-scroll #chat-messages .content-message").addClass(
						"show"
					);
				}, 200);
			} else {
				$(
					".content-wrapper-scroll #chat-messages .content-message"
				).removeClass("show");
				setTimeout(() => {
					$(".content-wrapper-scroll #chat-messages").remove();
				}, 200);
			}
		});
		$(document).on("click", ".closeChat", (e) => {
			$(".content-wrapper-scroll #chat-messages .content-message").removeClass(
				"show"
			);
			setTimeout(() => {
				$(".content-wrapper-scroll #chat-messages").remove();
			}, 200);
		});
	},
};
message.init();
