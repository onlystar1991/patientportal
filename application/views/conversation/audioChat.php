<?php if(!isset($signIn) || $signIn == false) { ?>
<script>
	var audio_session_id;
	var audio_token;
	var one_to_many_audio = false;
	var audio_subscribers = {};
	var audio_publisher;
	var volumnObjectsAudio = { };
	var temp_active_element = {};
	var temp_active_count = 0;
	var real_active_element = {};

	function connectAudioStreaming(session_id, token) {

		if (!$("#LuaBlackBackground").hasClass('active')) {
			$('.cameraButton.toggle-menu.menu-lua.push-body').click();
		}

		$("#conversationContainer").addClass("expanded");
		$("#conversationContainer .section").removeClass("active");
		$("#conversationContainer").removeClass("contacts");
		$('#chatButton, #contactsButton').removeClass('active');
		$("#audioCallWindow").addClass("active");
		$("#audioCallWindow .callDiv").addClass("active");
		$("#audioContactsList").removeClass("active");

		audioSession = OT.initSession(tokbox_api_key, session_id);

		audioSession.connect(token, function(error) {
			if (!error) {
				audio_publisher = OT.initPublisher('audio_caller', {
					insertMode: 'append',
					width: '100%',
					height: '100%',
					videoSource: null
				});

				audioSession.publish(audio_publisher);
			} else {
				console.log("Error occured!", error.code, error.message);
			}
		});

		audioSession.on("streamCreated", function(event) {
			console.log("audio----------");
			console.log(audioSession);

			if (Object.keys(audioConnections).length > 2) {
				one_to_many_audio = true;
				swithOneToManyCallAudio(true);
			} else {
				one_to_many_audio = false;
				swithOneToManyCallAudio(false);
			}

			var subId = getAudioSubscribeElementId();
			
			var subscriber = audioSession.subscribe(event.stream, subId, {
				insertMode: 'append',
				audioVolume: 50,
				subscribeToAudio: true,
				subscribeToVideo: false,
				width: '100%',
				height: '100%'
			});
			
			subscriber.on('audioLevelUpdated', function(event) {
				updateAudioSubscribers(event);
			});
			
			audio_subscribers[subscriber.id] = subscriber;
			
			if (!one_to_many_audio) {
				audioSession.subscribe(event.stream, $("#audioCallWindow .callee"), {
					insertMode: 'append',
					audioVolume: 50,
					subscribeToAudio: true,
					subscribeToVideo: false,
					width: '100%',
					height: '100%'
				});
			}
		});

		audioSession.on("connectionCreated", function(connectionEvent) {
			audioConnections[connectionEvent.connection.connectionId] = connectionEvent.connection;
			
			if (Object.keys(audioConnections).length > 2) {
				one_to_many_audio = true;
				swithOneToManyCallAudio(true);
			} else {
				one_to_many_audio = false;
				swithOneToManyCallAudio(false);
			}
		});

		audioSession.on("connectionDestroyed", function(connectionEvent) {
			delete audioConnections[connectionEvent.connection.connectionId];

			if (Object.keys(audioConnections).length > 2) {
				one_to_many_audio = true;
				swithOneToManyCallAudio(true);
			} else {
				for(var subscriber in audio_subscribers) {
					if (audio_subscribers[subscriber].stream) {
						audioSession.subscribe(audio_subscribers[subscriber].stream, $("#audioCallWindow .callee"), {
							insertMode: 'append',
							audioVolume: 50,
							subscribeToAudio: true,
							subscribeToVideo: false,
							width: '100%',
							height: '100%'
						});
					}
				}
				one_to_many_audio = false;
				swithOneToManyCallAudio(false);

				if (Object.keys(audioConnections).length == 1) {
					audioSession.unpublish(audio_publisher);
					audioSession.disconnect();

					delete audioConnections;
					delete audio_subscribers;
					delete audio_session_id;
					delete audio_token;

					$("#audioCallWindow").addClass("active");
					$("#audioCallWindow .callDiv").removeClass("active");
					$("#audioContactsList").removeClass("active");
				}
			}
		});
	}

	function updateAudioSubscribers(event) {
		volumnObjectsAudio[event.target.id] = event;
		var max_volumn = 0;
		var max_element;
		if (Object.keys(audioConnections).length > 2) {
			for (var volumnObject in volumnObjectsAudio) {
				if (max_volumn <= volumnObjectsAudio[volumnObject].audioLevel) {
					max_volumn = volumnObjectsAudio[volumnObject].audioLevel;
					max_element = volumnObjectsAudio[volumnObject];
				}
			}

			if (typeof temp_active_element.target === 'undefined') {
				temp_active_element = max_element;
			}

			if ((max_element.target.id == temp_active_element.target.id) && (temp_active_count > 100))  {
				if ((typeof real_active_element.target === 'undefined') || (real_active_element.target.id != temp_active_element.target.id)) {
					console.log("subscribed!!!");
					$("#actived_user_audio").html("");
					if (typeof real_active_element.target != 'undefined') {
						audioSession.unsubscribe(real_active_element.target.stream);
					}
					real_active_element = temp_active_element;

					audioSession.subscribe(real_active_element.target.stream, 'actived_user_audio', {
						insertMode: 'replace',
						audioVolume: 50,
						subscribeToAudio: true,
						subscribeToVideo: false,
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

	function getAudioSubscribeElementId() {
		var index = 0;
		var id;

		$("#audioCallWindow .participants ul").append('<li><div class="participant"></div><div class="shadow"></div></li>');

		$("#audioCallWindow .participants ul li .participant").each(function() {
			index++;
			if ($(this).attr('id') && (!$.trim($(this).html()))) {
				id = $(this).attr('id');
				return false;
			}

			if (!$(this).attr('id')) {
				id = 'audio_patient' + index;
				$(this).attr('id', id);
				return false;
			}
		});

		return id;
	}

	function swithOneToManyCallAudio(flag) {
		if (flag) {
			$("#audioContactsList").removeClass("active");
			$("#audio_caller").appendTo($('#small_caller_audio'));
			$("#audioCallWindow").addClass('many');
			$("#audioCallWindow").removeClass('one');
		} else {
			$("#audio_caller").appendTo("#audioCallWindow .one-on-one");
			$("#audioCallWindow").addClass('one');
			$("#audioCallWindow").removeClass('many');
		}
	}

	$('nav').on('click', '#audioContactsList ul li', function(e) {
		for(var connection in audioConnections) {
			if (audioConnections[connection].data == $(this).text()) {
				alert("Already chatting with this person.");
				return false;
			}
		}

		for(var connection in connections) {
			if (connections[connection].data == $(this).text()) {
				audioChatWith = connections[connection];
				break;
			}
		}

		console.log("audio contact list clicked");

		if (!audioSession) {
			$.ajax({
				url: "<?= base_url().'conversation/videoCall' ?>",
				data: {from: "<?php echo $this->session->userdata['user_id']; ?>", to: audioChatWith.data },
				dataType: "JSON",
				type: "POST",
				success: function(response) {
					if (response.status == "success") {
						audio_session_id = response.session_id;
						audio_token = response.token;
						var data = {
							title: 'StartAudioChat',
							session_id: audio_session_id,
							token: audio_token,
							from: "<?php echo $this->session->userdata['user_name']; ?>"
						}

						session.signal({
								to: audioChatWith,
								type: 'audio',
								data: JSON.stringify(data)
							},
							function(error) {
								if (error) {
									console.log("audio signal error (" + error.code + "): " + error.message);
								} else {
									connectAudioStreaming(audio_session_id, audio_token);
									console.log("audio signal sent.");
								}
							}
						)
					} else {
						alert(audioChatWith + " is busy now. please try again later.");
					}
				}
			});
		} else {
			var data = {
				title: 'StartAudioChat',
				session_id: audio_session_id,
				token: audio_token,
				from: "<?php echo $this->session->userdata['user_name']; ?>"
			}

			session.signal({
					to: audioChatWith,
					type: 'audio',
					data: JSON.stringify(data)
				},
				function(error) {
					if (error) {
						console.log("audio signal error (" + error.code + "): " + error.message);
					} else {
						console.log("audio signal sent.");
					}
				}
			)
		}
	});

	function showAudioConfirmDialog(from, session_id, token) {
		if (confirm("Audio Call" + "\n" + from + " is calling you. accept?")) {
			$("#audioCallWindow .callDiv").addClass("active");
			$("#audioContactsList").removeClass("active");
			audio_session_id = session_id;
			audio_token = token;
			connectAudioStreaming(session_id, token);
		} else {
			
			var data = {
				title: 'EndAudioChat',
			}

			session.signal({
					type: 'audio',
					data: JSON.stringify(data)
				},
				function(error) {
					if (error) {
						console.log("audio signal error (" + error.code + "): " + error.message);
					} else {
						console.log("audio signal sent.");
					}
				}
			)
		}
	}

	session.on("signal:audio", function(event) {
		var audio_chat = JSON.parse(event.data);
		var audio_type = audio_chat.title;

		for(var connection in connections) {
			if (connections[connection].data == event.from.data) {
				break;
				audioChatWith = connections[connection];
			}
		}
		
		switch(audio_type) {
			case 'StartAudioChat':
				showAudioConfirmDialog(audio_chat.from, audio_chat.session_id, audio_chat.token);
				break;
			case 'EndAudioChat':
				if (Object.keys(audioConnections) < 2) {
					
					audioSession.unpublish(audio_publisher);
					audioSession.disconnect();

					delete audioConnections;
					delete audioSession;
					delete audio_session_id;
					delete audio_token;
					delete audio_publisher;
					delete audio_subscribers;

					$("#audioCallWindow").addClass("active");
					$("#audioCallWindow .callDiv").removeClass("active");
					$("#audioContactsList").removeClass("active");
				}
				break;
			case 'SwitchCall':

				break;
		}
	});

	$('#audioCallWindow .hangup').click(function(e) {
		audioSession.unpublish(audio_publisher);
		audioSession.disconnect();
		delete audioConnections;
		delete audioSession;
		delete audio_session_id;
		delete audio_token;
		delete audio_publisher;
		delete audio_subscribers;
		
		var data = {
			title: 'EndAudioChat',
		}

		session.signal({
				type: 'audio',
				data: JSON.stringify(data)
			},
			function(error) {
				if (error) {
					console.log("audio signal error (" + error.code + "): " + error.message);
				} else {
					console.log("audio signal sent.");
				}
			}
		);

		$("#audioCallWindow").addClass("active");
		$("#audiocallWindow .callDiv").removeClass("active");
		$("#audioContactsList").removeClass("active");
	});

	$(".switch-call").click(function(e) {
		
		if (!audioChatWith) {
			return false;
		}
		var _session_id;
		var _token;
		
		$.ajax({
			url: "<?= base_url().'conversation/videoCall' ?>",
			data: {from: "<?php echo $this->session->userdata['user_id']; ?>", to: audioChatWith.data },
			dataType: "JSON",
			type: "POST",
			success: function(response) {
				if (response.status == "success") {
					_session_id = response.session_id;
					_token = response.token;
					var data = {
						title: "SwitchCall",
						token: _token,
						session_id: _session_id,
					};

					session.signal({
							to: audioChatWith,
							type: 'audio',
							data: JSON.stringify(data)
						},
						function(error) {
							if (error) {
								console.log("switch call signal error (" + error.code + "): " + error.message);
							} else {
								console.log("switch call signal sent.");
							}
						}
					);
				}
			}
		});
	});
</script>
<?php } ?>