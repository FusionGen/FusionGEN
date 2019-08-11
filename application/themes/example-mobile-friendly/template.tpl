{$head}

<body>

<!-- The website -->
<div id="container">

    <div class="row d-flex justify-content-center mt-5">
        <div class="col-lg-8">
            <!-- Header -->
            <header>
                <!-- (Optional) Text based header -->
                <div class="headline">{$serverName}</div>
            </header>
        </div>

        <div class="col-lg-8 text-center">
            <!-- Navigation menu -->

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <button class="navbar-toggler fusion-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        {foreach from=$menu_top item=menu_1}
                            <a class="nav-item nav-link" {$menu_1.link}>{$menu_1.name}</a>
                        {/foreach}
                    </div>
                </div>
            </nav>

        </div>
        <div class="col-lg-8">
            <!-- Left side (main) -->
            <div id="wrapper" class="row" style="margin:0;">

                <!-- Main content boxes -->
                <div id=main-content" class="col-lg-9" style="padding: 0 10px;">
                    {$page}
                </div>

                <!-- Right side (sideboxes)-->
                <div id="sidebox-content" class="col">

                    <!-- Side menu -->
                    <article>
                        <div class="headline">Menu</div>
                        <div class="content" id="menu">
                            <ul>
                                {foreach from=$menu_side item=menu_2}
                                    <li><a {$menu_2.link}>{$menu_2.name}</a></li>
                                {/foreach}
                            </ul>
                        </div>
                    </article>

                    <!-- Sidebox -->
                    {foreach from=$sideboxes item=sidebox}
                        <article>
                            <div class="headline">{$sidebox.name}</div>
                            <div class="content">
                                {$sidebox.data}
                            </div>
                        </article>
                    {/foreach}
                </div>

            </div>
        </div>
        <div class="col-lg-12">
            <footer>
                <div class="headline">&copy; Copyright {date("Y")} {$serverName}</div>
                Theme by <a href="http://website.com" target="_blank">Theme author</a>
                | Powered by <a href="http://www.fusion-hub.com" target="_blank">FusionCMS</a>
            </footer>
        </div>
    </div>

</body>
</html>