var mini = true;
    function toggleMusicSidebar() {
        if (mini) {
            document.getElementById("musicSidebar").style.width = "350px";
			document.getElementById("audio-player-cont").style.visibility = "visible";			
            this.mini = false;
        } else {
            document.getElementById("musicSidebar").style.width = "30px";
			document.getElementById("audio-player-cont").style.visibility = "hidden";
			document.getElementById("audio-player-cont").style.transition = "all 0.5s";
			this.mini = true;
        }
    }
	function toggleChatSidebar() {
        if (mini) {
            document.getElementById("chatSidebar").style.width = "250px";
            this.mini = false;
        } else {
            document.getElementById("chatSidebar").style.width = "30px";
            this.mini = true;
        }
    }
