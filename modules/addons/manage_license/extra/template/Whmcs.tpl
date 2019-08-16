

    <div class="tab-pane">
        <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>Service ID</th>
                <th>License Key</th>
                <th>License Type</th>
                <th>Valid Domain</th>
                <th>Valid Directory</th>
                <th>Valid IP</th>
                <th>Status</th>
                <th>Available Actions</th>
            </tr>


            {foreach from=$Licenses item=license}
                <tr class="text-center">
                    <td><a target="_blank" href="https://licenseha.com/cp/clientarea.php?action=productdetails&id={$license->serviceid}">{$license->serviceid}</a></td>
                    <td>{$license->licensekey}</td>
                    <td>{$license->pname}</td>
                    <td>{$license->valid_domain}</td>
                    <td>{$license->valid_dir}</td>
                    <td>{$license->ip}</td>
                    <td>{$license->status}</td>
                    <td>
                        {if $license->serviceid > 0}
                            <div class="btn-group">
                                <a href="https://licenseha.com/cp/serversalm/addonmodules.php?module=Licenses_Helper&action=removeWhmcs&licensekey={$license->licensekey|escape:'url'}">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom"
                                            data-original-title="Delete License">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                                <a href="https://licenseha.com/cp/serversalm/addonmodules.php?module=Licenses_Helper&action=updateWhmcs&licensekey={$license->licensekey|escape:'url'}">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom"
                                            title=""
                                            data-original-title="Edit License Information">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>

                            </div>
                        {else}
                            No Action Set
                        {/if}
                    </td>
                </tr>
            {/foreach}

            </tbody>
        </table>
    </div>
