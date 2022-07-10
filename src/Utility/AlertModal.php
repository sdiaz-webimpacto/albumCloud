<?php


namespace App\Utility;


class AlertModal
{
    public static function printModal($text, $icon)
    {
        echo "<script>setTimeout(function(){
            Swal.fire({
            position: 'center',
            icon: '".$icon."',
            title: '".$text."',
            showConfirmButton: false,
            timer: 2500
})
        },500)
        </script>";
    }
}
