$(document).ready(() => {

$('.main').load('/user/form');



$('#submit').click(async (e) => {
    // e.preventDefault();

    let username = $('#username').val();
    let password = $('#password').val();

    $('#username').css('border', '1px solid #fff');
    $('#password').css('border', '1px solid #fff');
    $('#error').html('');

    let param = {
        username: username,
        password: password
    }

    // let result = await fetch('user/login', {
    //     method: 'POST',
    //     body: param
    //   });

    let result = await checkLogin(param);

    console.log(result);
    if (result == 1) {
        window.location.href = '/product/create';
    } else {
        $('#username').css('border', '2px solid #DC143C');
        $('#password').css('border', '2px solid #DC143C');
        $('#error').html('Username or password is incorrect').css({
            'color': '#DC143C',
            'font-size': '1vmax',
        });
        // window.location.href = "/user";
        // return false;
    }
    // U


function checkLogin(param) {
    return $.ajax({
        type: 'POST',
        data: param,
        url: 'user/login',
        // done: function () {
        //     window.location.href = "/user";
        // }
    })
}

})


})
