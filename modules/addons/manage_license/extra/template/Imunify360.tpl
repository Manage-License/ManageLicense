

    <div class="tab-pane">
        <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>Service ID</th>
                <th>LicenseKey</th>
                <th>Type</th>
                <th>Code</th>
                <th>limit</th>
                <th>servers</th>
                <th>Available Actions</th>
            </tr>

            {foreach from=$Licenses item=license}
                <tr class="text-center">
                    <td><a target="_blank"
                           href="https://licenseha.com/cp/serversalm/clientsservices.php?userid={$license->userid}&productselect={$license->serviceid}">{$license->serviceid}</a>
                    </td>
                    <td>{$license->key}</td>
                    <td>{$license->type}</td>
                    <td>{$license->code}</td>
                    <td>{$license->limit}</td>
                    <td>{$license->servers}</td>


                    <td>
                        {if $license->serviceid > 0}
                            <div class="btn-group">
                                <a href="https://licenseha.com/cp/serversalm/addonmodules.php?module=Licenses_Helper&action=removeImunify360&ip={$license->ip|escape:'url'}">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom"
                                            data-original-title="Delete License">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                                <a href="https://licenseha.com/cp/serversalm/addonmodules.php?module=Licenses_Helper&action=updateImunify360&serviceid={$license->serviceid|escape:'url'}">
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
