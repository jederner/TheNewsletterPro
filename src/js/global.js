$(function () {
    //JQueryUI Element Initialize
    //buttons
    $("input[type=submit], a:not(.notBtn), button")
            .button()
            .click(function (event) {
                //event.preventDefault();
            });
    //tabs
    $(".tabs").tabs();
    //selectmenu
    //$( "select" ).selectmenu();
    //tool tip
    $(document).tooltip();
    //data tables

    $(".dataTable").DataTable({
        "iDisplayLength": 50,
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var title = $(column.header()).text();
                var arrIgnore = ["Company", "Contact"];
                if (arrIgnore.indexOf(title) == -1) {
                    var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                        );

                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });
                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                }
            });
        }
    });

    if ($("#grand_total")) {
        var $tally = $("#grand_total #tally").html();
        var $tallyTarget = $(".totalBox .value.grandTotal");
        $tallyTarget.text($tally);
    }

    //date picket
    $(".dateMe").datepicker({
        changeMonth: true,
        changeYear: true
    });

    // Disable submit buttons on click
    $('input:submit').click(function () {
        $(this).hide();
    });

    $(".accordion").accordion({
        active: false,
        heightStyle: "content",
        collapsible: true
    });

    //Articles page
    $("#articles .clickable").bind('click', function () {
        document.location.href = "/index.php/Articles/details/" + $(this).attr("data-id");
    });

    $("#assignArticles tr td a.assign").bind('click', function (e) {
        e.preventDefault();
        var myId = $(this).attr("data-article");
        var month = $("#" + myId + "_article_edition_month option:selected").val();
        var year = $("#" + myId + "_article_edition_year option:selected").val();
        var curLink = $(this).attr("href");
        var newURL = curLink + "/" + year + "-" + month;
        document.location = newURL;
    });

    // Assign Articles
    var oTable = $('#assignArticles').dataTable({"iDisplayLength": 50});

    $(".newFilter").bind('click', function () {
        //build a regex filter string with an or(|) condition
        var categories = $('input:checkbox[name="category"]:checked').map(function () {
            return '^' + this.value + '\$';
        }).get().join('|');
        //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
        oTable.fnFilter(categories, 1, true, false, false, false);

        //build a filter string with an or(|) condition
        var demographics = $('input:checkbox[name="demographic"]:checked').map(function () {
            return this.value;
        }).get().join('|');

        //now filter in column 2, with no regex, no smart filtering, no inputbox,not case sensitive
        oTable.fnFilter(demographics, 2, false, false, false, false);
    });


    /*
     Subcategory is no longer in use.
     Keep this though as an example of ajax / json
     var $category = $('#article_category'),
     $subcategory = $('#article_subcategory');
     $category.bind('change',function() {
     $subcategory.empty();
     var parentID = $category.val();
     $.ajax({
     type: "POST",
     url: "/index.php/Articles/getSubcategories/" + parentID,
     //data: { 'carId': carId  },
     success: function(data){
     var opts = $.parseJSON(data);
     $subcategory.append('<option value="">(unassigned)</option>');
     $.each(opts, function(i, d) {
     $subcategory.append('<option value="' + d.UID + '">' + d.Label + '</option>');
     });
     }
     });
     });
     */

    //Clients page
    /*$("#clients .clickable").bind('click',function() {
     document.location.href="/index.php/clients/details/" + $(this).attr("data-id");
     });*/

    //Clients - on hold, show return date
    $statusField = $(".frmClient select[name='status']");
    if ($statusField) {
        $returnRow = $(".frmClient #returnDateRow");
        $returnField = $(".frmClient #return_date");
        if ($statusField.val() !== "on hold") {
            $returnField.attr({"disabled": "disabled"});
            $returnRow.addClass("ghost");
        }
        $statusField.change(function () {
            if ($statusField.val() === "on hold") {
                $returnRow.removeClass("ghost");
                $returnField.removeAttr("disabled").focus();
            } else {
                $returnRow.addClass("ghost");
                $returnField.attr({"disabled": "disabled"});
            }
        });
    }

    $mailScheduleText = $(".frmClient #mailing_schedule_text");
    $mailScheduleSelect = $(".frmClient #mailing_schedule_select");
    if ($mailScheduleText) {
        $mailScheduleText.bind('change keypress keydown', function () {
            $mailScheduleSelect.val("");
        });
        $mailScheduleSelect.bind('change', function () {
            if ($mailScheduleSelect.val() === "unique") {
                $("#flipToSelect").show();
                $mailScheduleText.removeAttr('disabled').css({"display": "block"}).focus();
                $mailScheduleSelect.attr({"disabled": "disabled"}).css({"display": "none"});
            }
        });
        $("#flipToSelect").click(function (e) {
            e.preventDefault();
            $mailScheduleText.attr({"disabled": "disabled"}).css({"display": "none"});
            $mailScheduleSelect.removeAttr("disabled").css({"display": "block"}).val("").focus();
            $(this).hide();
        });
    }

    //Clients add
    $("#company").blur(function () {
        me = $(this);
        if (me.val() !== "") {
            $.ajax({
                url: "/index.php/clients/checkifexists/" + me.val()
            }).done(function (data) {
                if (data) {
                    $('#company_already_added').dialog({
                        modal: true,
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                                $("#company").focus();
                            }
                        }
                    });
                }
            });
        }
    });

    //Clients details
    $('.clientsUnassign').bind('click', function (e) {
        e.preventDefault();
        var clientHref = $(this).attr("href");
        $("#dialog-confirm").dialog({
            resizable: false,
            height: 250,
            width: 375,
            modal: true,
            buttons: {
                "Unassign": function () {
                    document.location.href = clientHref;
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    });

    $("#openSecondaryContactModal").bind('click', function (e) {
        e.preventDefault();

        $("#addSecondaryForm").dialog({
            height: 450,
            width: 400,
            modal: true,
            buttons: {
                "Add Contact Information": addSecondaryContactAJAX,
                Cancel: function () {
                    $(this).dialog("close");
                }
            }/*,
             close: function() {
             form[ 0 ].reset();
             allFields.removeClass( "ui-state-error" );
             }*/
        });
    });

    function addSecondaryContactAJAX() {
        var varFirst = $("#addSecondaryForm #first_name").val(),
                varLast = $("#addSecondaryForm #last_name").val(),
                varPhone = $("#addSecondaryForm #phone").val(),
                varEmail = $("#addSecondaryForm #email").val(),
                varUser = $("#addSecondaryForm #user_id").val(),
                varArray = [
                    [varFirst, "First name"],
                    [varLast, "Last name"],
                    [varPhone, "Phone number"],
                    [varEmail, "Email address"]
                ],
                fieldFilled = false;
        for (var i = 0; i < varArray.length; i++) {
            var addSecondValue = $.trim(varArray[i][0]);
            //var addSecondLabel = varArray[i][1];

            if (addSecondValue.length > 0) {
                fieldFilled = true;
                break;
            }
        }

        if (fieldFilled) {
            varEmail = varEmail.replace("@", "-110-");
            var secondURL = "/index.php/Clients/addSecondaryContact/";
            if(varFirst==="") { varFirst = "null" };
            if(varLast==="") { varLast = "null" };
            if(varEmail==="") { varEmail = "null" };
            if(varPhone==="") { varPhone = "null" };
            secondURL += varFirst + "/";
            secondURL += varLast + "/";
            secondURL += varEmail + "/";
            secondURL += varPhone + "/";
            secondURL += varUser;

            $.ajax({
                type: "POST",
                url: secondURL,
                //data: { 'carId': carId  },
                success: function (data) {
                    document.location = "/index.php/Clients/details/" + varUser;
                    return false;
                }
            });
        } else {
            alert("At least one field must be filled.");
            return false
        }

    }

    // href confirmations
    $(".hrefConfirm").bind("click", function (e) {
        e.preventDefault();
        var destinationHref = $(this).attr("href");
        $("#hrefConfirm").dialog({
            resizable: false,
            height: 250,
            width: 375,
            modal: true,
            buttons: {
                "Proceed": function () {
                    document.location.href = destinationHref;
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    });
    
    // Custom reports
    $("#frmCustomReport").submit(function(event) {
        event.preventDefault();
        
        // If any checkbox is selected
        if ($("#frmCustomReport input:checkbox:checked").length > 0) {
            var $tableTarget = $("#results");
            $tableTarget.html('');

            // Get from elements values
            var values = $(this).serialize();

            var ajaxRequest= $.post( "/index.php/Customreport/process",values, function(data) {
                //drawTable("results",data);
                var myArray = JSON.parse(data);
                for(var i=0;i<myArray.length;i++) {
                    myObj = myArray[i];
                    var row = $("<tr />")
                    $tableTarget.append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
                    for (var property in myObj) {
                        if (myObj.hasOwnProperty(property)) {
                            //console.log(myObj[property]);
                            var myProp = myObj[property];
                            if(myProp===null) {
                                myProp = "";
                            }
                            row.append($("<td>" + myProp + "</td>"));
                        }
                    } 
                }
                
                var $thead = $("<thead />");
                $tableTarget.append($thead);
                
                $("input:checked").each(function() {
                   var headerTitle = $(this).closest("div").text();
                   $thead.append("<th>" + headerTitle + "</th>");
                });
                
                $("html, body").animate({ scrollTop: $tableTarget.offset().top }, 1000);
                //drawTable("results",newData);
            })
            .fail(function(data, textStatus, jqXHR) {
                console.log("AJAX Failure:");
                console.log(values);
                console.log(data);
                console.log(textStatus);
                console.log(jqXHR);
            })
            .always(function() {
                console.log("AJAX completed.");
            });
        }
        // If no checkbox is selected
        else {
           alert("Please select at least one field to view.");
        }
        $("input:submit").show();
    });
});