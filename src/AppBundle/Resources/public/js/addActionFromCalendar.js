<script type="text/javascript">
    $(document).ready(function () {
        var $container = $('div#action_calendar_periods');
        var index = $container.find(':input').length;
        $('#add_period').click(function (e) {
            addPeriod($container);

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        if (index == 0) {
            addPeriod($container);
            $("#action_calendar_periods > div > a").remove();

        } else {
            $container.children('div').each(function () {
                addDeleteLink($(this));
            });
        }

        function addPeriod($container) {
            var template = $container.attr('data-prototype')
                    .replace(/__name__label__/g, '')
                    .replace(/__name__/g, index)
                    .replace(/Start datetime/g, "Début d'intervention")
                    .replace(/End datetime/g, "Fin d'intervention")
                    .replace(/form-group/g, "form-group col-lg-12")


                ;

            var $prototype = $(template);
            addDeleteLink($prototype);
            $container.append($prototype);


            $('input[id*="startDatetime_time"]').addClass("time start");
            $('input[id*="startDatetime_date"]').addClass("date start");
            $('input[id*="endDatetime_time"]').addClass("time end");
            $('input[id*="endDatetime_date"]').addClass("date end");

            // initialize input widgets first
            $('.time').timepicker({
                'showDuration': true,
                'timeFormat': 'G:i',
                'show2400': true
            });

            $('.date').datepicker({
                'format': 'dd/mm/yyyy',
                'startView': 'months',
                'minView': 'days',
                'language': 'fr',
                'autoclose': true
            });

            // initialize datepair
            var basicExampleEl = document.getElementById('action_calendar_periods_' + (index));
            var datepair = new Datepair(basicExampleEl, {
                anchor: 'null'
            });

            index++;
        }

        function addDeleteLink($prototype) {
            var $deleteLink = $('<a href="#" style="position: absolute;top: -35px;right:20px;"><i class="btn btn-pure btn-danger icon wb-trash" aria-hidden="true"></i></a>');
            $prototype.append($deleteLink);
            $deleteLink.click(function (e) {
                $prototype.remove();

                index--;

                e.preventDefault();
                return false;
            });
        }
    });
</script>

{% if app.user.farm.farmSpecialities is not empty %}
<script type="text/javascript">
    $(document).ready(function () {
        var $container2 = $('div#action_calendar_farmSpecialityMvts');
        var index2 = $container2.find(':input').length;
        $('#add_mvt').click(function (e) {
            addMvt($container2);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        if (index2 == 0) {
            addMvt($container2);
            $("#action_calendar_farmSpecialityMvts > div > a").remove();
        } else {
            $container2.children('div').each(function () {
                addDeleteLink2($(this));
            });
        }

        function addMvt($container2) {
            var template2 = $container2.attr('data-prototype')
                    .replace(/__name__label__/g, '')
                    .replace(/__name__/g, index2)
                    .replace(/form-group/g, "col-lg-6")
                    .replace(/col-lg-6/, "col-lg-12")
                    .replace(/col-lg-6/, "col-lg-12")
                    .replace(/col-lg-6/, "col-lg-12")
                ;

            var $prototype2 = $(template2);
            addDeleteLink2($prototype2);
            $container2.append($prototype2);

            index2++;
        }

        function addDeleteLink2($prototype2) {
            var $deleteLink2 = $('<a href="#" style="margin: none; position: relative;top: -35px;right:20px;"><i class="btn btn-pure btn-danger icon wb-trash" aria-hidden="true"></i></a>');
            $prototype2.append($deleteLink2);
            $deleteLink2.click(function (e) {
                $prototype2.remove();

                index2--;

                e.preventDefault();
                return false;
            });
        }
    });
</script>
{% endif %}

{% if app.user.farm.farmFertilizers is not empty %}
<script type="text/javascript">
    $(document).ready(function () {
        var $container4 = $('div#action_calendar_farmFertilizerMvts');
        var index4 = $container4.find(':input').length;
        $('#add_ferti_mvt').click(function (e) {
            addFertiMvt($container4);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        if (index4 == 0) {
            addFertiMvt($container4);
            $("#action_calendar_farmFertilizerMvts > div > a").remove();
        } else {
            $container4.children('div').each(function () {
                addDeleteLink4($(this));
            });
        }

        function addFertiMvt($container4) {
            var template4 = $container4.attr('data-prototype')
                    .replace(/__name__label__/g, '')
                    .replace(/__name__/g, index4)
                    .replace(/form-group/g, "col-lg-6")
                    .replace(/col-lg-6/, "col-lg-12")
                    .replace(/col-lg-6/, "col-lg-12")
                    .replace(/col-lg-6/, "col-lg-12")

                ;

            var $prototype4 = $(template4);
            addDeleteLink4($prototype4);
            $container4.append($prototype4);

            index4++;
        }

        function addDeleteLink4($prototype4) {
            var $deleteLink4 = $('<a href="#" style="margin: none; position: relative;top: -35px;right:20px;"><i class="btn btn-pure btn-danger icon wb-trash" aria-hidden="true"></i></a>');
            $prototype4.append($deleteLink4);
            $deleteLink4.click(function (e) {
                $prototype4.remove();

                index4--;

                e.preventDefault();
                return false;
            });
        }
    });
</script>
{% endif %}

<script type="text/javascript">
    $(document).ready(function () {
        var $container3 = $('div#action_calendar_harvestProducts');
        var index3 = $container3.find(':input').length;
        $('#add_harvest').click(function (e) {
            addHarvest($container3);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        if (index3 == 0) {
            addHarvest($container3);
            $("#action_calendar_harvestProducts > div > a").remove();

        } else {
            $container3.children('div').each(function () {
                addDeleteLink3($(this));
            });
        }

        function addHarvest($container3) {
            var template3 = $container3.attr('data-prototype')
                    .replace(/__name__label__/g, '')
                    .replace(/__name__/g, index3)
                    .replace(/form-group/g, "form-group col-lg-12")


                ;

            var $prototype3 = $(template3);
            addDeleteLink3($prototype3);
            $container3.append($prototype3);

            index3++;
        }

        function addDeleteLink3($prototype3) {
            var $deleteLink3 = $('<a href="#" style="margin: none; position: relative;top: -35px;right:20px;"><i class="btn btn-pure btn-danger icon wb-trash" aria-hidden="true"></i></a>');
            $prototype3.append($deleteLink3);
            $deleteLink3.click(function (e) {
                $prototype3.remove();

                index3--;

                e.preventDefault();
                return false;
            });
        }
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        var $container6 = $('div#action_calendar_expenses');
        var index6 = $container6.find(':input').length;
        $('#add_expense').click(function (e) {
            addExpense($container6);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        if (index6 == 0) {
            addExpense($container6);
            $("#action_calendar_expenses > div > a").remove();

        } else {
            $container6.children('div').each(function () {
                addDeleteLink6($(this));
            });
        }

        function addExpense($container6) {
            var template6 = $container6.attr('data-prototype')
                    .replace(/__name__label__/g, '')
                    .replace(/__name__/g, index6)
                    .replace(/form-group/g, "col-lg-6")
                    .replace(/col-lg-6/, "col-lg-12")



                ;

            var $prototype6 = $(template6);
            addDeleteLink6($prototype6);
            $container6.append($prototype6);

            index6++;
        }

        function addDeleteLink6($prototype6) {
            var $deleteLink6 = $('<a href="#" style="margin: 0px; padding:0px; position: relative;top: -35px;right:20px;"><i class="wb-close" aria-hidden="true"></i></a>');
            $prototype6.append($deleteLink6);
            $deleteLink6.click(function (e) {
                $prototype6.remove();

                index6--;

                e.preventDefault();
                return false;
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var $container7 = $('div#action_calendar_irrigations');
        var index7 = $container7.find(':input').length;
        $('#add_irrigation').click(function (e) {
            addIrrigation($container7);
            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });

        if (index7 == 0) {
            addIrrigation($container7);
            $("#action_calendar_irrigations > div > a").remove();


        } else {
            $container7.children('div').each(function () {
                addDeleteLink7($(this));

            });
        }

        function addIrrigation($container7) {

            var template7 = $container7.attr('data-prototype')
                    .replace(/__name__label__/g, '')
                    .replace(/__name__/g, index7)
                    .replace(/form-group/g, "col-lg-12 irrigation"+index7)

                ;

            var $prototype7 = $(template7);

            addDeleteLink7($prototype7);

            $container7.append($prototype7);

            index7++;
        }

        function addDeleteLink7($prototype7) {
            var $deleteLink7 = $('<a href="#" style=" relative;top: -35px;right:20px;"><i class="wb-close" aria-hidden="true"></i></a>');
            $prototype7.append($deleteLink7);
            $deleteLink7.click(function (e) {
                $prototype7.remove();

                index7--;

                e.preventDefault();
                return false;
            });
        }


    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#farmSpecialities').hide();
        $('#farmFertilizers').hide();
        $('#harvestProducts').hide();
        $('#density').hide();
        $('#auxiliary').hide();
        $('#ph').hide();
        $('#irrigations').hide();
        $('#tankVolume').hide();
        $('#drainage').hide();


        $('#action_calendar_intervention').on('change', function () {
            if ($("#action_calendar_intervention").select2('data')[0]['text'] == "Traitement phytosanitaire") {
                $('#density').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#auxiliary').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#farmSpecialities').show("slow");

                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");

            } else if ($("#action_calendar_intervention").select2('data')[0]['text'] == "Fertilisation") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#auxiliary').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#farmFertilizers').show("slow");

                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");

            }else if ($("#action_calendar_intervention").select2('data')[0]['text'] == "Préparation d'une cuve de solution-mère") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#auxiliary').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#drainage').hide("slow");

                $('#farmFertilizers').show("slow");
                $('#tankVolume').show("slow");


                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");

            }else if ($("#action_calendar_intervention").select2('data')[0]['text'] == "Irrigation"||$("#action_calendar_intervention").select2('data')[0]['text'] == "Programme d'irrigation") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#auxiliary').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#ph').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#tankVolume').hide();
                $('#drainage').hide("slow");

                $('#irrigations').show("slow");

                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");

            }else if ($("#action_calendar_intervention").select2('data')[0]['text'] == "Récolte") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#auxiliary').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#harvestProducts').show("slow");

                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");


            }else if($("#action_calendar_intervention").select2('data')[0]['text'].indexOf('auxiliaire') > -1) {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#auxiliary').show("slow");

                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");
            }
            else if ($("#action_calendar_intervention").select2('data')[0]['text'] == "Semis direct" ||
                $("#action_calendar_intervention").select2('data')[0]['text'] == "Semis pépinière" ||
                $("#action_calendar_intervention").select2('data')[0]['text'] == "Repiquage/Plantation" ||
                $("#action_calendar_intervention").select2('data')[0]['text'] == "Semis") {
                $('#farmSpecialities').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#auxiliary').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#density').show("slow");

                $('#periods').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");

            } else if($("#action_calendar_intervention").select2('data')[0]['text'] == "Observation") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#auxiliary').hide("slow");
                $('#periods').hide("slow");
                $('#nbWorkers').hide("slow");
                $('#expenses').hide("slow");
                $('#tractors').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide();
                $('#tankVolume').hide();
                $('#drainage').hide("slow");

            } else if($("#action_calendar_intervention").select2('data')[0]['text'] == "Relevé pH/EC") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#auxiliary').hide("slow");
                $('#expenses').hide("slow");
                $('#tractors').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#ph').show("slow");

                $('#nbWorkers').show("slow");
                $('#periods').show("slow");
            }else if($("#action_calendar_intervention").select2('data')[0]['text'] == "Relevé de drainage") {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#auxiliary').hide("slow");
                $('#expenses').hide("slow");
                $('#tractors').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#ph').hide("slow");

                $('#drainage').show("slow");

                $('#nbWorkers').show("slow");
                $('#periods').show("slow");
            }else {
                $('#density').hide("slow");
                $('#farmSpecialities').hide("slow");
                $('#harvestProducts').hide("slow");
                $('#auxiliary').hide("slow");
                $('#farmFertilizers').hide("slow");
                $('#ph').hide("slow");
                $('#irrigations').hide("slow");
                $('#tankVolume').hide("slow");
                $('#drainage').hide("slow");

                $('#periods').show("slow");
                $('#expenses').show("slow");
                $('#nbWorkers').show("slow");
                $('#tractors').show("slow");

            }
        });
    });
</script>
