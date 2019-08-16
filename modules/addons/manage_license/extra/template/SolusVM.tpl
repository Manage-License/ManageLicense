
<div class="tab-content reseller-tabbed-content">
        <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>Service ID</th>
                <th>License Key</th>
                <th>Product Title</th>
                <th>Slaves</th>
                <th>Mini Slave</th>
                <th>Micro Slave</th>
                <th>Resseler Status</th>
                <th>Status</th>
                <th>Available Actions</th>
            </tr>

            {foreach from=$Licenses item=license}
                <tr class="text-center">
                    <td><a href="https://licenseha.com/cp/clientarea.php?action=productdetails&id={$license->serviceid}">{$license->serviceid}</a></td>
                    <td>{$license->licensekey}</td>

                    <td>{$license->product}</td>
                    {*<td>{$license->license_type}</td>*}

                    <td>{$license->slaves}</td>
                    <td>{$license->minislaves}</td>
                    <td>{$license->microslaves}</td>
                    <td>{$license->resellerstatus}</td>
                    <td>{$license->status}</td>
                    <td>
                        <div class="btn-group">
                            {if $license->serviceid > 0}
                                <a href="https://licenseha.com/cp/serversalm/addonmodules.php?module=Licenses_Helper&action=removeSolusvm&licensekey={$license->licensekey|escape:'url'}">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom"
                                            data-original-title="Delete License">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </a>
                                <a href="https://licenseha.com/cp/serversalm/addonmodules.php?module=Licenses_Helper&action=updateSolusvm&licensekey={$license->licensekey|escape:'url'}">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom"
                                            title=""
                                            data-original-title="Edit License Information">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </a>
                            {else}
                                No Action
                            {/if}
                        </div>

                    </td>
                </tr>
            {/foreach}

            </tbody>
        </table>


</div>
