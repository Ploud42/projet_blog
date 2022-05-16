$(document).ready(function () {
    let btn = $('#btn_post_comm');
    let post_id = $('#secret').val();
    let count = parseInt($('#badge').text());
    btn.on('click', function () {
        let pseudo = $('#pseudo_comm').val();
        let comment = $('#comment_txt').val();
        $.post('./create_comment.php', {
            pseudo: pseudo,
            comment: comment,
            post_id: post_id
        }, function (data) {
            console.log(data);
        }
        )
        if (count % 2 === 0) {
            $('#comments').append(`
        <div class="list-group-item list-group-item-action darker-bg">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><u>`+ pseudo + `</u></h5>
                <small><i>just now</i></small>
            </div>
            <p class="mb-1">`+ comment + `</p>
        </div>`)
        }
        else {
            $('#comments').append(`
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><u>`+ pseudo + `</u></h5>
                <small><i>just now</i></small>
            </div>
            <p class="mb-1">`+ comment + `</p>
        </div>`)
        }
        $('#badge').text(count++);
        $('#comment_txt').val("");
    })
});