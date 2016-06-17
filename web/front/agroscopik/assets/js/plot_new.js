(function (document, window, $) {
    'use strict';

    window.AppPlotNew = App.extend({
        createMap: function () {
            // Mapbox access token
            L.mapbox.accessToken = 'pk.eyJ1IjoiaHVnb2xlaG91eCIsImEiOiItOHl6Sm5jIn0.12l_k0K_Z28UE-Jc0kDgpw';

            // Create the map
            var map = L.mapbox.map('map', 'mapbox.streets-satellite').setView([38.97416, -95.23252], 15);

            // Add GeoRep
            var georep = L.tileLayer.wms('https://carto10.gouv.nc/arcgis/services/fond_imagerie/MapServer/WMSServer', {
                format: 'img/png',
                transparent: true,
                layers: 16,
                maxZoom: 26
            });

            // Display GeoRep according to zoom level
            map.on('zoomend', function () {
                if (map.getZoom() > 9 && map.hasLayer(georep) == false) {
                    map.addLayer(georep);
                }
                if (map.getZoom() < 9 && map.hasLayer(georep)) {
                    map.removeLayer(georep);
                }
            });

            // Where the polygons are stored
            var featureGroup = L.featureGroup().addTo(map);

            // Enable drawing polygons
            var drawControl = new L.Control.Draw({
                edit: {
                    featureGroup: featureGroup,
                    selectedPathOptions: {
                        dashArray: "8,6",
                        color: 'white',
                        opacity: 0.8,
                        weight: 1.5
                    }
                },
                draw: {
                    polyline: false,
                    circle: false,
                    marker: false,
                    rectangle: false,
                    polygon: {
                        shapeOptions: {
                            dashArray: "8,6",
                            color: 'white',
                            opacity: 0.8,
                            weight: 1.5
                        }
                    }
                }
            }).addTo(map);

            // Change Leaflet draw messages
            L.drawLocal = {
                draw: {
                    toolbar: {
                        actions: {
                            title: 'Annulez le dessin',
                            text: 'Annuler'
                        },
                        buttons: {
                            polyline: 'Dessiner une polyligne',
                            polygon: 'Dessiner ma parcelle',
                            rectangle: 'Dessiner un rectangle',
                            circle: 'Dessiner un cercle',
                            marker: 'Dessiner un marqueur'
                        }
                    },
                    handlers: {
                        circle: {
                            tooltip: {
                                start: 'Cliquez et déplacez pour dessiner un cercle.'
                            }
                        },
                        marker: {
                            tooltip: {
                                start: 'Cliquez sur la carte pour placer un marqueur.'
                            }
                        },
                        polygon: {
                            tooltip: {
                                start: 'Cliquez pour commencer à dessiner la parcelle.',
                                cont: 'Cliquez pour continuer à dessiner la parcelle.',
                                end: 'Cliquez sur le premier point pour fermer cette parcelle.'
                            }
                        },
                        polyline: {
                            error: '<strong>Erreur:</strong> Les arrêtes de la forme ne doivent pas se croiser!',
                            tooltip: {
                                start: 'Cliquez pour commencer à dessiner d\'une ligne.',
                                cont: 'Cliquez pour continuer à dessiner une ligne.',
                                end: 'Cliquez sur le dernier point pour terminer la ligne.'
                            }
                        },
                        rectangle: {
                            tooltip: {
                                start: 'Cliquez et déplacez pour dessiner un rectangle.'
                            }
                        },
                        simpleshape: {
                            tooltip: {
                                end: 'Relachez la souris pour finir de dessiner.'
                            }
                        }
                    }
                },
                edit: {
                    toolbar: {
                        actions: {
                            save: {
                                title: 'Sauvegardez les changements.',
                                text: 'Sauver'
                            },
                            cancel: {
                                title: 'Annulez l\'édition, ignorer tous les changements.',
                                text: 'Annuler'
                            }
                        },
                        buttons: {
                            edit: 'Editer la parcelle.',
                            editDisabled: 'Pas de parcelle à éditer.',
                            remove: 'Supprimer la parcelle.',
                            removeDisabled: 'Pas de parcelle à supprimer.'
                        }
                    },
                    handlers: {
                        edit: {
                            tooltip: {
                                text: 'Déplacez les points pour éditer la parcelle.',
                                subtext: 'Cliquez sur Annuler pour revenir sur les changements.'
                            }
                        },
                        remove: {
                            tooltip: {
                                text: 'Cliquez sur l\'objet à enlever'
                            }
                        }
                    }
                }
            };

            // On draw created, add polygon values to the form
            map.on('draw:created', function (e) {
                var layer = e.layer;
                featureGroup.clearLayers();
                featureGroup.addLayer(layer);
                $("#plot_area").val(getPolygonArea(layer));
                var latLngs = JSON.stringify(layer.toGeoJSON());
                $("#plot_latLngs").val(latLngs);
                map.fitBounds(layer.getBounds());
            });

            // On draw created, add polygon values to the form
            map.on('draw:edited', function (e) {
                e.layers.eachLayer(function (layer) {
                    featureGroup.clearLayers();
                    featureGroup.addLayer(layer);
                    $("#plot_area").val(getPolygonArea(layer));
                    var latLngs = JSON.stringify(layer.toGeoJSON());
                    $("#plot_latLngs").val(latLngs);
                });
            });

            // Get Polygon Area
            function getPolygonArea(layer) {
                var area = LGeo.area(layer) / 10000;
                return area.toFixed(3) ;
            }
        }
        ,
        run: function () {
            this.createMap();
        }
    });

    $(document).ready(function ($) {
        AppPlotNew.run();
    })
}(document, window, jQuery));
