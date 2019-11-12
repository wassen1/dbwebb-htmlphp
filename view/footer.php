        <footer class="footer">
        <?php 
            $numFiles   = count(get_included_files());
            $memoryUsed = memory_get_peak_usage(true);
            $loadTime   = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        ?>
            <hr>
            
            <p>
                Validatorer: 
                <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
                <a href="http://validator.w3.org/check/referer">HTML5</a>
                <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a>    
            <br>
                Specifikationer:
                <a href="https://www.w3.org/2009/cheatsheet/">Cheatsheet</a>
                <a href="https://html.spec.whatwg.org/multipage/">HTML</a>
                <a href="https://www.w3.org/TR/CSS/">CSS</a>
            <br>
                Time to load page: <?= number_format(round(($loadTime / 1000), 6), 6, ".", " ") ?> ms. Files included: <?= $numFiles ?>. Memory used: <?= number_format(($memoryUsed / 1000000), 2, ".", "'") ?> MB.
            <br>
                <a href="http://jigsaw.w3.org/css-validator/check/referer">
                <img style="border:0;width:4em;height:2em;"
                    src="http://jigsaw.w3.org/css-validator/images/vcss"
                    alt="Valid CSS!" />
                </a>
            </p>
        </footer>
    </body>
</html>