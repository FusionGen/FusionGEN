<link rel="stylesheet" href="{base_url()}application/modules/sidebox_online_players_extended/assets/css/online-players.css" type="text/css" />

<section id="update_status">
    <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
        <img src="{$image_path}ajax.gif" />
    </div>
</section>

<script type="text/javascript">
    var Status = {
        statusField: $("#update_status"),

        /**
         * Refresh the realm status
         */
        update: function()
        {
            $.get(Config.URL + "sidebox_online_players_extended/status", function(data) {
                Status.statusField.html(data);
            });
        }
    }

    Status.update();

        {if $auto_refresh}
            setInterval(Status.update, {$auto_refresh_interval} * 1000);
        {/if}
</script>
