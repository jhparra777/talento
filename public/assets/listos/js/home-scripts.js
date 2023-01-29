var map, infowindow;
var markers = [];
var latLngmap;
var mapa;
var posicionEliminarMarca;
var locations = [];

window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}

gtag('js', new Date());
gtag('config', 'UA-147235291-1');

$(document).ready(function () {
    $('.carousel').carousel();
    
    $('.carousel').carousel({
        interval: 500
    });

    $('#carousel1').carousel();
    $('#carousel1').carousel({
        interval: 2000
    });

    $('#carouselcontact').carousel({
        interval: 2000
    });

    $('#carouselNoticias').carousel({
        interval: 4000
    });

    $('#fecNacimiento').datepicker({
        language: "es",
        format: "yyyy-mm-dd",
        autoclose: true
    });

    checkOffset();

    $(window).scroll(function () {
        checkOffset();
    });

    $(".mat-input").focus(function () {
        $(this).parent().addClass("is-active is-completed");
    });

    $(".mat-input").focusout(function () {
        if ($(this).val() === "")
            $(this).parent().removeClass("is-completed");
        $(this).parent().removeClass("is-active");
    });
});

function checkOffset() {
    $('.dropdown-toggle').dropdown();
}

function initMap() {
    consultaArrayMrcas();
    cargarTablaLocation();
    iniciarmapa();
}

function placeMarkerAndPanTo(latLng, map) {
    latLngmap = latLng;
    mapa = map;
    $('#modal_map').modal('show');
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function attachSecretMessage(marker, secretMessage) {
    var infowindow = new google.maps.InfoWindow({
        content: secretMessage
    });

    marker.addListener('mouseover', function () {
        infowindow.open(marker.get('map'), marker);
    });
    marker.addListener('mouseout', function () {
        infowindow.close();
    });

    marker.addListener('dblclick', function () {
        // ModaleliminarMarca(marker);
        console.log(marker);
    });
}