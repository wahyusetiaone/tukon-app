import {base_url} from './app.js'

$(document).ready(function () {
    let src = base_url+'/sound/notif.mp3';
    let audio = new Audio(src);

    var notif = $('#notif_klunting');

    $.ajax({
        url: base_url+"/client/notification/count/" + unix_id ,
        type: "GET",
        dataType: "json",
        success: function (data) {
            notif.text(data[0]);
            if (notif.text !== 0){
                notif.show();
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

    const channel = window.Echo.channel('private-user.'+unix_id)
        .listenToAll((event, data) => {
            // do what you need to do based on the event name and data
            // console.log(event, data)
            notif.text(data.unReadNotif);
            if (notif.text !== 0){
                notif.show();
            }
            audio.play()
        });
});
