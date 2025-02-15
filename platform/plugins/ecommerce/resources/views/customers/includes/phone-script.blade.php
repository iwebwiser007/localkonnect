<script>
    document.addEventListener("DOMContentLoaded", function () {
        const phoneInput = document.querySelector("input[name='phone']");
        
        phoneInput.addEventListener("blur", function () {
            let value = phoneInput.value.trim();

            // Ensure it starts with +91
            if (!value.startsWith("+91")) {
                phoneInput.value = "+91" + value.replace(/^\+91|[^0-9]/g, "");
            }
        });
    });
</script>
