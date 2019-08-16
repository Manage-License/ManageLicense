

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover text-center">
        <caption>Invoice List</caption>
        <thead>
        <tr>
            <th class="text-center" scope="col">Invoice #</th>
            <th class="text-center" scope="col">Invoice Date</th>
            <th class="text-center" scope="col">Due Date</th>
            <th class="text-center" scope="col">Date Paid</th>
            <th class="text-center" scope="col">Total</th>
            <th class="text-center" scope="col">Payment Method</th>
            <th class="text-center" scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$Invoices item=invoice}
            <tr>
                <th class="text-center" scope="row"><a href="https://licenseha.com/cp/viewinvoice.php?id={$invoice->id}"
                                                       target="_blank">{$invoice->id}</a></th>
                <td>{$invoice->date}</td>
                <td>{$invoice->duedate}</td>
                <td>{$invoice->datepaid}</td>
                <td>{$invoice->subtotal} {$invoice->currencysuffix}</td>
                <td>{$invoice->paymentmethod}</td>
                <td>
                    {if $invoice->status eq 'Paid'}
                        <span for="" class="btn btn-xs btn-success">{$invoice->status}</span>
                    {elseif $invoice->status eq 'Cancelled'}
                        <span for="" class="btn btn-xs btn-danger">{$invoice->status}</span>
                    {elseif $invoice->status eq 'Unpaid'}
                        <span for="" class="btn btn-xs btn-warning">{$invoice->status}</span>
                    {/if}
                </td>
            </tr>
        {/foreach}
        <tr>
            <th scope="row">Total: </th>
            <th colspan="6">{$total}  {$invoice->currencysuffix}</th>
        </tr>
        </tbody>
    </table>
</div>
