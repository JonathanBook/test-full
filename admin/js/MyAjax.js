

function MyajaxPost(my_url, custom_class, id_target, inputfileID, is_clear) {

    form = new FormData();

    if (inputfileID != null) {

        input = document.getElementById(inputfileID);

        file = $(input).prop('files')[0];

        form.append('file', file);
    }



    $('.' + custom_class).each(function () {

        if ($(this).val() != '') {

            form.append($(this).attr('data'), $(this).val());

        } else if ($(this).text() != '') {

            form.append($(this).attr('data'), $(this).text());

        } else {

            form.append($(this).attr('data'), 'endefine');
        }



    })


    if (is_clear == null) { is_clear = false; }
    my_post(my_url, form, id_target, is_clear)
}

function MyajaxFormPost(my_url, id_form, id_target, is_clear) {

    if (is_clear == null) { is_clear = false; }

    form = new FormData(document.getElementById(id_form));

    my_post(my_url, form, id_target, is_clear);

}

function my_post(my_url, my_data, id_target, is_clear) {

    if (is_clear == null) { is_clear = false; }

    $.ajax({
        type: "POST",
        url: my_url,
        data: my_data,
        processData: false,
        contentType: false,

        success: function (data) {
            if(id_target!=null){
                if (is_clear) {
                    $(id_target).html(data);
                   /*  console.log(data); */
                } else {
                    $(id_target).append(data);
                }
            }else{
                console.log('f');
                successCallback(data);
                console.log(data);
                return data;
            }
 

        }
    });
}

function Myajax(adresse, target, clear) {



    if (clear == null) {

        clear = false;
    }

    $.ajax({

        url: adresse,
        cache: false,

    })
        .done(function (data) {
            
            if (clear == false) {

                $(target).append(data);

            } else {

                $(target).html(data);
            }

        });
}

/* Fait aparaitre le menu pour l'ajout de group pour les team  */
function showForm(btn, btntarget, blocktarget) {
    $(btntarget).css('display', 'block');
    $(btn).css('display', 'none');
    $(blocktarget).css('display', 'block');

}

function hiddenForm(btn, btntarget, blocktarget) {
    $(btntarget).css('display', 'block');
    $(btn).css('display', 'none');
    $(blocktarget).css('display', 'none');

}


/* Permet de verifier la taille dune image */
function verifTaille(input, targetW, targetH) {
    file = input.files[0];
    window.URL = window.URL || window.webkitURL;
    img = new Image();

    img.onload = function () {
        if (img.width > targetW || img.height > targetH) {
            errorSieze(img.width - targetW, img.height - targetH);
        }
    }
    img.src = window.URL.createObjectURL(file);
}

function errorSieze(width, height) {
    var str = "votre image est trop "
    if (width > 0) { str += "large de " + width + "px"; }
    if (width > 0 && height > 0) { str += " et trop "; }
    if (height > 0) { str += "haute de " + height + "px."; }
    alert(str);
}


function readImg(input, id) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            
          $('#'+id).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
} 
