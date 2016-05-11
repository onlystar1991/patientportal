<link rel="stylesheet" href="<?=base_url();?>assets/css/conversation.css">

<div id="conversationContainer">
	<div id="conversationMenu" class="section active">
		<div class="title">MENU</div>
		<ul>
			<li id="chatButton" class="active"><div style="background-image: url('<?=base_url();?>assets/images/icon_txtchat.png');"></div></li>
			<li id="audioCallButton"><div style="background-image: url('<?=base_url();?>assets/images/icon_audiochat.png');"></div></li>
			<li id="videoChatButton"><div style="background-image: url('<?=base_url();?>assets/images/icon_videochat.png');"></div></li>
			<li><div style="background-image: url('<?=base_url();?>assets/images/icon_doctorchat.png');"></div></li>
			<li id="contactsButton"><div style="background-image: url('<?=base_url();?>assets/images/icon_contactslist.png');"></div></li>
			<li><div id="exitButton" style="background-image: url('<?=base_url();?>assets/images/icon_exitwebrtc.png');"></div></li>
		</ul>
	</div>

	<div id="chatContactsList" class="section">
		<div class="title">ALEX CONTACTS</div>
		<ul class="chatContacts"></ul>
		<div class="title groups">GROUPS</div>
		<ul>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
			<li><div class="userPhoto"><img src="https://placeimg.com/50/50/any"></div><br><span>Robert M.</span></li>
		</ul>
	</div>

	<div id="latestConversations" class="section active">
		<div class="title">LATEST CONVERSATIONS</div>
		<ul></ul>
	</div>

	<div id="videoCallWindow" class="section callWindow">
		<div class="addContactButton" style="background-image: url('<?=base_url();?>assets/images/addusertocall.png'); z-index: 100;"></div>
		<div id="videoContactsList" class="callContactsList" style="z-index: 100;">
			<ul>
				<li>Test</li>
			</ul>
		</div>

		<div class="callDiv">
			<div class="one-on-one">
				<div class="caller" id="video_caller">
					<div class="hangup"></div>
				</div>
				<div class="callee">
				</div>
			</div>

			<div class="one-on-many">
				<div class="hangup"></div>
				<div class="big-brother" style="width: 1300px; height: 600px;">
					<div id="actived_user" style="width: 100%; height: 100%;">
					</div>
				</div>
				<div class="participants">
					<ul>
						<li id="small_caller"></li>
						<li><div class="participant"></div><div class="shadow"></div></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div id="audioCallWindow" class="section callWindow">
		<div class="addContactButton" style="background-image: url('<?=base_url();?>assets/images/addusertocall.png'); z-index: 100;"></div>
		<div id="audioContactsList" class="callContactsList" style="z-index: 100;">
			<ul>
				<li>Test</li>
			</ul>
		</div>

		<div class="callDiv">
			<div class="one-on-one">
				<div class="caller" id="audio_caller">
					<button class="switch-call" value="Switch To Video Call"></button>
					<div class="hangup"></div>
				</div>
				<div class="callee">
				</div>
			</div>

			<div class="one-on-many">
				<div class="hangup"></div>
				<div class="big-brother" style="width: 1300px; height: 600px;">
					<div id="actived_user_audio" style="width: 100%; height: 100%;">
					</div>
				</div>
				<div class="participants">
					<ul>
						<li id="small_caller_audio"></li>
						<li><div class="participant"></div><div class="shadow"></div></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div id="chatWindow" class="section active">
		<div class="title">IDESK CHAT</div>
		<div class="chatContainer">
			<ul></ul>
			<div id="sendBox">
				<textarea class="chatContent" value=""></textarea>
				<button class="sendChatButton sendButton">SEND</button>
			</div>
			<div id="buttonsForUser">
				<div class="call"></div>
				<div class="videoCall"></div>
				<div class="profile"></div>
			</div>
		</div>
		<hr/>
	</div>
</div>