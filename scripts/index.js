let file,data,jsonData;
let start       = 0;
let paginate    = 10;

// void method fetches required file's part of content 
function getFileContent() 
{
    file        = $('#file').val();
    $.get("classes/file.php?file=" + file + "&start=" + start + "&paginate=" + paginate , function(response, status) {
        jsonData = JSON.parse(response);
        if(jsonData.code == 200){
            data = jsonData.data;
            $('#response').removeClass('text-danger');
            $('#response').html('');
            for (let i = 0; i < data.length; i++) {
                $('#response').append('<p class="index-p font-weight-bold">' + data[i] + '</p>');
            }

            // reset data start 
            $('.previous').attr('data-start' , jsonData.previous)
            $('.next').attr('data-start'     , jsonData.next)
            $('.end').attr('data-start'      , jsonData.end)
        }
        else{
            $('#response').addClass('text-danger');
            $('#response').html(jsonData.message);
        }
    });
}

$('.paginate').click(function()
{
    start =  $(this).attr('data-start');
    getFileContent();
});

$('form').submit(function(event)
{
    event.preventDefault();
    start =  0;
    getFileContent();
});
