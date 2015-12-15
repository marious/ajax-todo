var Result = function()
{
    //========================================================================================================

    this.__construct = function()
    {
        console.log('result created');
    };

    //========================================================================================================

    this.success = function(msg)
    {
        var dom = $('#success');
        dom.removeClass('hide');

        if ( typeof msg === 'undefined' ) {
            dom.html('Success').fadeIn();
        }
        dom.html(msg).fadeIn();
        setTimeout(function() {
            dom.fadeOut();
        }, 4000);
    };

    //========================================================================================================

    this.error = function(msg)
    {
        var dom = $('#error');
        dom.removeClass('hide');

        if ( typeof msg === 'undefined' ) {
            dom.html('Error').fadeIn();
        }
        else {
            if ( typeof msg == 'object' ) {
                var output = '<ul>';
                for (var key in msg) {
                    output += '<li>' + msg[key] + '</li>';
                }
                output += '</ul>';
                dom.html(output).fadeIn();
            } else {
                dom.html(msg).fadeIn();
            }
        }

        setTimeout(function() {
            dom.fadeOut();
        }, 4000);
    };

    //========================================================================================================

    this.__construct();
};