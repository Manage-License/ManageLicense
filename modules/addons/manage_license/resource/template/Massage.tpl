<div class="alert alert-{$class} text-center">

    {if $update.0 eq true }
        {$Massage|sprintf: $update.1: $update.2}
        <a href="addonmodules.php?module=manage_license&update=1"><strong>{$here}</strong></a>


    {else}
        {$Massage}
        <a class="btn btn-info" href="addonmodules.php?module=manage_license">{$back}</a>
    {/if}
</div>';