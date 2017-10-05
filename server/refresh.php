<?php
/* Kazdych N sekund prepise vsechny statusy novym nahodnym cislem */

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    require("config.php");
    $db = new mysqli($conf["db_server"],$conf["db_user"], $conf["db_password"], $conf["db_name"] );

    header('content-type: text/plain; charset=utf-8');
    @ini_set('zlib.output_compression', 0);
    @ini_set('implicit_flush', 1);
    @ob_end_clean();
    set_time_limit(0);

    $db->query("update temp set status = floor(rand() * 8) where id < 50");

    $db->query("update temp set status = 7 where id > 50 and temp > 49");
    $db->query("update temp set status = 0 where id > 50 and temp <= 49");
    die(date('r'));

} else { ?>
    <html>
    <pre id="log"></pre>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        var log = $("#log");

        function worker() {
            $.ajax({
                type: "get",
                cache: false,
                url: "refresh.php",
                dataType: "text",
                error: function(xhr, status, error) {
                    log.append(document.createTextNode("error\n"));
                    setTimeout(worker, 10000);
                },
                success: function (result) {
                    log.append(document.createTextNode(result + "\n"));
                    setTimeout(worker, 10000);
                }
            });
        }

        worker();
    </script>
    </html>
<?php }
