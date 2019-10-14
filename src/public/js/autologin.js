function Autologin() {
    var $container = $('.autologin');
    var $containerClose = $('.autologin .close');
    var $containerIcon = $('.autologin .icon');

    if (!$container.length) {
        return;
    }

    attach();

    function attach()
    {
        $containerIcon.click(toggleContainer);
        $containerClose.click(closeContainer);
    }

    function toggleContainer(event)
    {
        $container.toggleClass('closed');
        event.preventDefault();
    }

    function closeContainer(event)
    {
        $container.addClass('closed');
        event.preventDefault();
    }
}

$(function () {
    Autologin();
});
