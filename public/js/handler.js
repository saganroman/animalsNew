$(document).ready(function () {

    $("#InSpecies").change(function () {
        var spID = $("#InSpecies").val();
        $("#InBreed").attr('disabled', false);
        $.ajax({
            type: "GET",
            url: "/getBreed/" + spID,
            cache: false,
            success: function (responce) {
                $("#InBreed").html(responce);
            }
        });


    });


});
//Увага ! markers- тварини-маркери, тобто масив що містить масив  тварин переданих з контроллера , а markers2- масив обєктів типу google.maps.marker
var markers2 = [];
var shapes = [];


//вивели drawingManager в центр
    var drawingManager = new google.maps.drawing.DrawingManager({
        map: map,
        drawingMode: google.maps.drawing.OverlayType.circle,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
            ]
        }
    });
//проходимось по всіх тваринах переданих з контроллера і вивводимо їх + інфовікна
    for (var i = 0; i < animals.length; i++) {
        var infowindow = new google.maps.InfoWindow({
            content: '',
            maxWidth: 200,
        });
     
        animals2.push(marker);
        infoString = "<div><img src=\"" + animals[i][4] + "\"><p><b>Кличка -</b>" + animals[i][0] + "</p>  <p> Вид-" + animals[i][1] + " <br> Порода- " + animals[i][2] + "  </p> " + animals[i][3] + " </div>";
        bindInfoWindow(marker, map, infowindow, infoString);
    }

////////////////////////////////////////////////////////////////

// Обробляємо намальовані фігури
    google.maps.event.addListener(drawingManager, 'circlecomplete', function (circle) {

        clearShapes();
        krug = new google.maps.Circle({
            center: circle.getCenter(),
            radius: circle.getRadius(),
            strokeColor: '#FF0000',
            strokeOpacity: 0.5,
        });
        shapes.push(krug);
        circle.setMap(null);
        shapes[shapes.length - 1].setMap(map);
        clearMarkers();
        for (var i = 0; i < animals.length; i++) {
            coord = new google.maps.LatLng(markers2[i].position.lat(), markers2[i].position.lng());
            if (google.maps.geometry.spherical.computeDistanceBetween(markers2[i].getPosition(), krug.getCenter()) <= krug.getRadius()) {
                markers2[i].setMap(map);
            }
        }
    });

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polyg) {
        clearShapes();

        draw = new google.maps.Polygon({
            paths: polyg.getPaths(),
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
        });
        shapes.push(polyg);
        polyg.setMap(null);
        shapes[shapes.length - 1].setMap(map);
        clearMarkers();
        for (var i = 0; i < markers2.length; i++) {
            coord = new google.maps.LatLng(markers2[i].position.lat(), markers2[i].position.lng());
            if (google.maps.geometry.poly.containsLocation(coord, draw)) {
                markers2[i].setMap(map);
            }
        }
    });
};

// *******************************************************************
function bindInfoWindow(marker, map, infowindow, description) {
    marker.addListener('click', function () {
        infowindow.setContent(description);
        infowindow.open(map, this);
    });
}
//********************************************************************


function clearMarkers() {
    for (var i = 0; i < animals.length; i++) {
        markers2[i].setMap(null);
    }
}
function clearShapes() {
    for (var i = 0; i < shapes.length; i++) {
        shapes[i].setMap(null);
    }
}