import './scss/app.scss';
import $ from 'jquery';
global.$ = global.jQuery = $;


$(document).ready(function() {
//    LoadData
    //Selection de la classe moreBox et reduit le sous-ensemble puis le montre
    $(".moreBox").slice(0,4).show();
    //Slection de l'id showless et cache le boutton
    $('#showLess').hide().attr('style','display:none!important');
    //Slection de l'id loadMore et le cache
    $('#loadMore').hide().attr('style','display:none!important');
    //Calcul le nombre de trick visible
    let length = $(".moreBox:visible").length;
    //S'il y a des éléments caché en plus alors on fait apparaître le boutton loadmore
    if ($(".moreBox:hidden").length !== 0) {
        $("#loadMore").show();
    }
    //Lors du click sur le boutton loadMore
    $('#loadMore').on('click', function () {
        //On fait apparaitre la fleche pour le haut
        $('#showLess').show();
        //Si il n'y a pas d'élément en plus on cache le boutton lors du click
        if ($(".moreBox:hidden").length === 0) {
            $('#loadMore').fadeOut('slow');
        }
        //Lors du click on rajoute vers le bas 4 trick en plus
        $('.moreBox:hidden').slice(0, 4).slideDown();
    });

});

