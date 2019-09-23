<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{if !{$smarty.get.Action}}active{/if}"><a href="addonmodules.php?module=manage_license">{$lang.AddonHome}</a></li>
                <li class="{if {$smarty.get.Action == "help"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=help">{$lang.help}</a></li>

            </ul>
         </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>