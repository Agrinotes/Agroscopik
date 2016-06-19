<script>
window.YouSite = Site.extend({
    run: function(next) {
        // Set default map height
        var navbarH = $(".site-navbar").outerHeight();
        var footerH = $(".site-footer").outerHeight();
        var mapH = $(window).height() - navbarH - footerH;

        $(".page-main").outerHeight(mapH);

        // this accessToken, you can get it to here ==> [ https://www.mapbox.com ]
        L.mapbox.accessToken = 'pk.eyJ1IjoiYW1hemluZ3N1cmdlIiwiYSI6ImNpaDVubzBoOTAxZG11dGx4OW5hODl2b3YifQ.qudwERFDdMJhFA-B2uO6Rg';

        //Create map
        var map = L.mapbox.map('map', 'mapbox.streets-satellite');

        // Create FeatureGroup
        var featureGroup = L.featureGroup();

        //Drawing polygons
        {% for plot in app.user.farm.plots %}
        {% if plot.latLngs is not empty %}
        var layer = L.geoJson({{ plot.latLngs | raw }});
        layer.setStyle({color: "white", opacity: 0.8, weight: 1.5});
        layer.bindPopup("<div class='friend-popup-info'><div class='detail'>" + "{{ plot.area }} ha" + "</div><h3 class=\"margin-top-10\">" + "{{ plot.name | capitalize }}"+"</h3><p class=\"margin-top-10\"><a type=\"button\" href=\"{{ path('plot_show',{'id':plot.id}) }}\" style=\"color:\"white\";\" class=\"btn btn-default btn-sm waves-effect waves-light\">Afficher</a></p></div>", {closeButton: false});
        featureGroup.addLayer(layer);
        {% endif %}
        {% endfor %}
        featureGroup.addTo(map);

        //Zoom to farm bounds
        var bounds = featureGroup.getBounds();
        map.fitBounds(bounds);
        next();
    }
});

$(document).ready(function(){
    YouSite.run();
});
</script>/**
 * Created by Utilisateur on 20/06/2016.
 */
