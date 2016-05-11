<?php if(!isset($signIn) || $signIn == false) { ?>
<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
<script>
	var tokbox_api_key = "<?=$tokbox_api_key?>";
	var notifications_session = "<?=$notifications_session?>";
	var notifications_token = "<?=$notifications_token?>";
	var connections = {};
	var session;
	var chatWith;
	var users = { };
	var videoChatWith;
	var videoSession;
	var videoConnections = {};

	var audioChatWith;
	var audioSession;
	var audioConnections = {};

	if(OT.checkSystemRequirements() == 1) {
		
		session = OT.initSession(tokbox_api_key, notifications_session);
		
		session.connect(notifications_token, function(error) {
			if (error) {
				console.log("Error connecting: ", error.code, error.message);
			} else {
				console.log("Connected to the session.");
			}
		});

		session.on("connectionCreated", function(connectionEvent) {
			connections[connectionEvent.connection.connectionId] = connectionEvent.connection;
			updateContactsDiv(connections);
		});

		session.on("connectionDestroyed", function(connectionEvent) {
			delete chatWith;
			delete connections[connectionEvent.connection.connectionId];
			updateContactsDiv(connections);
		});
		
		session.on("signal:chat", function(event) {
			var dateType = new Date(event.from.creationTime);
			var str_date = dateType.toDateString() + " " + dateType.getHours() + ":" + dateType.getMinutes() + ":" + dateType.getSeconds();
			var user_id = getUserIdFromName(event.from.data);
			
			if (typeof chatWith === 'undefined') {
				$.notify(event.from.data + " sent you message. " + event.data, "success");
				showBadgeNumber(user_id, 1);

				updateRecentConversation(user_id, event.data, str_date);
			} else if (event.from.data != chatWith.data) {

				$.notify(event.from.data + " sent you message. " + event.data, "success");
				showBadgeNumber(user_id, 1);
				updateRecentConversation(user_id, event.data, str_date);

			} else if (event.from.data == chatWith.data) {
				var userIcon = getUserIconFromName(event.from.data);
				$(".chatContainer ul").find('.active').removeClass('active');
				var appendHtml = '<li class="active">' + 
        							'<div class="userPhoto"><img src="' + userIcon + '"></div>' +
									'<span class="userFullName">' + event.from.data + '</span>' +
									'<p class="messageContent">' + event.data + 
										'<br/><br/>&nbsp; Sent' + str_date +
									'</p>' +
								'</li>';
				$(".chatContainer ul").append(appendHtml);
		        $('.chatContainer ul').scrollTop($('.chatContainer ul')[0].scrollHeight);
		        markAsReadMessage(user_id, "<?php echo $this->session->userdata['user_id']; ?>", event.data);
			}
		});
	} else {
		console.log("WebRTC not supported");
	}

	function getUserIconFromName(username) {
		for(var user in users) {
			if(users[user].username == username) {
				var result = users[user].filename ? "/uploads/" + users[user].filename : "https://placeimg.com/50/50/any";
				return result;
			}
		}
	}

	function getUserIdFromName(username) {
		for(var user in users) {
			if(users[user].username == username) {
				return users[user].user_id;
			}
		}
	}

	function getUserNameFromId(id) {
		for(var user in users) {
			if(users[user].user_id == id) {
				return users[user].username;
			}
		}
	}

	$.ajax({
        url: "<?= base_url().'conversation/getAllUsers' ?>",
        dataType: "JSON",
        type: "POST",
        success: function(response) {
            var datas = response;
            users = datas;
            $('#chatContactsList ul.chatContacts').html('');
            
            for(var data in datas) {
            	if (datas[data].username != "<?php echo $this->session->userdata['user_name']; ?>") {
            		var userIcon = getUserIconFromName(datas[data].username);
            		var userId = datas[data].user_id;

            		var appendHtml = '<li class="badge" data-badge="0"></a><div class="userPhoto"><img src="' + userIcon + '"></div><br><span user_id="' + userId + '">' + datas[data].username + '</span></li>';
					$('#chatContactsList ul.chatContacts').append(appendHtml);
            	};
            }
        }
    });

	//When Page is loading get recent conversation.
	$.ajax({
        url: "<?= base_url().'conversation/getRecentConversation' ?>",
        dataType: "JSON",
        type: "POST",
        success: function(response) {
        	var datas = response;
            for(var data in datas) {
            	console.log(datas[data]);
            	var date = new Date(datas[data].time*1000);
	            var str_date = date.toDateString() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
	            var user_id = (datas[data].sender == "<?php echo $this->session->userdata['user_id']; ?>") ? datas[data].receiver:datas[data].sender;
	            var user_name = getUserNameFromId(user_id);
	            var userIcon = getUserIconFromName(user_name);
            	var appendHtml = '<li>' +
									'<div class="userPhoto">' +
										'<img src="' + userIcon + '">' +
									'</div>' +
									'<span class="day">' + str_date + '</span>' + 
									'<span class="userFullName" user_id="' + user_id + '">' + user_name + '</span>' + 
									'<p class="messageContentSample">' + datas[data].content + '</p>' +
									'<div class="delete"><img src="<?=base_url();?>assets/images/icon_deleteconversation.png"></div>' +
								'</li>';
                $("#latestConversations ul").append(appendHtml);
                $('#latestConversations ul').scrollTop($('#latestConversations ul')[0].scrollHeight);
            }
        }
    });

	function showBadgeNumber(who, count) {
		$("ul.chatContacts li").each(function() {
			if (who == $(this).find('span').attr('user_id')) {
				var badge = parseInt($(this).attr("data-badge"));
				$(this).attr("data-badge", badge + count);
			}
		})
	}

	function updateRecentConversation(to, content, str_date) {
		var flag = false;
		$("#latestConversations ul li").each(function() {
			if ($(this).find('.userFullName').attr('user_id') == to) {
				$(this).find('.messageContentSample').text(content);
				flag = true;
				return false;
			}
		});

		if (!flag) {
			var user_name = getUserNameFromId(to);
			var userIcon = getUserIconFromName(user_name);
			var appendHtml = '<li>' +
								'<div class="userPhoto">' +
									'<img src="' + userIcon + '">' +
								'</div>' +
								'<span class="day">' + str_date + '</span>' + 
								'<span class="userFullName" user_id="' + to + '">' + user_name + '</span>' + 
								'<p class="messageContentSample">' + content + '</p>' +
								'<div class="delete"><img src="<?=base_url();?>assets/images/icon_deleteconversation.png"></div>' +
							'</li>';

			var tempHtml = $("#latestConversations ul").html();

			$("#latestConversations ul").html(appendHtml + tempHtml);
		};
	}
	
	function sendTextChat(who, text) {
		session.signal({
				to: who,
				data: text,
				type: 'chat'
			},
			function(error) {
				if (error) {
					console.log("signal error (" + error.code + "): " + error.message);
				} else {
					console.log("signal sent.");
				}
			}
		);

		var user_id = getUserIdFromName(chatWith.data);
		
		$.ajax({
			url: "<?= base_url().'conversation/saveChatHistory' ?>",
			data: {from: "<?php echo $this->session->userdata['user_id']; ?>", to: user_id, content: text},
			dataType: "JSON",
			type: "POST",
			success: function(response) {
				var data = response;
				var date = new Date(data.time*1000);
				var str_date = date.toDateString() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
				if (data.status == "success") {
					if(data.to != user_id) {
						
					} else {
						var user_name = getUserNameFromId(data.from);
						var userIcon = getUserIconFromName(user_name);
						
						$(".chatContainer ul").find('.active').removeClass('active');

                		var appendHtml = '<li class="active">' + 
                							'<div class="userPhoto"><img src="' + userIcon + '"></div>' +
                							'<span class="userFullName" user_id="' + data.from + '">' + user_name + '</span>' + 
											'<p class="messageContent">' + data.content +
												'<br/><br/> &nbsp; Sent ' + str_date +
											'</p>' +
										'</li>';
	                    $(".chatContainer ul").append(appendHtml);
	                    $('.chatContainer ul').scrollTop($('.chatContainer ul')[0].scrollHeight);
	                    updateRecentConversation(data.to, data.content, str_date);
                	}
                	updateRecentConversation(data.to, data.content, str_date);
                	resortRecentConversation($("#latestConversations ul"), data.to);
                } else {
                	$.notify("Can't send message. Please check network connection and reload page.", "error");
                }
            }
        });
	}

	function getUnReadMessageForUser( who ) {
		$.ajax({
            url: "<?= base_url().'conversation/getUnReadMessageForUser' ?>",
            data: {to: "<?php echo $this->session->userdata['user_id']; ?>", from: who},
            dataType: "JSON",
            type: "POST",
            success: function(response) {
                var data = response;
                var user_id = data.from;
                var count = data.count;
                $('#chatContactsList ul.chatContacts li').each(function() {
                	if ($(this).find('span').attr('user_id') == user_id) {
                		var badge = parseInt($(this).attr("data-badge"));
                		$(this).attr("data-badge", parseInt(count) + badge);
                	};
                });
            }
        });
	}

	function updateContactsDiv(connections) {
		$('#chatContactsList ul.chatContacts').find(".online").removeClass("online");
		$(".callContactsList ul").html("");

		for(var connection in connections) {
			$('#chatContactsList ul.chatContacts li').each(function() {
				if ($(this).find('span').text() == connections[connection].data){
					$(this).addClass("online");
					$(".callContactsList ul").append('<li>' + $(this).text() + '</li>');
					getUnReadMessageForUser($(this).find('span').attr('user_id'));
				}
			});
		}
	}

	function resortRecentConversation( element, who ) {
		var root = element;
		var resortHtml = "";
		element.find('.active').removeClass('active');
		var flag = false;

		$.each(root.find('li'), function(el) {
			if($(this).find('.userFullName').attr('user_id') == who) {
				$(this).insertBefore($(this).siblings(':eq(0)'));
				$(this).addClass('active');
				flag = true;
				return;
			}
		})

		if (!flag) {
			var user_name = getUserNameFromId(who);
			
			var userIcon = getUserIconFromName(user_name);
			var appendHtml = '<li>' +
								'<div class="userPhoto">' +
									'<img src="' + userIcon + '">' +
								'</div>' +
								'<span class="day">' + '</span>' + 
								'<span class="userFullName" user_id="' + who + '">' + user_name + '</span>' + 
								'<p class="messageContentSample">' + '</p>' +
								'<div class="delete"><img src="<?=base_url();?>assets/images/icon_deleteconversation.png"></div>' +
							'</li>';
			var tempHtml = element.html();
			element.html(appendHtml + tempHtml);
		};
	}

	function markAsReadMessage(from, to, content) {
		$.ajax({
            url: "<?= base_url().'conversation/markAsRead' ?>",
            data: {from: from, to: to, content: content},
            dataType: "JSON",
            type: "POST",
            success: function(response) {
                
            }
        });
	}

	function markAsDelete( who , object) {
		$.ajax({
			url: "<?= base_url().'conversation/markAsDelete' ?>",
            data: { me: "<?php echo $this->session->userdata['user_id']; ?>", with: who },
            dataType: "JSON",
            type: "POST",
            success: function(response) {
				object.remove();
            }
		});
	}

	$("nav").on('click', '#latestConversations ul li', function(e) {
		var user_id = $(this).find(".userFullName").attr('user_id');
		var username = getUserNameFromId(user_id);

		resortRecentConversation($(this).parent().parent(), user_id);
		getRecentConversationForUser(user_id);
		markAsReadForUser(user_id);

		$.each($("ul.chatContacts li"), function() {
			if($(this).find(".userFullName").attr('user_id') == user_id) {
				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');
				$(this).attr("data-badge", "0");
			}
		});
		
		for (var connection in connections) {
			if (connections[connection].data == username) {
				$.each($("ul.chatContacts li"), function() {
					if($(this).find("span").text() == username) {
						$(this).parent().find('.active').removeClass('active');
						$(this).addClass('active');
						$(this).attr("data-badge", "0");
					}
				})
				chatWith = connections[connection];
				break;
			};
			chatWith = { data: username };
		}
	})
	
	$("nav").on('click', 'ul.chatContacts li', function(e) {
		$that = $(this);
		$that.parent().find('.active').removeClass('active');
		$(this).attr("data-badge", "0");
		$that.addClass('active');
		var user_id = $that.find('span').attr('user_id');

		getRecentConversationForUser(user_id);
		
		resortRecentConversation($("#latestConversations ul"), user_id);
		
		markAsReadForUser(user_id);

		chatWith = { data: $that.find('span').text() };
		
		for (var connection in connections) {
			if (connections[connection].data == $that.find('span').text()) {
				chatWith = connections[connection];
				break;
			};
		}

		console.log(chatWith);
		e.preventDefault();
	})

	$("nav").on('click', '.delete', function(e) {
		var who = $(this).siblings('.userFullName').attr('user_id');
		markAsDelete(who, $(this).parent());
	})
	
	function getRecentConversationForUser(who) {
		$.ajax({
	        url: "<?= base_url().'conversation/getRecentConversationForUser' ?>",
	        data: { me: "<?php echo $this->session->userdata['user_id']; ?>", with: who },
	        dataType: "JSON",
	        type: "POST",
	        success: function(response) {
	            var datas = response;
	            $(".chatContainer ul").html("");
	            for(var data in datas) {
	            	var date = new Date(datas[data].time*1000);
		            var str_date = date.toDateString() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
		            var flag = (datas[data].sender == "<?php echo $this->session->userdata['user_id']; ?>");

		            var username = getUserNameFromId(datas[data].sender);
		            var userIcon = getUserIconFromName(username);

		            $(".chatContainer ul").find('.active').removeClass('active');
		            
		            if (flag) {
		            	var appendHtml = '<li>' + 
                							'<div class="userPhoto"><img src="' + userIcon + '"></div>' +
											'<span user_id="' + datas[data].sender + '" class="userFullName">' + username + '</span>' +
											'<p class="messageContent">' + datas[data].content + 
												'<br/><br/>&nbsp; Sent ' + str_date +
											'</p>' +
										'</li>';
		            } else {
		            	var appendHtml = '<li>' + 
                							'<div class="userPhoto"><img src="' + userIcon + '"></div>' +
											'<span user_id="' + datas[data].sender + '" class="userFullName">' + username + '</span>' +
											'<p class="messageContent">' + datas[data].content +
												'<br/><br/>&nbsp; Sent ' + str_date +
											'</p>' +
										'</li>';
		            }

		            $(".chatContainer ul").append(appendHtml);
	                $('.chatContainer ul').scrollTop($('.chatContainer ul')[0].scrollHeight);
	            }
	        }
	    });
	}

	function markAsReadForUser(who) {
		$.ajax({
	        url: "<?= base_url().'conversation/markAsReadForUser' ?>",
	        data: { me: "<?php echo $this->session->userdata['user_id']; ?>", from: who },
	        dataType: "JSON",
	        type: "POST",
	        success: function(response) {
	        	
	    	}
	    });
	}

	$(".sendChatButton").click(function() {
		if(!chatWith || chatWith.data == "") {
			alert("Please select user first");
		} else if($(this).prev().val() != "") {
			sendTextChat(chatWith, $(this).prev().val());
			
			$(this).prev().val("");
		}
	});

	$(".chatContent").keydown(function(e) {
		if (e.keyCode == 13) {
			$(this).next().click();
			return false;
		};
	});
</script>
<?php } ?>