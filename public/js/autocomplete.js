$(document).ready(function () {

    $("#InSpecies").change(function () {
        var spID = $("#InSpecies").val();
        $("#InBreed").attr('disabled', false);
        $.ajax({
            type: "GET",
            url: "/getBreedPort/" + spID,
            cache: false,
            success: function (responce) {
                $("#InBreed").html(responce);
            }
        });
    });
});
var autocomplete, input;
function initAutocomplete() {

    input = document.getElementById('myIn');
    autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    document.getElementById('LatLn').value = place.geometry.location;
}

