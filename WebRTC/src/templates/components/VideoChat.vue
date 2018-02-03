<template>
	<div class="row vh-full">
		<div class="col-sm-8 px-0 video-container">
			<video id="caller" class="position-relative col-sm-12"></video>
			<video id="callee" class="position-absolute col-sm-2"></video>
		</div>
		<div class="col-sm-4 px-0 chat-container">
			<div class="hcs d-flex"></div>
			<div class="bct d-flex">
				<div class="col">
					<div class="msg bg-primary text-white" v-for="message in messages">
						<span class="from">{{message.text}}</span>
					</div>
				</div>
			</div>
			<div class="ict d-flex px-0 col border-top">
				<div class="col-sm-10 px-0 chat-input">
					<div class="form-group my-0">
						<input class="form-control form-control-lg border-0" type="text" name="pid" id="pid" placeholder="Peer ID">
						<input class="form-control form-control-lg border-0" placeholder="Send a message" name="message" id="message">
					</div>
				</div>
				<div class="col-sm-1 px-0 text-center">
					<button class="btn btn-link btn-lg btn-send px-0">
						<span class="fas fa-arrow-alt-circle-right"></span>
					</button>
				</div>
				<div class="col-sm-1 px-0 text-center">
					<button class="btn btn-link btn-lg btn-call px-0">
						<span class="fas fa-phone"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'VideoChat',
		props: {},
		data: function () {
			return {
				messages: [{from: 'justin', text: 'hello!!'}]
			}
		},
		methods: {

		},
		mounted: function() {
			var that = this
			var pid, name, conn
			var peer = new Peer({
				host: 'localhost',
				port: 3000,
				path: '/api',
				debug: 3,
				config: {'iceServers': [
				{ url: 'stun:stun1.l.google.com:19302' },
				{ url: 'turn:numb.viagenie.ca', credential: 'muazkh', username: 'webrtc@live.com' }
				]}
			})

			// connect automatically
			name = 'jhon'
			pid = $('#pid').val()
			if(pid){
				conn = peer.connect(pid, {metadata: {
					'username': name
				}})
				conn.on('data', handleMessage)
			}

			peer.on('open', that.peerOpen)

			navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia

			peer.on('open', function(){
				$('#pid').text(peer.id)
			})

			navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia

			function getVideo(callback){
				navigator.getUserMedia({audio: true, video: true}, callback, function(error){
					console.log(error)
					alert('An error occured. Please try again')
				})
			}

			getVideo(function(stream){
				window.localStream = stream
				onReceiveStream(stream, 'caller')
			})

			function onReceiveStream(stream, element_id){
				var video = $('#' + element_id + ' video')[0]
				video.src = window.URL.createObjectURL(stream)
				window.peer_stream = stream
			}

			peer.on('connection', function(connection){
				conn = connection
				pid = connection.peer
				conn.on('data', handleMessage)

				$('#pid').addClass('hidden').val(pid)
				console.log(connection.metadata.username)
			})

			function handleMessage(data){
				that.messages.push(data)
			}

			function sendMessage(){
				var text = $('#message').val()
				var data = {'from': name, 'text': text}

				conn.send(data)
				handleMessage(data)
				$('#message').val('')
			}

			$('#message').keypress(function(e){
				if(e.which == 13){
					sendMessage()
				}
			})

			$('.btn-send').click(sendMessage)

			$('.btn-call').click(function(){
				console.log('now calling: ' + pid)
				console.log(peer)
				var call = peer.call(pid, window.localStream)
				call.on('stream', function(stream){
					window.peer_stream = stream
					onReceiveStream(stream, 'callee')
				})
			})

			peer.on('call', function(call){
				onReceiveCall(call)
			})

			function onReceiveCall(call){
				call.answer(window.localStream)
				call.on('stream', function(stream){
				window.peer_stream = stream
					onReceiveStream(stream, 'callee')
				})
			}
		}
	}
</script>