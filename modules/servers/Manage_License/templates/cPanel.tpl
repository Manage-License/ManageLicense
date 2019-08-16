


{if $statusip AND $statusip == 'changed'}



    <div menuitemname="Register a New Domain" class="panel panel-default panel-accent-emerald">
        <div class="panel-body">
            <div class="alert alert-success">{$lang.CP_ipchanged|sprintf2:$licenseInfo.ipChangeCounter}</div>
            <a href="clientarea.php?action=productdetails&amp;id={$id}" class="btn btn-info btn-block ">{$lang.back}</a>
        </div>
    </div>
{else}



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
                    <td class="sorting_1"><strong>{$lang.ip}</strong></td>
                    <td class="text-center">{$licenseInfo.ip}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.status}</strong></td>


                        <td class="text-center"> {$licenseInfo['status']}</td>



                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.hostname}</strong></td>
                    <td class="text-center">{$licenseInfo.hostname}</td>
                </tr>
                <tr role="row" class="even">
                    <td class="sorting_1"><strong>{$lang.os}</strong></td>
                    <td class="text-center">{$licenseInfo.os}</td>
                </tr>
                <tr role="row" class="odd">
                    <td class="sorting_1"><strong>{$lang.validStatus}</strong></td>
                    {if ($licenseInfo.valid eq 1)}
                        <td class="text-center">{$lang.valid}</td>
                    {else}
                        <td class="text-center">{$licenseInfo.valid}</td>
                    {/if}
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
                <td class="sorting_1"><strong> number of change</strong></td>
                <td class="text-center"> {$licenseInfo.numberOfChange}</td>
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
{if ($licenseInfo.numberOfChange < 4)}
    <div class="panel-body">
        <form method="post" action="clientarea.php?action=productdetails&amp;id={$id}">
            <div class="input-group margin-10">
                <input type="text" name="changeip" class="form-control" required="required">
                <input type="hidden" name="changeData" value="changeip" class="form-control">
                <div class="input-group-btn">
                    <input type="submit" value="{$lang.cln_btn_change}" class="btn btn-success ">
                </div>
            </div>
        </form>
    </div>
    {else}
    <div class="panel-body">
            <div class="input-group margin-10">
                <div class="">
                    <div class="alert alert-danger">{$lang.cln_iplimit} </div>

                </div>
            </div>
    </div>
    {/if}

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



{/if}
