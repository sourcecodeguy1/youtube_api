function tplawesome(e,t){res=e;for(var n=0;n<t.length;n++){res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){return t[n][r]})}return res}

$(function() {
    $("form").on("submit", function(e) {
       e.preventDefault();
       // prepare the request
       var request = gapi.client.youtube.search.list({
            part: "snippet",
            type: "video",
            q: encodeURIComponent($("#search").val()).replace(/%20/g, "+"),
            maxResults: 3,  // Set this to the number you want to display on the page.
           videoEmbeddable: true,
           videoSyndicated: true,

       });

       // execute the request
       request.execute(function(response) {
          var results = response.result;
          var totalResult = results.pageInfo.totalResults;

        if(totalResult > 0 ) { // Returns the number of total results.
            $("#results").html("");

            $.each(results.items, function (index, item) {


                $.get("tpl/item.html", function (data) {

                    $("#results").append(tplawesome(data, [{"title": item.snippet.title, "videoid": item.id.videoId}]));


                    $('.selection[data-selection-id=' + item.id.videoId + ']').on('click', function () {

                        let url = "update_db.php";
                        let song_name2 = item.snippet.title;
                        let youtube_id = item.id.videoId;

                        $.ajax({

                            url: url,
                            type: "GET",
                            data: {song_name2: song_name2, youtube_id: youtube_id},
                            success: function (data) {

                              if(data.msg === "success"){
								  
								alert(data.result);
							  
                            } else {
								alert(data.result);
                        });
                    });

                });

            }); // for each loop
            resetVideoHeight();
        } else {
            alert("An error has occurred. The video that you searched may be an invalid url, video is set to private by the owner, video is licensed, or not embeddable.");
        }
       });
    });
    
    $(window).on("resize", resetVideoHeight);
});

function resetVideoHeight() {
    $(".video").css("height", $("#results").width() * 9/16);
}

function youtube_api() {
    gapi.client.setApiKey("AIzaSyBPVixMBFipOyWOMkjIjoWqs8jaNORWQdk");
    gapi.client.load("youtube", "v3", function() {
        // yt api is ready
    });
}
