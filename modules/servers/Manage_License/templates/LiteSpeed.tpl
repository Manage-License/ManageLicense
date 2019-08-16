
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
                    <td class="sorting_1"><strong>{$lang.key}</strong></td>
                    <td class="text-center">{$licenseInfo.license_serial}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.status}</strong></td>
                    <td class="text-center">
                        {if $licenseInfo.status eq "Active" }
                            <span class="label status-active">{$licenseInfo.status}</span>
                        {else}
                            <span class="label status-inprogress">{$licenseInfo.status}</span>
                        {/if}


                    </td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.validip}</strong></td>
                    <td class="text-center">{if $licenseInfo.server_ip|@count == 0}
                            {$lang.unset}
                        {else}
                            {$licenseInfo.server_ip}
                        {/if}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.module}</strong></td>
                    <td class="text-center">{$licenseInfo.modules}</td>
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