jQuery(document).ready(function ($) {
    const postId = parseInt(arsData.currentPostId, 10);
    const lastSavedTime = parseInt(arsData.lastSaved, 10);
    const pollingInterval = 5000; // Poll every 5 seconds.

    function checkForUpdates() {
        $.ajax({
            url: arsData.ajaxUrl,
            method: 'POST',
            data: {
                action: 'check_page_update',
                post_id: postId,
            },
            success: function (response) {
                if (response.success && response.data.lastSaved > lastSavedTime) {
                    location.reload(true); // Reload with cache-busting.
                }
            },
        });

        setTimeout(checkForUpdates, pollingInterval); // Schedule next check.
    }

    checkForUpdates(); // Start polling.
});
