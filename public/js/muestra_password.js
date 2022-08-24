$(document).ready(function () {
    $("#show_hide_password-a a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password-a input').attr("type") == "text") {
            $('#show_hide_password-a input').attr('type', 'password');
            $('#show_hide_password-a i').addClass("fa-eye-slash");
            $('#show_hide_password-a i').removeClass("fa-eye");
        } else if ($('#show_hide_password-a input').attr("type") == "password") {
            $('#show_hide_password-a input').attr('type', 'text');
            $('#show_hide_password-a i').removeClass("fa-eye-slash");
            $('#show_hide_password-a i').addClass("fa-eye");
        }
    });
    $("#show_hide_password-b a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password-b input').attr("type") == "text") {
            $('#show_hide_password-b input').attr('type', 'password');
            $('#show_hide_password-b i').addClass("fa-eye-slash");
            $('#show_hide_password-b i').removeClass("fa-eye");
        } else if ($('#show_hide_password-b input').attr("type") == "password") {
            $('#show_hide_password-b input').attr('type', 'text');
            $('#show_hide_password-b i').removeClass("fa-eye-slash");
            $('#show_hide_password-b i').addClass("fa-eye");
        }
    });
    $("#show_hide_password-c a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password-c input').attr("type") == "text") {
            $('#show_hide_password-c input').attr('type', 'password');
            $('#show_hide_password-c i').addClass("fa-eye-slash");
            $('#show_hide_password-c i').removeClass("fa-eye");
        } else if ($('#show_hide_password-c input').attr("type") == "password") {
            $('#show_hide_password-c input').attr('type', 'text');
            $('#show_hide_password-c i').removeClass("fa-eye-slash");
            $('#show_hide_password-c i').addClass("fa-eye");
        }
    });
});