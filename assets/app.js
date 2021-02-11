import './scss/app.scss';
let $ = require('jquery');

//Code
// setup an "add a video" link
let $addVideoLink = $('<a href="#" class="add_video_link btn btn-primary">Add a video</a>');
let $newLinkLi = $('<li></li>').append($addVideoLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of Videos
    let $collectionHolder = $('ul.video');

    // add the "add a video" anchor and li to the videos ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addVideoLink.on('click', function(e) {
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
        $('.remove-video').click(function(e) {
            e.preventDefault();

            $(this).parent().remove();

            return false;
        });
    }

//    LoadData


});

