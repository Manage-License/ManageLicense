     {if $statusip == 'DonotChanged'}
        <div class="alert alert-success">{$lang.successMessage}</div>
    {/if}
 {if $statusip == 'changed'}
    <div menuitemname="Register a New Domain" class="panel panel-default panel-accent-emerald">
        <div class="panel-body">
            <div class="alert alert-success">{$lang.cln_ipchanged}</div>
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
                {if $licenseInfo.verified eq 'No Download'}
                    <tr role="row" class="odd">
                        <td class="sorting_1" scope="2"><strong>{$lang.notdownload}</strong>


                            <div class="panel-body">
                                <form method="post" action="clientarea.php?action=productdetails&amp;id={$id}">
                                    <div class="input-group margin-10">
                                        <input type="text" name="changeip" class="form-control">
                                        <input type="hidden" name="changeData" value="changeip" class="form-control">
                                        <div class="input-group-btn">
                                            <input type="submit" value="{$lang.check}" class="btn btn-success ">
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </td>

                    </tr>
                {else}
                    <tr role="row" class="odd">
                        <td class="sorting_1"><strong>{$LANG.clientareahostingregdate}</strong></td>
                        <td class="text-center">{$regdate}</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="sorting_1"><strong>{$LANG.orderproduct}</strong></td>
                        <td class="text-center">{$groupname} - {$product}</td>
                    </tr>
                    {if $licenseInfo}
                        <tr role="row" class="odd">
                            <td class="sorting_1"><strong>{$lang.namelicense}</strong></td>
                            <td class="text-center">{$licenseInfo.nameinlicense}</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1"><strong>{$lang.ip}</strong></td>
                            <td class="text-center">{$licenseInfo.ip}</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1"><strong>{$lang.cid}</strong></td>
                            <td class="text-center">{$licenseInfo.cid}</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1"><strong>{$lang.lid}</strong></td>
                            <td class="text-center">{$licenseInfo.lid}</td>
                        </tr>
                        <tr role="row" class="even">
                            <td class="sorting_1"><strong>{$lang.os}</strong></td>
                            <td class="text-center">{$licenseInfo.listOS[$licenseInfo.os]}</td>
                        </tr>
                        <tr role="row" class="odd">
                            <td class="sorting_1"><strong>{$lang.validStatus}</strong></td>
                            {if ($licenseInfo.active eq 'Y')}
                                <td class="text-center">{$lang.active}</td>
                            {else}
                                <td class="text-center">{$licenseInfo.active}</td>
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
                        <td class="text-center"> {$nextduedate}</td>
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
                {/if}
                </tbody>
            </table>
        </div>

    </div>
    <br/>
    <div menuitemname="Register a New Domain" class="panel panel-default panel-accent-emerald">
        <div class="panel-heading">
            <h5 class="panel-title">
                {$lang.changeData}
            </h5>
        </div>
        {if ($licenseInfo.numberOfChange < 1 and  $licenseInfo.verified != 'No Download') OR {$password} == 4}
            <div class="panel-body">

                <form method="post" action="clientarea.php?action=productdetails&amp;id={$id}">
                    <div class="input-group margin-10">
                        <input type="hidden" name="changeData" value="changeip" class="form-control">
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">Change OS</label>
                                    <select type="text" name="ChangeOs" class="form-control">
                                        {foreach $licenseInfo.listOS as $key => $value}
                                            {if $licenseInfo.os == $key }
                                                <option value="{$key} " selected>{$value}</option>
                                            {else}
                                                <option value="{$key} ">{$value}</option>
                                            {/if}
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="control-label">{$lang.changeName}</label>
                                    <input type="text" name="ChangeName" class="form-control"
                                           placeholder="{$licenseInfo.nameinlicense}">

                                </div>
                            </div>
                            <div class='col-md-4 col-lg-4'>
                                <div class="form-group">
                                    <label class="control-label"> </label>
                                    <input type="submit" value="{$lang.cln_btn_change}"
                                           class="btn btn-success form-control" style="margin-top: 25px;">
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                        <fieldset style="    padding: .35em .625em .75em;margin: 0 2px;border: 1px solid silver;">
                            <legend style="width: auto;border-bottom: 0"> قوانین</legend>
                            <div class="row ">
                            <div class="col-md-7">
                                <ul class="list-group">
                                    <li class="list-group-item-success">{$lang.changeinmount}</li>
                                    <li class="list-group-item-success">{$lang.Directadminleg}</li>
                                    <li class="list-group-item-success">hazine taghire IP {$price}</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="legal">
                                    <div class="cart">
                                        <a class=" btn btn-success " target="_blank"
                                           href="clientarea.php?action=addfunds"
                                           role="button">charge</a>
                                        <span>balance: {$client.client.credit} {$client.currency_code}</span>
                                        <i class="fa fa-cart-arrow-down fa-3x"></i>

                                    </div>

                                </div>
                            </div>
                            </div>
                            <hr>
                            <div class="row">
                                <form method="post" action="clientarea.php?action=productdetails&amp;id={$id}">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {if {$client.client.credit} > {$price} }
                                        <span class="label alert-danger">{$lang.minBalance}</span>

                                            <input type="hidden" name="changeData" value="changeip" class="form-control">
                                            <label class="control-label">{$lang.changeIP}</label>
                                            <input type="text" name="changeip" class="form-control" placeholder="{$licenseInfo.ip}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="submit" value="{$lang.cln_btn_change}" class="btn btn-success form-control" style="margin-top: 25px">
                                            </div>
                                        </div>
                                </form>
                                            {else}
                                <div class="row">
                                    <div class="alert alert-danger"><span>{$lang.cannotallow}</span></div>

                                </div>
                                            {/if}



                                    </div>
                                </div>

                            </div>

                        </fieldset>
                    </div>
        {else}
            <div class="panel-body">
                <div class="input-group margin-10">
                    <div class="">
                        <div class="alert alert-danger">{$lang.notallowe} </div>

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

<style type="text/css" rel="stylesheet">
    .legal {
        text-align: left;
        margin: auto;
    }

    .legal .cart {
        width: 320px;
        background-color: #eae6e6;
        box-shadow: 3px 3px #ccc;
        border-radius: 8px;
        padding: 15px 6px;
    }

    .list-group .list-group-item-success {
        height: 35px;
        line-height: 2;
        padding-right: 5px;
        list-style-type: none;
    }
</style>