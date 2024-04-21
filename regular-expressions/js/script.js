$(function ()
{
    const nameRegEx = /[A-Z]+$/ ;
    const nikRegEx = /[0-9]{16}/g;
    const birthTimeRegEx = /^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[0-2])\/\d{4}$/g;
    const passwordRegEx = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[!@#$%^&*-_.;:'"]).{8,}$/;
    const emailRegEx = /[a-zA-Z0-9_#%^&*]+@[a-zA-Z0-9_]+\.[a-z]{2,}/;

    $('input').each(function ()
    {
        $(this).on('input', function ()
        {
            const pElement = $(this).parent().siblings().filter('p');

            if ($(this).attr('id') == 'name-regex')
            {
                if (nameRegEx.test($(this).val()))
                {
                    pElement.html('Nama Valid!')
                }
                else
                {
                    pElement.html('Nama tidak valid! Harus menggunakan huruf kapital!')
                }
            }
            else if ($(this).attr('id') == "nik-regex")
            {
                if (nikRegEx.test($(this).val()))
                {
                    pElement.html('NIK Valid!')
                }
                else
                {
                    pElement.html('NIK tidak valid! Harus terdiri dari 16 angka tanpa spasi!')
                }
            }
            else if ($(this).attr('id') == "birthtime-regex")
            {
                if (birthTimeRegEx.test($(this).val()))
                {
                    pElement.html('Tanggal Lahir Valid!')
                }
                else
                {
                    pElement.html('Tanggal Lahir Tidak Valid! Harus menggunakan format tt/bb/tttt')
                }
            }
            else if ($(this).attr('id') == "password-regex")
            {
                if (passwordRegEx.test($(this).val()))
                {
                    pElement.html('Password sudah kuat!')
                }
                else
                {
                    pElement.html('Password masih lemah! Harus memiliki kombinasi huruf kecil, huruf kapital, angka dan simbol!')
                }
            }
            else if ($(this).attr('id') == "email-regex")
            {
                if (emailRegEx.test($(this).val()))
                {
                    pElement.html('Email valid!')
                }
                else
                {
                    pElement.html('Email tidak valid!')
                }
            }
        })
    })
})