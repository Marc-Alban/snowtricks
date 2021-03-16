import './scss/app.scss';
import $ from 'jquery';

global.$ = global.jQuery = $;

//Code
// setup an "add a video" link
let $addVideoLink = $('<a href="#" class="add_video_link btn btn-primary">Add a url</a>');
let $newLinkLi = $('<li></li>').append($addVideoLink);

$(document).ready(function () {
//Video add
// Get the ul that holds the collection of Videos
    let $collectionHolder = $('ul.video');

// add the "add a video" anchor and li to the videos ul
    $collectionHolder.append($newLinkLi);

// count the current form inputs we have (e.g. 2), use that as the new
// index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addVideoLink.on('click', function (e) {
// prevent the link from creating a "#" on the URL
        e.preventDefault();

// add a new Video form (see code block below)
        addVideoForm($collectionHolder, $newLinkLi);
    });

    function addVideoForm($collectionHolder, $newLinkLi) {
// Get the data-prototype explained earlier
        let prototype = $collectionHolder.data('prototype');

// get the new index
        let index = $collectionHolder.data('index');

// Replace '$$name$$' in the prototype's HTML to
// instead be a number based on how many items we have
        let newForm = prototype.replace(/__name__/g, index);

// increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

// Display the form in the page in an li, before the "Add a Video" link li
        let $newFormLi = $('<li></li>').append(newForm);

// also add a remove button, just for this example
        $newFormLi.append('<a href="#" class="remove-video btn btn-danger">Delete URL</a>');

        $newLinkLi.before($newFormLi);

// handle the removal, just for this example
        $('.remove-video').click(function (e) {
            e.preventDefault();

            $(this).parent().remove();

            return false;
        });
    }

    /* ****** LoadMore Tricks buttons ***** */
    let tricksPerPage = 15;

    let tricks = $(".trick-card-div");

    for (let i = tricksPerPage; i <= tricks.length - 1; i++) {
        tricks[i].remove();
    }
    $('#showLess').hide().attr('style', 'display:none!important');

    if (tricks.length <= tricksPerPage) {
        $("#loadMoreTricksBtn").fadeOut('slow');
        $("#showLess").show();
        $("#loadMoreTricksBtn").on("click", function(e) {
            e.preventDefault();
            tricksPerPage += 5;
            for (let i = 0; i <= tricksPerPage - 1; i++) {
                $("#trickList").append(tricks[i]);
            }
        });
    }


    /* ****** LoadMore comments button ***** */
    let commentsPerPage = 10;
    let comments = $("div.trick-comment");
    if (comments.length <= commentsPerPage) {
        $("#loadMoreCommentsBtn").hide();
    }

    for (let i = commentsPerPage; i <= comments.length - 1; i++) {
        comments[i].remove();
    }

    $("#loadMoreCommentsBtn").on("click", function(e) {
        e.preventDefault();
        commentsPerPage += 5;
        for (let i = 0; i <= commentsPerPage - 1; i++) {
            $("#trickComments").append(comments[i]);
        }
        if (comments.length <= commentsPerPage) {
            $("#loadMoreCommentsBtn").hide();
        }
    });

    // Load more media
    let mediaPerPage = 0;
    let medias = $("div.mediaLoadMore");
    let btnLoadMedia = $("#loadMoreMediaBtn");
    let width = $(window).width();
    btnLoadMedia.hide();

    if(width < 769){
        btnLoadMedia.show();

        for (let i = mediaPerPage; i <= medias.length; i++){
            medias.remove();
        }

        btnLoadMedia.on("click", function(e){
            e.preventDefault();
            mediaPerPage += 5
            for(let j = 0;j<=mediaPerPage;j++){
                $("#mediaTrick").append(medias[j]);
            }
            if (medias.length <= mediaPerPage) {
                btnLoadMedia.hide();
            }
        })
    }

    /*Filename custom*/
    $('.custom-file-input').on('change', function(event) {
        let inputFile = event.currentTarget;
        $(inputFile).parent()
            .find('.custom-file-label')
            .html(inputFile.files[0].name);
    });

    //Btn Form
    $("body").on("submit", "form", function() {
        $(this).submit(function() {
            return false;
        });
        return true;
    });
});

