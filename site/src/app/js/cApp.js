var cNotification = function (text) {
    text = text || '';

    UIkit.notification(text, {pos: 'top-right'});
};

var cApp = {
    init: function () {
        cSpinner.init();

        this.linkDataWindow();
        this.linkDataAjaxContent();
    },

    linkDataWindow: function () {
        $(document).on('click', 'a[data-window="true"]', function (e) {
            e.preventDefault();

            var window = cWindow.getWindowByType($(this).data('windowType'));

            cSpinner.show();
            $.ajax({
                url: $(this).attr('href'),
                success: function (response) {
                    if (response.content !== undefined) {
                        window.html(response.content);
                        window.dialog('open');
                    }
                    cSpinner.hide();
                }
            });
        });
    },

    linkDataAjaxContent: function () {
        var self = this;

        window.addEventListener("popstate", function (e) {
            self.getPageContent(location.href, false);
        });

        $(document).on('click', 'a[data-ajax-content="true"]', function (e) {
            e.preventDefault();

            if ($(this).attr('href').indexOf("#") === 0) {
                return;
            }
            self.getPageContent($(this).attr('href'), true);
        });
    },

    getPageContent: function (url, addEntry) {
        addEntry = addEntry === true;

        var self = this;

        cSpinner.show();
        $.get(url).done(function (response) {
            self.setPageContent(response);

            if (addEntry) {
                history.pushState(null, null, url);
            }

            cSpinner.hide();
        });
    },
    setPageContent: function (data) {
        var self = this;

        if (data.redirect && data.redirect.url) {
            self.getPageContent(data.redirect.url, true);
            return;
        }
        $('#appContent').html(data.content);
    }
};

//CApp.notification = CNotification;

// CApp.processingResponse = function (response) {
//     if (response.messages !== undefined && $.isArray(response.messages)) {
//         showMessages(response.messages);
//     }
//
//     function showMessages(messages) {
//         for (var index = 0, message; message = messages[index]; index++) {
//             CNotification(message);
//         }
//     }
// };

$(function () {
    cApp.init();
});