function validate_widget_settings() {
    document.addEventListener("DOMContentLoaded", function () {

        const form = document.querySelector("form"); // Adjust if your form has a specific ID
        if (!form) return;

        // Custom Icon
        const customIconInput = document.getElementById("edit-widget-icon-size-custom");
        const isCustomIconRadio = document.querySelector('input[name="is_widget_custom_size"]');

        // Widget Position Inputs
        const posLeftInput = document.getElementById("edit-widget-position-left");
        const posRightInput = document.getElementById("edit-widget-position-right");
        const posTopSelect = document.getElementById("edit-widget-position-top");
        const posBottomSelect = document.getElementById("edit-widget-position-bottom");

        // Radio that controls Custom Position (replace with your actual name/id)
        const isCustomPosRadio = document.querySelector('input[name="is_widget_custom_position"]');

        form.addEventListener("submit", function (e) {

            // -------- Custom Icon Size Validation --------
            const isCustomIcon = isCustomIconRadio && document.querySelector('input[name="is_widget_custom_size"]:checked').value;

            if (isCustomIcon === "1") {
                if (!customIconInput.value.trim()) {
                    alert("Custom Icon Size is required.");
                    customIconInput.focus();
                    e.preventDefault();
                    return false;
                }
                const size = parseInt(customIconInput.value, 10);
                if (isNaN(size) || size < 20 || size > 150) {
                    alert("Custom Icon Size must be between 20 and 150 px.");
                    customIconInput.focus();
                    e.preventDefault();
                    return false;
                }
            }

            // -------- Widget Position Validation (only if Custom Position selected) --------
            const isCustomPos = isCustomPosRadio && document.querySelector('input[name="is_widget_custom_position"]:checked').value;

            if (isCustomPos === "1") {

                if (!posLeftInput.value.trim() || isNaN(parseInt(posLeftInput.value, 10))) {
                    alert("Please enter a valid Horizontal (px) value for Left.");
                    posLeftInput.focus();
                    e.preventDefault();
                    return false;
                }

                if (!posRightInput.value.trim() || isNaN(parseInt(posRightInput.value, 10))) {
                    alert("Please enter a valid Vertical (px) value for Right.");
                    posRightInput.focus();
                    e.preventDefault();
                    return false;
                }

                if (!posTopSelect.value) {
                    alert("Please select a value for Top position.");
                    posTopSelect.focus();
                    e.preventDefault();
                    return false;
                }

                if (!posBottomSelect.value) {
                    alert("Please select a value for Bottom position.");
                    posBottomSelect.focus();
                    e.preventDefault();
                    return false;
                }

            }

        });

    });
}

// Call the function
validate_widget_settings();

