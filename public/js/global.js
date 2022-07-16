let dotsView;
if($('.slider-home').length)
{
    dotsView = true;
} else {
    dotsView = false;
}

$('.slider-home, .slider-album').slick({
    dots: dotsView,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 4000,
});

if($('.getPhoto').length > 0)
{
    $(document).on('click', '.getPhoto', function(){
        const image = $(this).find('img');
        const height = image.height();
        const width = $(this).width();
        console.log(height+'| '+width);
        const url = $(this).attr('data-photo-url');
        $('#photoFullScreen').attr('src', url);
        if(height > width)
        {
            const newWidth = (100/(height/width))-7;
            $('#photoFullScreen').attr('width', newWidth+'%');
            $('#photoAllScreen .modal-content').css({
                'background-color': 'var(--cu-color)',
                'display': 'flex',
                'justify-content': 'center',
                'align-items': 'center'
            })
        } else {
            $('#photoFullScreen').attr('width', '100%');
        }
    })
}