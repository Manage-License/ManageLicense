{include file="{$smarty.current_dir}/header.tpl"  }
{if $smarty.get.subAction != "Add" AND isset($smarty.get.subAction)}

    comin soon
{else}
<a class="btn btn-info" href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=setting&Sub=Products&subAction=َAdd"> ADD Products</a>
{*    {assign var=ids value=$response->getPGIds()}*}
    <div id="tableBackground" class="tablebg">
        <table class="datatable no-margin" width="100%" border="0" cellspacing="1" cellpadding="3">
            <tbody><tr>
                <th style="width: 23%;">Product Name</th>
                <th style="width: 18%;">Type</th>
                <th style="width: 18%;">Pay Type</th>
                <th style="width: 17%;">Stock</th>
                  <th style="width: 2%;"></th>
             </tr>
            </tbody></table>

        {foreach $response->getPGIds() as  $id }

        <table class="datatable sort-groups no-margin" data-id="group|{$id}|0" width="100%" border="0" cellspacing="1" cellpadding="3">
            <tbody><tr>
                <td colspan="6" style="width: 96%; background-color:#f3f3f3;">
                    <div class="prodGroup" align="left">
                        &nbsp;
                        &nbsp;<strong>Group Name:</strong>
                        {$response->getProductGroup($id)->name}
                    </div>
                </td>

            </tr>
            </tbody>
            <tbody id="tbodyGroupProduct1" class="list-group">
            {foreach $response->getServers($id) as $item}

            <tr class="product text-center" data-id="other|1|6">
                <td style="width: 23%;" class="text-left">{$item->name}</td>
                <td style="width: 18%;">{$item->type|ucfirst} (Manage License Module)</td>
                <td style="width: 18%;">{$item->paytype|ucfirst}</td>
                <td style="width: 17%;">{if $item->stockcontrol eq 0} - {else}{$item->qty}{/if}</td>

                <td style="width: 2%;"><a href="configproducts.php?action=edit&id={$item->id}" target="_blank">
                        <img src="images/edit.gif" width="16" height="16" border="0" alt="Edit">
                    </a></td>

            </tr>
            {/foreach}

            </tbody>
        </table>

        {/foreach}
     </div>

     {/if}

