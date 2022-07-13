$('.slider-home').slick({
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 4000,
});
getHeight();
function getHeight()
{
    let elem = $('.slider-home img');
    for (let i = 0; i < elem.length; i++)
    {
        console.log($(elem[i]).height()+' '+$(elem[i]).width());
    }
}

$(document).ready(function(){
    $(document).on('click', '.slick-prev, .slick-next', getHeight);
})