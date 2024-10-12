jQuery(document).ready(function ($) {
    if (arsData.lastSaved > 0) {
        const savedTime = parseInt(arsData.lastSaved);
        const refreshInterval = 3000;

        setInterval(() => {
            $.ajax({
                url: window.location.href,
                method: 'HEAD',
                success: function (_, status, xhr) {
                    const lastModified = new Date(xhr.getResponseHeader('Last-Modified')).getTime() / 1000;
                    if (lastModified > savedTime) {
                        console.log('Page refreshed due to update.');
                        location.reload(true);
                    }
                },
            });
        }, refreshInterval);
    }
});