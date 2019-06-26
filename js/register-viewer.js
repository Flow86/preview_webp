document.addEventListener("DOMContentLoaded", function() {
	if (OCA.Viewer) {
		OCA.Viewer.availableHandlers.forEach(function(handler) {
            if(handler.id == "images") {
                handler.mimes.push('image/webp');
            }
        })
        /* video/webm already in 'videos' handler */
	}
});
