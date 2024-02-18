$(document).ready(function () {
    // Certificate
    let customFontUrl = "";

    // Show certificate attribute fields upon image template upload.
    $("#certificate-img").on("change", function () {
        const fileInput = this;
        const image = $("#image");

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                image.attr("src", e.target.result);
                $("#modify-div")[0].style.setProperty(
                    "display",
                    "block",
                    "important"
                );
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
        updateTextField();
    });

    // Update the Font of the Text based on uploaded font-style.
    $("#customFont").on("change", function () {
        const fileInput = this;

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                // Set the custom font URL
                customFontUrl = e.target.result;

                // Update the font-face rule with the custom font URL
                $("style").append(`
                    @font-face {
                        font-family: 'CustomFont';
                        src: url('${customFontUrl}') format('truetype');
                    }
                `);
                updateTextField();
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    });

    // Update textfield position on input.
    $(".image-options input").on("input", function () {
        updateTextField();
    });
    
    $(".image-options input").on("keyup", function () {
        updateVal();
    });

    // Function to update the text field
    function updateTextField() {
        const x = parseFloat($("#x").val()); // Get percentage value
        const y = parseFloat($("#y").val()); // Get percentage value
        const width = parseFloat($("#width").val());
        const height = parseFloat($("#height").val());
        const fontSize = $("#fontSize").val() + "px";
        const fontStyle = $("#fontStyle").val();
        const fontWeight = $("#fontWeight").val();

        // Get the image dimensions
        const image = $("#image");
        const imageWidth = image.width();
        const imageHeight = image.height();

        const prevSize = image.width();
        const actualWidth = $("#image")[0].naturalWidth;
        const actualHeight = $("#image")[0].naturalHeight;
        const P = (prevSize / actualWidth) * 100;
        

        // Calculate absolute coordinates inside the image
        const absoluteX = (x / 100) * imageWidth;
        const absoluteY = (y / 100) * imageHeight;

        const textField = $("#textField");
        textField.css("left", (absoluteX -2) + "px");
        textField.css("top", (absoluteY - 2) + "px");
        textField.css("width", width + "px");
        textField.css("height", height + "px");

        // Apply text styling
        textField.css("font-size", fontSize);
        textField.css("font-style", fontStyle);
        textField.css("font-weight", fontWeight);

        // Add custom font class if a custom font is selected
        if (customFontUrl) {
            textField.addClass("custom-font");
        }

        const decimalP = parseFloat(P / 100);
        const fontSizeVal = parseFloat($("#fontSize").val());
        console.log("P: ", P);
        console.log("decimalP: ", decimalP);
        /* const true_fs = fontSizeVal + fontSizeVal * (decimalP + 1) - fontSizeVal * decimalP; */
        const true_fs = (fontSizeVal / imageWidth) * actualWidth;
        const true_x = (absoluteX / P) * 100;
        const true_y = (absoluteY / P) * 100;
        const true_width = (width / imageWidth) * actualWidth;
        const true_height = (height / imageHeight) * actualHeight;
        
        /* const true_width = width + width * (((100 - P) * 100) + 1);
        const true_height = height + height * (((100 - P) * 100) + 1); */

        console.log("Font Style: ", true_fs);
        console.log("X: ", true_x);
        console.log("Y: ", true_y);
        console.log("Width: ", true_width);
        console.log("Height: ", true_height);

        $('#true-x').attr("value", true_x);
        $('#true-y').attr("value", true_y);
        $('#true-width').attr("value", true_width);
        $('#true-height').attr("value", true_height);
        $('#true-fsize').attr("value", true_fs);
    }
});
