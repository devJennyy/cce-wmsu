function setupOptionInputs(questionNumber, option, inputElement) {
    const selectId = `answer-select-${questionNumber}`;
    const select = document.getElementById(selectId);

    // Find the option by ID and update its text
    $(select).find(`#option-${option}${questionNumber}`).val($(`#option-input-${option}${questionNumber}`).val());
}

function showError(errorMessage, type) {
    const toastLiveExample = document.getElementById('liveToast');
    toastLiveExample.classList.remove(type === "success" ? "text-bg-danger" : "text-bg-success" );
    toastLiveExample.classList.add(type === "success" ? "text-bg-success" : "text-bg-danger");
    const toastBootstrap = new bootstrap.Toast(toastLiveExample);

    const toastBody = toastLiveExample.querySelector(".toast-body");
    toastBody.textContent = errorMessage;

    toastBootstrap.show();
}

function submitFormWithAjax(formSelector, url, successCallback, reload = false, dismissModal = false) {
    $(formSelector).submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (!(response == "Done!")) {
                    console.log("Something went wrong!");
                } else {
                    if (typeof successCallback === "function") {
                        successCallback(response);
                    }

                    if(dismissModal){
                        $('.modal').modal('hide');
                    }

                    if(reload){
                        location.reload();
                    }
                }
            },
        });
    });
}

function checkInput(container) {
    errorTrigger = false;
    inputs = $(container).not(':disabled');

    inputs.each(function() {
        if ($(this).val() === "") {
            errorTrigger = true;
            $(this).addClass("error");
        } else {
            $(this).removeClass("error");
        }
    });

    return errorTrigger;
}

