{if $statusip eq 'changed'}
    <div class="alert alert-success">{$lang.cln_ipchanged|sprintf2:$licenseInfo.ipChangeCounter}</div>

{/if}
{if $wrongip}
    <div class="alert alert-danger">{$lang.ipwarning}</div>
{/if}

{if $changeip eq 2}
    <div class="alert alert-success">{$lang.cln_ipchanged}</div>
{elseif $changeip eq 3}
    <div class="alert alert-danger">{$lang.cln_iplimit}</div>
{/if}

<div id="tableServicesList_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
    <div class="listtable">

        <div class="dataTables_info" id="tableServicesList_info" role="status" aria-live="polite">
            <h6>{$LANG.clientareaproductdetails}</h6>
        </div>

        <table id="tableServicesList" class="table table-list dataTable no-footer dtr-inline"
               aria-describedby="tableServicesList_info" role="grid">

            <tbody>

            <tr role="row" class="odd">
                <td class="sorting_1"><strong>{$LANG.clientareahostingregdate}</strong></td>
                <td class="text-center">{$regdate|shdate}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1"><strong>{$LANG.orderproduct}</strong></td>
                <td class="text-center">{$groupname} - {$product}</td>
            </tr>
            {if $licenseInfo}
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.cln_os}</strong></td>
                    <td class="text-center">{$licenseInfo.server_info}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.validip}</strong></td>
                    <td class="text-center">{$licenseInfo.ip}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.cln_lastCheck}</strong></td>
                    <td class="text-center">{$licenseInfo.last_checkin|shdate}</td>
                </tr>
            {/if}

            <tr role="row" class="odd">
                <td class="sorting_1"><strong>{$LANG.orderpaymentmethod}</strong></td>
                <td class="text-center">{$paymentmethod}</td>
            </tr>

            <tr role="row" class="odd">
                <td class="sorting_1"><strong> {$LANG.firstpaymentamount}</strong></td>
                <td class="text-center"> {$firstpaymentamount}</td>
            </tr>

            <tr role="row" class="odd">
                <td class="sorting_1"><strong> {$LANG.recurringamount}</strong></td>
                <td class="text-center"> {$recurringamount}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1"><strong> {$LANG.clientareahostingnextduedate}</strong></td>
                <td class="text-center"> {$nextduedate|shdate}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1"><strong> {$LANG.orderbillingcycle}</strong></td>
                <td class="text-center"> {$billingcycle}</td>
            </tr>
            <tr role="row" class="odd">
                <td class="sorting_1"><strong> {$LANG.clientareastatus}</strong></td>
                <td class="text-center"> {$status}</td>
            </tr>
            {if $suspendreason}
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong> {$LANG.suspendreason}</strong></td>
                    <td class="text-center"> {$suspendreason}</td>
                </tr>
            {/if}
            </tbody>
        </table>
    </div>

</div>
<br/>

<div menuitemname="Register a New Domain" class="panel panel-default panel-accent-emerald">
    <div class="panel-heading">
        <h5 class="panel-title">
            {$lang.cln_changeip}
        </h5>
    </div>

    <div class="panel-body">
        <form method="post" action="clientarea.php?action=productdetails&amp;id={$id}">
                        <div class="input-group margin-10">
                <input type="text" name="changeip" value="{$licenseInfo.ip}" class="form-control">
                <input type="hidden" name="changeData"  value="changeData">
                <div class="input-group-btn">
                    <input type="submit" value="{$lang.cln_btn_change}" class="btn btn-success">
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer">
    </div>
</div>

<div class="row">

    {if $packagesupgrade}
        <div class="col-sm-4">
            <a href="upgrade.php?type=package&amp;id={$id}" class="btn btn-success btn-block">
                {$LANG.upgrade}
            </a>
        </div>
    {/if}

    <div class="col-sm-4">
        <a href="clientarea.php?action=cancel&amp;id={$id}"
           class="btn btn-danger btn-block{if $pendingcancellation}disabled{/if}">
            {if $pendingcancellation}
                {$LANG.cancellationrequested}
            {else}
                {$LANG.cancel}
            {/if}
        </a>
    </div>
</div>

