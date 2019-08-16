
<div class="alert alert-danger">
{*    {$er}*}
    {if $errorTrue == true}

        <tr >
            <td class="text-center">{$er}</td>
        </tr>
        {else}
        {if $suspendreason}
                <tr role="row" class="odd">
                        <td class="sorting_1"><strong> {$LANG.suspendreason}</strong></td>
                        <td class="text-center"> {$suspendreason}</td>
                </tr>
        {*{elseif $status eq "Active"}*}
        {*<h2>Oops! Something went wrong.</h2>*}
        {*<hr>*}
        {*<p>{$wrongMessage}</p>*}
        {else}
{*            <tr >*}
{*                <td class="sorting_1"><strong> {$status}</strong></td>*}
{*            </tr>*}
            <tr >
                <td class="text-center">{$lang.reason} {$status}</td>
            </tr>
        {/if}
    {/if}

</div>
<a href="clientarea.php?action=productdetails&amp;id={$id}" class="btn btn-info btn-block ">{$LANG.problemgoback}</a>



