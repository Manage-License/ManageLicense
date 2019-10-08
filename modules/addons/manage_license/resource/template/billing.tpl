<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>

{include file="{$smarty.current_dir}/header.tpl"  }

{if $response.message eq 0}
    <div class="alert alert-danger text-center">

        {$lang.noinvoice}


    </div>
{elseif $smarty.get.Sub eq 'AddFund'}
    coming soon
{else}
    <div id="invoice" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 container">
    <div class="product-section">
        <div class="border-card">
            <div class="row">
                <div class="col-md-6"><h2
                            class="text-center">{$lang.countinvoice|sprintf:{$response.invoices|count}}</h2></div>
                <div class="col-md-3"><h4>{$lang.balance}: {$response.balance}</h4></div>
                <div class="col-md-3"><h4>{$lang.currency}: {$response.currency}</h4></div>
            </div>
            <table class="table table-striped table-hover dt-responsive"
                   cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>{$lang.id}</th>
                    <th>{$lang.invoiceId}</th>
                    <th>{$lang.date}</th>
                    <th>{$lang.total}</th>
                    <th>{$lang.paymentmethod}</th>
                    <th>{$lang.status}</th>
                    <th>{$lang.description}</th>

                </tr>
                </thead>
                <tbody>
                {assign var="num" value="1"}
                {assign var="trnum" value="1"}
                {assign var="description" value=""}

                {foreach from=$response.invoices item=invoice}
                    {assign var=count value=$invoice|count}
                    <tr>
                        {foreach $invoice as $key=>$data}
                            {if $key eq "total"}
                                {assign var="trnum" value="1"}
                                <td> {$num}</td>
                                <td>{$invoice.total.id}0</td>
                                <td>{$invoice.total.date}</td>
                                <td>{$invoice.total.total}</td>
                                <td>{$invoice.total.paymentmethod}</td>
                                {if $invoice.total.status eq 'Unpaid'}
                                    <td>{$invoice.total.status}</td>
                                {else}
                                    <td>{$invoice.total.status}</td>
                                {/if}

                            {else}
                                {if $trnum eq 1}
                                    {assign var="description" value="{$data.description}"}
                                {else}
                                    {assign var="description" value="{$description}<br>{$data.description}"}



                                {/if}
                                {assign var="trnum" value=$trnum+1}
                            {/if}



                        {/foreach}
                        <td>
                            {$description}
                        </td>

                        {assign var="description" value=" "}


                    </tr>
                    {assign var="num" value=$num+1}

                {/foreach}

                </tbody>
            </table>

        </div>

    </div>
    </div>{/if}
