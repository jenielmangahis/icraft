<template>
	<div id="app" class="container-fluid">
		<chat></chat>
	</div>
</template>

<script>
	import VideoChat from './components/VideoChat'

	export default {
		name: "App",
		components: {
			chat: VideoChat
		}
	}
</script>