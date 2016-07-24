$(function() {
    $('.counter').each(function () {
        var self = $(this);
        $({ counter: 0 })
            .animate({ counter: self.text() }, {
                duration: 1000,
                easing: 'swing',
                step: function () {
                    self.text(Math.ceil(this.counter));
                }
            });
    });
});
