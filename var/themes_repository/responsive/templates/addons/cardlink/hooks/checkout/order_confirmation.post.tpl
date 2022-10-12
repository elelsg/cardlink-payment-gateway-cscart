<script>
    //break out of iframe if iframe mode was used
    (function () {
        'use strict';
        if (window.location !== window.top.location) {
            window.top.location = window.location;
        }

    })();
</script>