$(document).ready(function() {
    var currentUrl = window.location.href;
    var urlParams = new URLSearchParams(window.location.search);


    if (urlParams.has('date')) {
        // Remove the "date" parameter
        urlParams.delete('date');

        // Construct the modified URL without the "date" parameter
        var newUrl = window.location.pathname + urlParams.toString();

        // Reload the page with the modified URL
        window.location.href = newUrl;
    }


    let remainingSlots = 0;

    

    

    function updateRemainingSlots() {
        var totalSlots = parseInt($('#slots').val()) + 1;
        // Calculate the number of slots used by counting rows in the "invited-table"
        var invitedTableRows = $("#invited-table tr").length;
        usedSlots = invitedTableRows;

        // Calculate the remaining slots
        remainingSlots = totalSlots - usedSlots;

        // Update the "Remaining Slots" text
        $("#slotCount").text(remainingSlots);
    }

    function checkRemainingSlots() {
        if (remainingSlots <= 0) {
            return true;
        } else {
            return false;
        }
    }

    $("#search-org").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#invite-org-table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $('.organization-btn').on('click', function() {
        var $button = $(this);
        var $row = $button.closest('tr');
        if (checkRemainingSlots()) {
            showError("No more slots remaining!");
        } else {
            // Get the data-target value from the clicked button
            var targetText = $(this).data("target").toString();
            console.log(this);
            // Find rows in the source table with a hidden input matching the targetText
            var rowsToCopy = $("#invite-table tr").filter(function() {
                var inputID = $(this).find('.input-id');
                var hiddenInput = $(this).find(".org_hidden");
                
                if (hiddenInput.val() === targetText) {
                    inputID.attr('form', 'create-event-form')
                } else {
                    inputID.attr('form', 'no-form')
                }

                
                return hiddenInput.val() === targetText;
            });

            // Clone and append the selected rows to the destination table
            rowsToCopy.detach().appendTo("#invited-table");
            $row.find('.invited-btn').removeAttr("hidden");
            $row.find('.organization-btn').attr("hidden", "hidden");


            // Toggle the image src
            var $img = rowsToCopy.find('.button-icon');
            var originalSrc = $img.attr('src');
            var newSrc = '../../assets/img/admin/remove-user-button.svg'; // Change to the desired new image source
            $img.attr('src', originalSrc === newSrc ? '../../assets/img/admin/invite-user-button.svg' : newSrc);

            updateRemainingSlots();
        }
    });

    
    $('#randomize-code').on('click', function() {
        // Define characters for the code (letters and numbers)
        var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        // Initialize an empty string for the code
        var code = "";

        // Generate a random 7-character code
        for (var i = 0; i < 7; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            code += characters.charAt(randomIndex);
        }

        // Display the generated code
        $("#unique-code").val(code);
    });
    $('#randomize-event-code').on('click', function() {
        // Define characters for the code (letters and numbers)
        var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        // Initialize an empty string for the code
        var code = "";

        // Generate a random 7-character code
        for (var i = 0; i < 7; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            code += characters.charAt(randomIndex);
        }

        // Display the generated code
        $("#event-random-code").val(code);
    });

    $("#search-faculty").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#invite-faculty-table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $('.faculty-btn').on('click', function() {
        var $button = $(this); 
        var $row = $button.closest('tr');
        if (checkRemainingSlots()) {
            showError("No more slots remaining!");
        } else {
            // Get the data-target value from the clicked button
            var targetText = $(this).data("target").toString();
            

            // Find rows in the source table with a hidden input matching the targetText
            var rowsToCopy = $("#invite-table tr").filter(function() {
                var inputID = $(this).find('.input-id');
                var hiddenInput = $(this).find(".faculty_hidden");
                
                if (hiddenInput.val() === targetText) {
                    inputID.attr('form', 'create-event-form')
                } else {
                    inputID.attr('form', 'no-form')
                }

                
                return hiddenInput.val() === targetText;
            });



            // Clone and append the selected rows to the destination table
            rowsToCopy.detach().appendTo("#invited-table");
            $row.find('.invited-btn').removeAttr("hidden");
            $row.find('.faculty-btn').attr("hidden", "hidden");


            // Toggle the image src
            var $img = rowsToCopy.find('.button-icon');
            var originalSrc = $img.attr('src');
            var newSrc = '../../assets/img/admin/remove-user-button.svg'; // Change to the desired new image source
            $img.attr('src', originalSrc === newSrc ? '../../assets/img/admin/invite-user-button.svg' : newSrc);
            updateRemainingSlots();
        }
    });


    $('.participant-btn').on('click', function() {

        var $row = $(this).closest('tr');
        var $targetTable = $row.closest('table').attr('id') === 'invite-table' ? $('#invited-table') : $('#invite-table');

        if ($row.closest('table').attr('id') === 'invite-table') {
            if (checkRemainingSlots()) {
                showError("No more slots remaining!");
            } else {
                $row.detach().appendTo($targetTable.find('tbody'));

                var $input = $row.find('.input-id');
                if ($row.closest('table').attr('id') === 'invited-table') {
                    $input.attr('form', 'create-event-form')
                } else {
                    $input.attr('form', 'no-form')
                }


                // Toggle the image src
                var $img = $row.find('.button-icon');
                var originalSrc = $img.attr('src');
                var newSrc = '../../assets/img/admin/remove-user-button.svg'; // Change to the desired new image source
                $img.attr('src', originalSrc === newSrc ? '../../assets/img/admin/invite-user-button.svg' : newSrc);
                updateRemainingSlots();
            }
        } else {
            $row.detach().appendTo($targetTable.find('tbody'));

            var $input = $row.find('.input-id');
            if ($row.closest('table').attr('id') === 'invited-table') {
                $input.attr('form', 'create-event-form')
            } else {
                $input.attr('form', 'no-form')
            }


            // Toggle the image src
            var $img = $row.find('.button-icon');
            var originalSrc = $img.attr('src');
            var newSrc = '../../assets/img/admin/remove-user-button.svg'; // Change to the desired new image source
            $img.attr('src', originalSrc === newSrc ? '../../assets/img/admin/invite-user-button.svg' : newSrc);
            updateRemainingSlots();
        }

    });

    $("#search-invite").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#invite-table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $("#search-invited").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#invited-table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $('.speakers-btn').on('click', function() {

        var $row = $(this).closest('tr');
        var $targetTable = $row.closest('table').attr('id') === 'invite-speakers-table' ? $('#invited-speakers-table') : $('#invite-speakers-table');

        if ($row.closest('table').attr('id') === 'invite-speakers-table') {
            if (false) {
                showError("No more slots remaining!");
            } else {
                $row.detach().appendTo($targetTable.find('tbody'));

                var $input = $row.find('.input-id');
                if ($row.closest('table').attr('id') === 'invited-speakers-table') {
                    $input.attr('form', 'create-event-form')
                } else {
                    $input.attr('form', 'no-form')
                }


                // Toggle the image src
                var $img = $row.find('.button-icon');
                var originalSrc = $img.attr('src');
                var newSrc = '../../assets/img/admin/remove-user-button.svg'; // Change to the desired new image source
                $img.attr('src', originalSrc === newSrc ? '../../assets/img/admin/invite-user-button.svg' : newSrc);
            }
        } else {
            $row.detach().appendTo($targetTable.find('tbody'));

            var $input = $row.find('.input-id');
            if ($row.closest('table').attr('id') === 'invited-speakers-table') {
                $input.attr('form', 'create-event-form')
            } else {
                $input.attr('form', 'no-form')
            }


            // Toggle the image src
            var $img = $row.find('.button-icon');
            var originalSrc = $img.attr('src');
            var newSrc = '../../assets/img/admin/remove-user-button.svg'; // Change to the desired new image source
            $img.attr('src', originalSrc === newSrc ? '../../assets/img/admin/invite-user-button.svg' : newSrc);
        }

    });

    $('#next-toS2').click(function(event) {
        let errorTrigger = false;

        if (checkInput(".create-modal .step-1 input:not(.agenda input):not(.search-bar input)")) {
            if ($(".create-modal .description-textarea").val() == "") {
                $(".create-modal .description-textarea").addClass("error");
                errorTrigger = true;
            }
            errorTrigger = true;
        }


        if (errorTrigger) {
            showError("Make sure all input fields are not empty!");
        } else {
            $('.create-modal .step-1-footer')[0].style.setProperty("display", "none", "important");
            $('#step-1')[0].style.setProperty("display", "none", "important");

            $('.create-modal .step-2-footer')[0].style.setProperty("display", "block", "important");
            $('#step-2')[0].style.setProperty("display", "block", "important");
        }

    });

    $('#next-toS3').click(function(event) {
        let errorTrigger = false;
        let slotTrigger = false;

        if (parseInt($('#slots').val()) == parseInt($("#slotCount").text())) {
            slotTrigger = true;
        }

        if (slotTrigger) {
            showError("Invite atleast 1 participant!");
        } else if (errorTrigger) {
            showError("Make sure all input fields are not empty!")
        } else {
            $('.create-modal .step-2-footer')[0].style.setProperty("display", "none", "important");
            $('#step-2')[0].style.setProperty("display", "none", "important");

            $('.create-modal .step-3-footer')[0].style.setProperty("display", "block", "important");
            $('#step-3')[0].style.setProperty("display", "block", "important");
        }

    });

    $('#next-toS4').click(function(event) {
        let errorTrigger = false;

        if (checkInput(".create-modal .step-3 .event-title input")) {
            errorTrigger = true;
        }
        if (checkInput(".create-modal .step-3 .event-attachment input")) {
            errorTrigger = true;
        }

        if (errorTrigger) {
            showError("Make sure all input fields are not empty!");
        } else {
            $('.create-modal .step-3-footer')[0].style.setProperty("display", "none", "important");
            $('#step-3')[0].style.setProperty("display", "none", "important");

            $('.create-modal .step-4-footer')[0].style.setProperty("display", "block", "important");
            $('#step-4')[0].style.setProperty("display", "block", "important");
        }

    });

    $('#next-toS5').click(function(event) {
        let errorTrigger = false;

        if(checkInput(".create-modal .step-4 .visibility select")) {
            errorTrigger = true;
        }

        if ($('#event-options').is(':visible')) {
            if (checkInput(".create-modal .step-4 input")) {
              errorTrigger = true;
            }
          }

        if (errorTrigger) {
            showError("Make sure all input fields are not empty!")
        } else {
            $('.create-modal .step-4-footer')[0].style.setProperty("display", "none", "important");
            $('#step-4')[0].style.setProperty("display", "none", "important");

            $('.create-modal .step-5-footer')[0].style.setProperty("display", "block", "important");
            $('#step-5')[0].style.setProperty("display", "block", "important");
        }

    });

    $('#back-toS1').on('click', function() {
        $('.create-modal .step-1-footer')[0].style.setProperty("display", "block", "important");
        $('#step-1')[0].style.setProperty("display", "block", "important");

        $('.create-modal .step-2-footer')[0].style.setProperty("display", "none", "important");
        $('#step-2')[0].style.setProperty("display", "none", "important");
    });

    $('#back-toS2').on('click', function() {
        $('.create-modal .step-2-footer')[0].style.setProperty("display", "block", "important");
        $('#step-2')[0].style.setProperty("display", "block", "important");

        $('.create-modal .step-3-footer')[0].style.setProperty("display", "none", "important");
        $('#step-3')[0].style.setProperty("display", "none", "important");
    });

    $('#back-toS3').on('click', function() {
        $('.create-modal .step-3-footer')[0].style.setProperty("display", "block", "important");
        $('#step-3')[0].style.setProperty("display", "block", "important");

        $('.create-modal .step-4-footer')[0].style.setProperty("display", "none", "important");
        $('#step-4')[0].style.setProperty("display", "none", "important");
    });
    $('#back-toS4').on('click', function() {
        $('.create-modal .step-4-footer')[0].style.setProperty("display", "block", "important");
        $('#step-4')[0].style.setProperty("display", "block", "important");

        $('.create-modal .step-5-footer')[0].style.setProperty("display", "none", "important");
        $('#step-5')[0].style.setProperty("display", "none", "important");
    });


    // Day
    $('#day-picker').on("change", function() {
        $("#info-day").text(formatDate($(this).val()));
    });


    // Time
    $('#start-time').on("change", function() {
        $("#info-startTime").text(convertTo12HourFormat($(this).val()));
    });

    $('#end-time').on("change", function() {
        $("#info-endTime").text(convertTo12HourFormat($(this).val()));
    });

    $('#slots').on("input", function() {
        $("#info-slots").text($(this).val());
        $("#slotCount").text($(this).val());
        remainingSlots = parseInt($(this).val());
    });

    $('#event-visibility').on("change", function() {
        if ($('#event-visibility').val() == '1') {
            $('#event-options')[0].style.setProperty("display", "block", "important");
        } else {
            $('#event-options')[0].style.setProperty("display", "none", "important");
        }
    });

    $('#venue-select').on("change", function() {
        if ($('#venue-select').val() == 'Other Platform') {
            $('#set-location-select').attr("disabled", "disabled");
            $('#set-location-select').attr("hidden", true);

            $("#other-platform-select").removeAttr("hidden");
            $("#other-platform-select").removeAttr("disabled"); 
        } else {
            $("#other-platform-select").attr("disabled", "disabled");
            $("#other-platform-select").attr("hidden", true);

            $('#set-location-select').removeAttr("hidden");
            $('#set-location-select').removeAttr("disabled");
        }
    });

    $('.create-modal .more-info-div input').on('input', function() {
        let allInputsFilled = true;

        $('.more-info-div input').each(function() {
            if ($(this).val() === '') {
                allInputsFilled = false;
                return false;
            }
        });

        if (allInputsFilled) {
            $('.check').show();
            $('.wrong').hide();
        } else {
            $('.check').hide();
            $('.wrong').show();
        }
    });

    $('#create-event-form').submit(function(event) {
        $('#modal-createEvent').modal('hide');

        $('#modal-load').modal('show');

        event.preventDefault();
        var quillContent = quill.root.innerHTML;
        var formData = new FormData(this); // Serialize other form fields if any

        // Add the "agenda" field to the form data
        formData.append("agenda", quillContent);
        $.ajax({
            type: "POST",
            url: "../../modules/events/create_event.php",
            processData: false, // Prevent processing of the FormData
            contentType: false, 
            data: formData,
            success: function(response) {
                if (!(response == "Done!")) {
                    console.log("Something went wrong!");
                } else {
                    location.reload();
                }
            }
        })
    });
    
});

function removeQueryParam(url, param) {
    var urlParts = url.split('?');
    if (urlParts.length >= 2) {
        var prefix = encodeURIComponent(param) + '=';
        var params = urlParts[1].split(/[&;]/g);

        for (var i = params.length - 1; i >= 0; i--) {
            if (params[i].lastIndexOf(prefix, 0) !== -1) {
                params.splice(i, 1);
            }
        }

        if (params.length > 0) {
            return urlParts[0] + '?' + params.join('&');
        } else {
            return urlParts[0];
        }
    }

    return url;
}

function formatDate(inputDate) {
    var date = new Date(inputDate);
    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    return date.toLocaleDateString(undefined, options);
}

function getCurrentDate() {
    var now = new Date();
    var year = now.getFullYear();
    var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-based
    var day = now.getDate().toString().padStart(2, '0');
    return year + "-" + month + "-" + day;
}

function convertTo12HourFormat(time24) {
    var timeTokens = time24.split(":");
    var hours = parseInt(timeTokens[0]);
    var minutes = timeTokens[1];
    var ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12;
    return hours + ":" + minutes + " " + ampm;
}