var mini = true;
    function toggleMusicSidebar() {
        if (mini) {
            document.getElementById("musicSidebar").style.width = "250px";
            this.mini = false;
        } else {
            document.getElementById("musicSidebar").style.width = "30px";
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