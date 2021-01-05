<pre>
    <?php print_r($log) ?>
</pre>

<script>
    $(document).ready(function() {
        setTimeout(
            function() {
                window.scrollTo(0, document.querySelector("pre").scrollHeight)

            },
            500
        )
    });
</script>