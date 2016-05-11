<?php if(!isset($signIn) || $signIn == false) { ?>
<script>
	var video_session_id;
	var video_token;
	var one_to_many = false;
	var subscribers = {};
	var publisher;
	var volumnObjects = { };
	var temp_active_element = {};
	var temp_active_count = 0;
	var real_active_element = {};

	function connectVideoStreaming(session_id, token) {

		if (!$("#LuaBlackBackground").hasClass('active')) {
			$('.cameraButton.toggle-menu.menu-lua.push-body').click();
		}

		$("#conversationContainer").addClass("expanded");
		$("#conversationContainer .section").removeClass("active");
		$("#conversationContainer").removeClass("contacts");
		$('#chatButton, #contactsButton').removeClass('active');
		$("#videoCallWindow").addClass("active");
		$("#videoCallWindow .callDiv").addClass("active");
		$("#videoContactsList").removeClass("active");

		videoSession = OT.initSession(tokbox_api_key, session_id);

		videoSession.connect(token, function(error) {
			if (!error) {
				publisher = OT.initPublisher('video_caller', {
					insertMode: 'append',
					width: '100%',
					height: '100%'
				});

				videoSession.publish(publisher);
			} else {
				console.log("Error occured!", error.code, error.message);
			}
		});

		videoSession.on("streamCreated", function(event) {
			if (Object.keys(videoConnections).length > 2) {
				one_to_many = true;
				swithOneToManyCall(true);
			} else {
				one_to_many = false;
				swithOneToManyCall(false);
			}

			var subId = getSubscribeElementId();
			
			var subscriber = videoSession.subscribe(event.stream, subId, {
				insertMode: 'append',
				audioVolume: 100,
				width: '100%',
				height: '100%'
			});
			
			subscriber.on('audioLevelUpdated', function(event) {
				updateSubscribers(event);
			});
			
			subscribers[subscriber.id] = subscriber;
			
			if (!one_to_many) {
				videoSession.subscribe(event.stream, $("#videoCallWindow .callee"), {
					insertMode: 'append',
					audioVolume: 100,
					width: '100%',
					height: '100%'
				});
			}
		});

		videoSession.on("connectionCreated", function(connectionEvent) {
			videoConnections[connectionEvent.connection.connectionId] = connectionEvent.connection;
			
			if (Object.keys(videoConnections).length > 2) {
				one_to_many = true;
				swithOneToManyCall(true);
			} else {
				one_to_many = false;
				swithOneToManyCall(false);
			}
		});

		videoSession.on("connectionDestroyed", function(connectionEvent) {
			delete videoConnections[connectionEvent.connection.connectionId];

			if (Object.keys(videoConnections).length > 2) {
				one_to_many = true;
				swithOneToManyCall(true);
			} else {
				for(var subscriber in subscribers) {
					if (subscribers[subscriber].stream) {
						videoSession.subscribe(subscribers[subscriber].stream, $("#videoCallWindow .callee"), {
							insertMode: 'append',
							audioVolume: 100,
							width: '100%',
							height: '100%'
						});
					}
				}
				one_to_many = false;
				swithOneToManyCall(false);

				if (Object.keys(videoConnections).length == 1) {
					videoSession.unpublish(publisher);
					videoSession.disconnect();

					delete videoConnections;
					delete subscribers;
					delete video_session_id;
					delete video_token;
					delete subscribers;

					$("#videoCallWindow").addClass("active");
					$("#videoCallWindow .callDiv").removeClass("active");
					$("#videoContactsList").removeClass("active");
				}
			}
		});
	}

	function updateSubscribers(event) {
		volumnObjects[event.target.id] = event;
		var max_volumn = 0;
		var max_element;
		if (Object.keys(videoConnections).length > 2) {
			for (var volumnObject in volumnObjects) {
				if (max_volumn <= volumnObjects[volumnObject].audioLevel) {
					max_volumn = volumnObjects[volumnObject].audioLevel;
					max_element = volumnObjects[volumnObject];
				}
			}

			if (typeof temp_active_element.target === 'undefined') {
				temp_active_element = max_element;
			}

			if ((max_element.target.id == temp_active_element.target.id) && (temp_active_count > 100))  {
				if ((typeof real_active_element.target === 'undefined') || (real_active_element.target.id != temp_active_element.target.id)) {
					console.log("subscribed!!!");
					$("#actived_user").html("");
					if (typeof real_active_element.target != 'undefined') {
						videoSession.unsubscribe(real_active_element.target.stream);
					}
					real_active_element = temp_active_element;

					videoSession.subscribe(real_active_element.target.stream, 'actived_user', {
						insertMode: 'replace',
						audioVolume: 100,
						width: '100%',
						height: '100%'
					});
				}
			} else if (max_element.target.id == temp_active_element.target.id) {
				console.log("plused!!!");
				temp_active_count++;
			} else {
				temp_active_element = max_element;
				temp_active_count = 0;
			}
		}
	}

	function getSubscribeElementId() {
		var index = 0;
		var id;

		$("#videoCallWindow .participants ul").append('<li><div class="participant"></div><div class="shadow"></div></li>');

		$("#videoCallWindow .participants ul li .participant").each(function() {
			index++;
			if ($(this).attr('id') && (!$.trim($(this).html()))) {
				id = $(this).attr('id');
				return false;
			}

			if (!$(this).attr('id')) {
				id = 'video_patient' + index;
				$(this).attr('id', id);
				return false;
			}
		});
		return id;
	}

	function swithOneToManyCall(flag) {
		if (flag) {
			$("#videoContactsList").removeClass("active");
			$("#video_caller").appendTo($('#small_caller'));
			$("#videoCallWindow").addClass('many');
			$("#videoCallWindow").removeClass('one');
		} else {
			$("#video_caller").appendTo("#videoCallWindow .one-on-one");
			$("#videoCallWindow").addClass('one');
			$("#videoCallWindow").removeClass('many');
		}
	}

	$('nav').on('click', '#videoContactsList ul li', function(e) {
		for(var connection in videoConnections) {
			if (videoConnections[connection].data == $(this).text()) {
				alert("Already chatting with this person.");
				return false;
			}
		}

		for(var connection in connections) {
			if (connections[connection].data == $(this).text()) {
				videoChatWith = connections[connection];
				break;
			}
		}

		if (!videoSession) {
			$.ajax({
				url: "<?= base_url().'conversation/videoCall' ?>",
				data: {from: "<?php echo $this->session->userdata['user_id']; ?>", to: videoChatWith.data },
				dataType: "JSON",
				type: "POST",
				success: function(response) {
					if (response.status == "success") {
						video_session_id = response.session_id;
						video_token = response.token;
						
						var data = {
							title: 'StartVideoChat',
							session_id: video_session_id,
							token: video_token,
							from: "<?php echo $this->session->userdata['user_name']; ?>"
						}

						session.signal({
								to: videoChatWith,
								type: 'video',
								data: JSON.stringify(data)
							},
							function(error) {
								if (error) {
									console.log("video signal error (" + error.code + "): " + error.message);
								} else {
									connectVideoStreaming(video_session_id, video_token);
									console.log("video signal sent.");
								}
							}
						)
					} else {
						alert(videoChatWith + " is busy now. please try again later.");
					}
				}
			});
		} else {
			var data = {
				title: 'StartVideoChat',
				session_id: video_session_id,
				token: video_token,
				from: "<?php echo $this->session->userdata['user_name']; ?>"
			}

			session.signal({
					to: videoChatWith,
					type: 'video',
					data: JSON.stringify(data)
				},
				function(error) {
					if (error) {
						console.log("video signal error (" + error.code + "): " + error.message);
					} else {
						console.log("video signal sent.");
					}
				}
			)
		}
	});

	function showConfirmDialog(from, session_id, token) {
		if (confirm(from + " is calling you. accept?")) {
			$("#videoCallWindow .callDiv").addClass("active");
			$("#videoContactsList").removeClass("active");
			video_session_id = session_id;
			video_token = token;
			connectVideoStreaming(session_id, token);
		} else {
			
			var data = {
				title: 'EndVideoChat',
			}

			session.signal({
					type: 'video',
					data: JSON.stringify(data)
				},
				function(error) {
					if (error) {
						console.log("video signal error (" + error.code + "): " + error.message);
					} else {
						console.log("video signal sent.");
					}
				}
			)
		}
	}

	session.on("signal:video", function(event) {
		var video_chat = JSON.parse(event.data);
		var video_type = video_chat.title;

		for(var connection in connections) {
			if (connections[connection].data == event.from.data) {
				break;
				videoChatWith = connections[connection];
			}
		}
		
		switch(video_type) {
			case 'StartVideoChat':
				showConfirmDialog(video_chat.from, video_chat.session_id, video_chat.token);
				break;
			case 'EndVideoChat':
				if (Object.keys(videoConnections) < 2) {
					
					videoSession.unpublish(publisher);
					videoSession.disconnect();

					delete videoConnections;
					delete videoSession;
					delete video_session_id;
					delete video_token;
					delete publisher;
					delete subscribers;

					$("#videoCallWindow").addClass("active");
					$("#videoCallWindow .callDiv").removeClass("active");
					$("#videoContactsList").removeClass("active");
				}
				break;
		}
	});

	$('#videoCallWindow .hangup').click(function(e) {
		videoSession.unpublish(publisher);
		videoSession.disconnect();
		delete videoConnections;
		delete videoSession;
		delete video_session_id;
		delete video_token;
		delete publisher;
		delete subscribers;
		
		var data = {
			title: 'EndVideoChat',
		}

		session.signal({
				type: 'video',
				data: JSON.stringify(data)
			},
			function(error) {
				if (error) {
					console.log("video signal error (" + error.code + "): " + error.message);
				} else {
					console.log("video signal sent.");
				}
			}
		);

		$("#videoCallWindow").addClass("active");
		$("#videocallWindow .callDiv").removeClass("active");
		$("#videoContactsList").removeClass("active");
	});
</script>
<?php } ?>