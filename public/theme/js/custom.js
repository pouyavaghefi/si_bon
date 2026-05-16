function makeNumbersPersian(e) {
    if (e == null)
        return;
    e = e.toString();
    var pNumbers = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return e.replace(/[0-9]/g, function(w){
        return pNumbers[+w]
    });
}

$(".persian-number").keypress( function (event)
{
    event.preventDefault();
    var numbers = String.fromCharCode(event.keyCode).replace(/,/g, '');
    $(this).val(
        $(this).val() + makeNumbersPersian(
        makeEnglish(numbers)
        )
    );
});

$(".persian-number-force").keypress( function (event)
{
    $("#min-or-max-wrong").remove();
    $(this).css({'border' : "1px #dbe2e8 solid"});
    $("#order-price-section").addClass('d-none');
    event.preventDefault();
    if(!$.isNumeric(parseFloat(String.fromCharCode(event.keyCode))) && String.fromCharCode(event.keyCode) != '.')
        return;
    var min = parseFloat($(this).attr('min'));
    var max = parseFloat($(this).attr('max'));

    var numbers = String.fromCharCode(event.keyCode).replace(/,/g, '');

    if(parseFloat(makeEnglish($(this).val() + makeEnglish(numbers))) > max || parseFloat(makeEnglish($(this).val() + makeEnglish(numbers))) < min) {
        $(this).css({'border' : "1px red solid"});
        $(this).parent('div').append('<span id="min-or-max-wrong" style="font-size: 11px" class="text-danger">عدد وارد شده خارج از بازه مجاز میباشد.</span>');
        $("#order-price-section").addClass('d-none');
        if(parseFloat(makeEnglish($(this).val() + makeEnglish(numbers))) > max )
            return;
    }

    $(this).val(
        $(this).val() + makeNumbersPersian(
        makeEnglish(numbers)
        )
    );

});

$(".persian-price").keyup( function ()
{
    var numbers = $(this).val().replace(/,/g, '');
    $(this).val(
        makeNumbersPersian(
            numberWithCommas(
                makeEnglish(numbers)
            )
        )
    );
});

function makeEnglish(str)
{
    var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
        arabicNumbers  = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
    if(typeof str === 'string')
    {
        for(var i=0; i<10; i++)
        {
            str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
        }
    }
    return str;
};

function numberWithCommas(x)
{
    return x.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}