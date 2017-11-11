function setUserpic(result)
{
    $.ajax(
        {
            url: inlineVars['render-userpic-frame-url'],
            type: "POST",
            data: {
                file_id : result.file_id,
                image_width: 300,
                image_height: 300
            },
            dataType: "html",
            success: function(response)
            {
                $('#userpic-image-frame').html(response);

                $('#userpic-load').addClass('hidden');

                $('#userpic_empty').addClass('hidden');

                $('#del-userpic').removeClass('hidden');
                $('#userpic_id').attr('value', result.file_id);
            }
        });
}
function loadUserpic()
{
    $('#userpic_empty').addClass('hidden');
    $('#userpic-form-error').addClass('hidden');
    $('#userpic-frame').addClass('hidden');
    $('#userpic-load').removeClass('hidden');
}

function errorUserpic(message)
{
    $('#userpic-form-error ul > li').html(message);
    $('#userpic-form-error').removeClass('hidden');

    $('#userpic-frame').removeClass('hidden');
    $('#userpic-load').addClass('hidden');
}
