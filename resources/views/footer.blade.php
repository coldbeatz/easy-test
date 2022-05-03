<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        M.Sidenav.init(document.querySelectorAll('.sidenav'));
        M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
        M.Tabs.init(document.querySelectorAll('.tabs'));
        M.Modal.init(document.querySelectorAll('.modal'));
    });

    function fade(element, handler = null) {
        let op = 1;
        let timer = setInterval(function () {
            if (op <= 0.1) {
                clearInterval(timer);
                element.style.display = 'none';

                if (handler != null) {
                    handler();
                }
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op -= op * 0.1;
        }, 20);
    }

    function unFade(element, handler = null) {
        let op = 0.1;
        element.style.display = '';
        let timer = setInterval(function () {
            if (op >= 1) {
                clearInterval(timer)

                if (handler != null) {
                    handler();
                }
            }
            element.style.opacity = op;
            element.style.filter = 'alpha(opacity=' + op * 100 + ")";
            op += op * 0.1;
        }, 10);
    }
</script>

@stack('scripts')

</body>
</html>
