var Dashborad = function() {
    var dash = function() {
        $('body').on('click', '.authorizationAccount', function() {
                
                // Launch Popup
                var parameters = "location=1,width=800,height=650";
                parameters += ",left=" + (screen.width - 800) / 2 + ",top=" + (screen.height - 650) / 2;
                
                var win = window.open(url, 'connectPopup', parameters);
                
                var pollOAuth = window.setInterval(function () {
                    try {

                        if (win.document.URL.indexOf("code") != -1) {
                            window.clearInterval(pollOAuth);
                            win.close();
                            location.reload();
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }, 100);
            
        });
    }
    return {
        init: function() {
            dash();
        }
    }
}();