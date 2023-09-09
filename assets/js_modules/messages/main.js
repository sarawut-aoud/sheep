import { emoji } from "./emoji.js";
// const domain = base_url();
// const socket = new WebSocket("wss://sheep.local:3000");

const message = {
	data: {
		files: null,
		pd_id: "",
		image: base_url("/assets/images/blank_person.jpg"),
		message_id: "",
	},
	methods: {
		noti(topic, content) {
			if (topic && content) {
				let noti = new Notification(topic, {
					body: content,
				});
			}
		},
		load_message() {
			setInterval(async () => {
				if ($(".content-chat").length > 0) {
					await message.ajax.aftersend(message.data.message_id);
					await message.ajax.getnotijs();
				} else {
					await message.ajax.get_messageall();
				}
			}, 10000);
			setInterval(async () => {
				await message.ajax.getperson();
			}, 60 * 1000);
		},
	},
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
            <div class="content-bar ">
                <div class="person">
                    <div class="all-person">
                    </div>
                </div>
            </div>
            <div class="content-person ">
                
    
            </div>
    `;
			return item;
		},
		messagebyid: (post) => {
			let data = post;

			let person = data.person;
			let img = person.picture ? base_url(person.picture) : message.data.image;
			message.data.message_id = data.message_id;
			let item = `<div class="content-bar " data-pd-id="${person.pd_id}">
            <div class="back" id="backtolist"><i class="fas fa-bars"></i></div>
            <div class="image">
                <img src="${img}">
                <div class="status"></div>
            </div>
            <div class="text">
                <div class="sub-text font--xl">${person.fullname}</div>
            </div>
        </div>
		${message.components.contentchat(data)}
        <div class="content-input align-items-center">
            <div class="content-option-left">
                <div class="icon camera"><i class="fas fa-camera"></i>
					<input type="file" hidden id="file-inputcamera"  accept="image/*">
				</div>
                <div class="icon showEmoji"><i class="fas fa-laugh-beam"></i></div>
                <div class="icon fileclip"><i class="fas fa-paperclip"></i>
                    <input type="file" hidden id="file-input"  accept="*">
                </div>
            </div>
            <div class="data-input">
                <div contenteditable="true" type="text" class="form-control input-message " id="chat_message"
                    required placeholder="Type your message !"></div>
            </div>
            <div class="content-option-right">
                <div class="icon " id="sendmessage"><i class="fas fa-paper-plane"></i></div>
                <div class="icon d-none"><i class="fas fa-microphone"></i></div>
            </div>
        </div>`;
			return item;
		},
		contentchat(data) {
			return `<div class="content-chat ">
           
                   ${message.components.message_data(data.message)}
               
        </div>`;
		},
		message_load() {
			return ` <div class="content-messages">
							<div class="messages--shadow m-left ">
								<div class="typing">
									<i class="fas fa-circle animetion--1"></i>
									<i class="fas fa-circle animetion--2"></i>
									<i class="fas fa-circle animetion--3"></i>
								</div>
							</div>
					</div>`;
		},
		message_data(data) {
			let item = "";

			data.forEach((elem, index) => {
				let self = elem.chat_in;
				item += `
				<div class="chat">
					<div class="today">
						<div class="text">${elem.datetime}</div>
					</div>
					<div class="messages">`;
				for (const [i, ev] of Object.entries(elem.content_chat)) {
					let img = ev.files
						? `<div class="text-center"><img style="width:100px" 
								src="${base_url(ev.files)}"></div>`
						: "";
					item += `
							<div class="content-messages">
								<div class="d-flex gap-2 align-items-end 
								${self == i.split("_")[1] ? "justify-content-end" : "justify-content-start"} 
								">
									${
										ev.status == "read"
											? `<div class="read-right "><i class="fas fa-check"></i></div>`
											: ""
									}
									<div class="messages--shadow ${self == i.split("_")[1] ? "m-right" : "m-left"}">
									<div style="line-break: anywhere;"> ${ev.text}</div>
										${img}
									</div>
								</div>
								<div class="${self == i.split("_")[1] ? "time-right" : "time-left"}">
									${ev.time}
								</div>
							</div>
						
						`;
				}
				item += `</div>
						</div>`;
			});
			return item;
		},
		allperson(data) {
			let img = data.picture ? base_url(data.picture) : message.data.image;
			let item = ` <div class="person-item " data-pd-id="${data.pd_id}">
                        <div class="image-person"><img src="${img}"></div>
                        <div class="text ${data.read == "unread" ? "new" : ""}">
                            <div class="name">${data.fullname}</div>
                            <div class="sub-text">
                                <div class="messages">
									${data.last_message ? data.last_message : "เริ่มแชทเลย"}
								</div>
                                <div class="time-content">	
									${data.last_datetime ? data.last_datetime : ""}
								</div>
                            </div>
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
		async get_messageall() {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("message/get_messageall"),
				data: {
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: async (results) => {
					let item = "";
					if (results.data) {
						let data = results.data;
						await data.forEach((ev, i) => {
							item += message.components.allperson(ev);
						});
					}
					$(".content-person ").html(item);
				},
			});
		},
		async get_messageid(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("message/get_messageid"),
				data: {
					pd_id: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						let item = message.components.messagebyid(results.data);

						$(".content-message").html(item);

						OverlayScrollbars($(".content-chat")[0], {
							overflow: {
								y: "hidden",
							},
						});

						let scroll = setTimeout(() => {
							$(".content-messages").last()[0].scrollIntoView({
								behavior: "smooth",
								block: "end",
								inline: "nearest",
							});
						}, 200);

						setTimeout(() => {
							$("#chat-messages")[0].scrollIntoView({
								behavior: "smooth",
								block: "start",
								inline: "nearest",
							});
						}, 100 * scroll);
					}
				},
			});
		},
		async savechat(data, id, pd_id, files) {
			let fdata = new FormData();
			fdata.append("file", files);
			fdata.append("message_id", id);
			fdata.append("data", data);
			fdata.append("csrf_token_ci_gen", $.cookie(csrf_cookie_name));
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("message/savechat"),
				data: fdata,
				enctype: "multipart/form-data",
				processData: false,
				contentType: false,
				success: async (results) => {
					// await message.ajax.get_messageid(pd_id);
				},
			});
		},
		async typing(pd_id, type) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("message/typing"),
				data: {
					pd_id: pd_id,
					type: type,
					message_id: message.data.message_id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {},
			});
		},
		async getnotijs() {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("message/getnotijs"),
				success: (results) => {
					if (results.data) {
						let data = results.data;
						message.methods.noti(data.topic, data.content);
					}
				},
			});
		},
		async aftersend(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("message/get_messageid_after"),
				data: {
					id: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.data) {
						let data = results.data;
						let obj = "";
						if (data.content) {
							if (data.content.text) {
								let img = "";
								if (data.content.file) {
									let file = base_url(data.content.file);
									img += `<div class="text-center"><img style="width:100px" 
									src="${file}"></div>`;
								}
								obj = `<div class="content-messages">
										<div class="d-flex gap-2 align-items-end justify-content-start ">
											<div class="messages--shadow m-left">
											<div style="line-break: anywhere;">${data.content.text}</div>
												${img}
											</div>
										</div>
										<div class="time-left">
											${data.content.time}
										</div>
									</div>`;
								$(".content-chat")
									.find(".chat")
									.last()
									.find(".messages")
									.append(obj);
								$(".content-messages").last()[0].scrollIntoView({
									behavior: "smooth",
									block: "end",
									inline: "nearest",
								});
							}
						}
					}
				},
			});
		},
	},
	async init() {
		this.methods.load_message();
		await this.ajax.getperson();
		await this.ajax.get_messageall();

		$(document).on("click", "#backtolist", async (e) => {
			let item = await this.components.messagelist();
			$(".content-message").html(item);
			await this.ajax.getperson();
			await this.ajax.get_messageall();
		});
		$(document).on("click", ".all-person .images", async (e) => {
			let pd_id = $(e.target).closest(".images").data("pd-id");
			await this.ajax.get_messageid(pd_id);
			this.data.pd_id = pd_id;
		});
		$(document).on("click", ".person-item", async (e) => {
			let pd_id = $(e.target).closest(".person-item").data("pd-id");
			await this.ajax.get_messageid(pd_id);
			this.data.pd_id = pd_id;
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

		$(document).on("click", "#sendmessage", async (e) => {
			let pd_id = $(e.target)
				.closest(".content-message")
				.find(".content-bar")
				.data("pd-id");

			let data = $("#chat_message").html();
			if (!data) {
				$("#chat_message").focus();
				return;
			}
			let file = $("#file-input").val()
				? $("#file-input").val()
				: $("#file-inputcamera").val();
			let filedata = "";
			let img = "";
			let reader = new FileReader();
			if (file) {
				filedata = file;
				reader.readAsDataURL(this.data.files);
				reader.onload = function (e) {
					let image = new Image();

					img += `<div class="text-center"><img style="width:100px" 
					src="${e.target.result}"></div>`;
				};
			}
			$("#chat_message").text("");
			await this.ajax.savechat(
				data,
				this.data.message_id,
				pd_id,
				this.data.files
			);

			let date = new Date();
			let t1 = date.getHours() < 10 ? `0${date.getHours()}` : date.getHours();
			let t2 =
				date.getMinutes() < 10 ? `0${date.getMinutes()}` : date.getMinutes();
			let time = `${t1}:${t2}`;
			let item = `
                            <div class="content-messages">
                                <div class="d-flex gap-2 align-items-end justify-content-end">
                                    <div class="messages--shadow m-right">
                                       <div  style="line-break: anywhere;"> ${data}</div>
										${img}
                                    </div>
                                </div>
                                <div class="time-right">${time}</div>
                            </div>
                            `;
			$(".content-chat ").find(".chat").last().find(" .messages").append(item);

			item_emo = [];
			setTimeout(() => {
				$(".content-messages").last()[0].scrollIntoView({
					behavior: "smooth",
					block: "end",
					inline: "nearest",
				});

				this.data.files = null;
				$("#file-input").val("");
				$("#file-inputcamera").val("");
			}, 300);
		});
		$(document).on("focus", "#chat_message", (e) => {
			$(".content-emoji").remove();
		});

		$(document).on("click", ".sidebaropenmessage", async (e) => {
			$(".content-wrapper-scroll").css("position", "relative");
			if ($(".content-wrapper-scroll #chat-messages").length == 0) {
				// $(".content-wrapper-scroll").prepend(this.components.main());
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
			$("#chat_message").text(files.name);
			this.data.files = files;
		});

		$(document).on("click", ".camera", async (e) => {
			$("#file-inputcamera")[0].click();
		});
		$("#file-inputcamera").on("click", function (e) {
			e.stopPropagation();
		});
		$(document).on("change", "#file-inputcamera", async (e) => {
			let files = e.target.files[0];
			let size = (files.size / 1024).toFixed(2);
			let type = files.type.split("/");
			let type_length = files.type.split("/").length;
			this.data.files = files;
			$("#chat_message").text(files.name);
		});

		// $(document).on("focusin", "#chat_message", async (e) => {
		// 	let pd_id = $(e.target)
		// 		.closest(".content-message")
		// 		.find(".content-bar")
		// 		.data("pd-id");
		// 	await this.ajax.typing(pd_id, 1);
		// });
		// $(document).on("focusout", "#chat_message", async (e) => {
		// 	let pd_id = $(e.target)
		// 		.closest(".content-message")
		// 		.find(".content-bar")
		// 		.data("pd-id");
		// 	await this.ajax.typing(pd_id, 0);
		// });
	},
};
message.init();
