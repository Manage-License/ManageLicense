{if $licenseInfo.showForm == true}
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="tab0">
            <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                <div class="panel panel-default">
                    <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                         aria-live="polite">
                        <h5><strong>{$LANG.insertdata}</strong></h5>
                    </div>
                    <form class="form" method="post">
                        <div class="form-group">
                            <label for="csr">{$LANG.CSR}: </label>{$LANG.required}
                            <textarea class="form-control" style="direction: ltr"  name="csr" rows="5" required> {$post.csr}</textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="firstname">{$LANG.FirstName}: {$LANG.required} </label>
                            <input class="form-control" name="firstname" type="text" value="{$post.firstname}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">{$LANG.LastName}: {$LANG.required}</label>
                            <input class="form-control" name="lastname" type="text" value="{$post.lastname}" required>
                        </div>
                        <div class=" alert alert-info col-md-12">
                            {$LANG.OrganizationAlert}
                            <div class="form-group col-md-6">
                                <label for="orgname">{$LANG.OrganizationName}: </label>
                                <input class="form-control" name="orgname" type="text" value="{$post.orgname}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="orgtaxid">{$LANG.OrganizationTaxIdentification}: </label>
                                <input class="form-control" name="orgtaxid" type="text" value="{$post.orgtaxid}">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">{$LANG.Email}: {$LANG.required}</label>
                            <input class="form-control" style="direction: ltr"  name="email" type="email" value="{$post.email}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address1">{$LANG.AddressLine1}: {$LANG.required}</label>
                            <input class="form-control" name="address1" type="text" value="{$post.address1}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address2">{$LANG.AddressLine2}: </label>
                            <input class="form-control" name="address2" type="text" value="{$post.address2}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state">{$LANG.state}: </label>
                            <input class="form-control" type="tel" name="state" value="{$post.state}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">{$LANG.City}: {$LANG.required}</label>
                            <input class="form-control" name="city" type="text" value="{$post.city}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="postalcode">{$LANG.PostalCode}: {$LANG.required}</label>
                            <input class="form-control" name="postalcode" type="text" value="{$post.postalcode}"
                                   required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country">{$LANG.Country}: {$LANG.required}</label>

                            <select name="country" id="inputCountry" class="field form-control">
                                {foreach $clientcountries as $countryCode => $countryName}
                                    <option value="{$countryCode}"{if $countryCode eq $client.country} selected="selected"{/if}>
                                        {$countryName.name}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">{$LANG.PhoneNumber}: {$LANG.required}</label>
                            <input class="form-control" type="tel" name="phone" value="{$post.phone}" required>
                        </div>
                        <div class="alert alert-warning col-md-12">
                            {for $i=1 to $licenseInfo.domaincount}
                                {if $licenseInfo.productName|strpos:"WildCard" !== false}
                                    <label for="note"
                                           class="text-right ">{$LANG.WildCardNote}</label>
                                {/if}
                                <div class="form-group {if $licenseInfo.domaincount != 1}col-md-6{/if} ">
                                    <label for="domain[{$i}]"> {$LANG.Domain} {if $licenseInfo.domaincount != 1}{$i}{/if}</label>
                                    <input class="form-control" style="direction: ltr;font-family: Tahoma" name="domain[{$i}]"
                                           value="{if $i == 1}{$licenseInfo.mainDomain}{else}{$post.domain[$i]}{/if}">
                                </div>
                            {/for}
                        </div>
                        <input type="hidden" name="ssl" value={$licenseInfo.id}>
                        <input type="hidden" name="changeData" value='changeData'>
                        <input type="hidden" name="submitform" value="1">
                        <input class="btn btn-success btn-block" type="submit" value="{$LANG.Submit}">
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}
{**********************************************************************}
{if $licenseInfo.setApprovers == true}
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="tab0">
            <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                <div class="panel panel-default">
                    <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                         aria-live="polite">
                        <div class="row">
                            <div class="form-group col-md-2 text-center">
                                <label>{$LANG.Domain}</label>
                            </div>
                            <div class="form-group col-md-4 text-center">
                                <label>{$LANG.VerificationMethod}</label>
                            </div>
                            <div class="form-group col-md-4 text-center">
                                <label>{$LANG.VerificationEmail}</label>
                            </div>
                            <div class="form-group col-md-2 text-center">
                                <label>{$LANG.WithWWW}</label>
                            </div>
                        </div>
                    </div>
                    <form class="form" id="approvers_form" method="post">
                        {if $licenseInfo.domaincount == 1 && count($licenseInfo.approvers.Approver) != 1}
                            <div class="row">
                                <div class="form-group col-md-2  text-center">
                                    <label for="{$licenseInfo.approvers.Approver.FQDN}">{$licenseInfo.approvers.Approver.FQDN}</label>
                                    <input type="hidden" name="FQDN[1]" value="{$licenseInfo.approvers.Approver.FQDN}">
                                </div>
                                <div class="form-group col-md-4  text-center">
                                    <select class="form-control methodselect" data-attr="1" name="method[1]">
                                        {foreach from=$licenseInfo.approvers.Approver.approveMethod item=method}
                                            <option value="{$method}">{$method}</option>
                                        {/foreach}
                                        <option value="EMAIL">EMAIL</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4  text-center">
                                    <select data-attre="email1" class="form-control vemail" name="email[1]">
                                        <option value="" selected></option>
                                        {foreach from=$licenseInfo.approvers.Approver.approverEmail item=email}
                                            <option value="{$email}">{$email}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                {if !$licenseInfo.nowww}
                                    <div class="form-group col-md-2  text-center">
                                        <input class="form-control" type="checkbox" name="www[1]" checked>
                                    </div>
                                {/if}
                            </div>
                        {else}
                            {$k = 1}
                            {foreach from=$licenseInfo.approvers.Approver item=approver}
                                {*{if $approver.mainDomain eq true}*}
                                <div class="row">
                                    <div class="form-group col-md-3 text-center">
                                        <label for="{$approver.FQDN}">{$approver.FQDN}</label>
                                        <input type="hidden" name="FQDN[{$k}]" value="{$approver.FQDN}">
                                    </div>
                                    <div class="form-group col-md-4 text-center">
                                        <select class="form-control methodselect" data-attr="{$k}"
                                                name="method[{$k}]">
                                            {foreach from=$approver.approveMethod item=method}
                                                <option value="{$method}">{$method}</option>
                                            {/foreach}
                                            <option value="EMAIL">EMAIL</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 text-center">
                                        <select data-attre="email{$k}" class="form-control vemail"
                                                name="email[{$k}]">
                                            <option value="" selected></option>
                                            {foreach from=$approver.approverEmail item=email}
                                                <option value="{$email}">{$email}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {if !$licenseInfo.nowww}
                                        <div class="form-group col-md-2 text-center">
                                            <input class="form-control" type="checkbox" name="www[{$k}]" checked>
                                        </div>
                                    {/if}
                                </div>
                                {*{/if}*}
                                {$k = $k +1}
                            {/foreach}
                        {/if}
                        <input type="hidden" name="ssl" value={$licenseInfo.id}>
                        <input type="hidden" name="changeData" value='changeData'>
                        <input type="hidden" name="submitform" value="1">
                        <input class="btn btn-success btn-block" type="submit" value="{$LANG.Submit}">
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}
{****************************new**************************************}
{if $licenseInfo.changeApproverstep1 == true}
    <form class="form" method="post">
        <div style="text-align:left">
            {foreach from=$licenseInfo.fqdnList item=fqdns}
                <label for="{$fqdns}" style="margin: 5px;">{$fqdns}</label>
                <input type="radio" name="selectdomain" value="{$fqdns}">
                <br>
            {/foreach}
        </div>
        <input class="btn btn-success btn-block" type="submit" value="{$LANG.selectDomain}">
        <input type="hidden" name="ssl" value={$licenseInfo.id}>
        <input type="hidden" name="step" value="getmethod">
        <input type="hidden" name="changeData" value='changeData'>
    </form>
{/if}
{if $licenseInfo.changeApproverstep2 == True}
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="tab0">
            <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                <div class="panel panel-default">
                    <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                         aria-live="polite">
                        <div class="row">
                            <div class="form-group col-md-3 text-center">
                                <label>{$LANG.Domain}</label>
                            </div>
                            <div class="form-group col-md-4 text-center">
                                <label>{$LANG.VerificationMethod}</label>
                            </div>
                            <div class="form-group col-md-3 text-center">
                                <label>{$LANG.VerificationEmail}</label>
                            </div>
                            <div class="form-group col-md-2 text-center">
                                <label>{$LANG.WithWWW}</label>
                            </div>

                        </div>
                    </div>
                    <form class="form" method="post">
                        <div class="row">

                            <div class="form-group col-md-3 text-center">
                                <label for="{$licenseInfo.approver.FQDN}">{$licenseInfo.approver.FQDN}</label>
                                <input type="hidden" name="FQDN-changeApprover" value="{$licenseInfo.approver.FQDN}">
                                {*                            <input type="hidden" name="FQDN-changeApprover" value="1">*}
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control methodselect" data-attr="1" name="method[1]">
                                    {foreach from=$licenseInfo.approver.approveMethod item=method}
                                        <option value="{$method}">{$method}</option>
                                    {/foreach}
                                    <option value="EMAIL">EMAIL</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select data-attre="email1" class="form-control vemail" name="email[1]">
                                    <option value="" selected></option>
                                    {foreach from=$licenseInfo.approver.approverEmail item=email}
                                        <option value="{$email}">{$email}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group col-md-2 text-center">
                                <input class="form-control" type="checkbox" name="www" checked>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <input type="hidden" name="ssl" value={$licenseInfo.id}>
                            <input type="hidden" name="changeData" value='changeData'>
                            <input type="hidden" name="step" value='changeaction'>
                            <input class="btn btn-warning" type="submit" value="{$LANG.ChangeApprovers}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}
{if $licenseInfo.changeApproverstep3 == true }
    <form class="form" id="approvers_form" method="post">

        <div class="tab-content clearfix">
            <div class="tab-pane active" id="tab0">
                <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                    <div class="panel panel-default">
                        <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                             aria-live="polite">
                            <div class="row">
                                <div class="form-group col-md-3 text-center">
                                    <label>{$LANG.Domain}</label>
                                </div>
                                <div class="form-group col-md-4 text-center">
                                    <label>{$LANG.VerificationMethod}</label>
                                </div>
                                <div class="form-group col-md-3 text-center">
                                    <label>{$LANG.VerificationEmail}</label>
                                </div>
                                <div class="form-group col-md-2 text-center">
                                    <label>{$LANG.WithWWW}</label>
                                </div>
                            </div>
                        </div>
                        {if $licenseInfo.approvers.Approver|count !=1 &&   $licenseInfo.domaincount != 1}
                        {$key = 1}

                        {foreach from=$licenseInfo.approvers.Approver item=Approver}
                            <div class="row">
                                <div class="form-group col-md-3  text-center">
                                    <label for="{$Approver.FQDN}">{$Approver.FQDN}</label>
                                    <input type="hidden" name="FQDN-changeApprover[{$key}]"
                                           value="{$Approver.FQDN}">
                                </div>
                                <div class="form-group col-md-4  text-center">
                                    <select class="form-control methodselect" data-attr="{$key}" name="method[{$key}]">
                                        {foreach from=$Approver.approveMethod item=method}
                                            <option value="{$method}">{$method}</option>
                                        {/foreach}
                                        <option value="EMAIL">EMAIL</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3  text-center">
                                    <select data-attre="email{$key}" class="form-control vemail" name="email[{$key}]">
                                        <option value="" selected></option>
                                        {foreach from=$Approver.approverEmail item=email}
                                            <option value="{$email}">{$email}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                {if !$licenseInfo.nowww}
                                    <div class="form-group col-md-2  text-center">
                                        <input class="form-control" type="checkbox" name="www[{$key}]" checked>
                                    </div>
                                {/if}
                            </div>
                            {$key = $key +1}
                        {/foreach}

                        {else}

                        <div class="row">
                            <div class="form-group col-md-3  text-center">
                                <label for="{$licenseInfo.approvers.Approver.FQDN}">{$licenseInfo.approvers.Approver.FQDN}</label>
                                <input type="hidden" name="FQDN-changeApprover"
                                       value="{$licenseInfo.approvers.Approver.FQDN}">
                            </div>
                            <div class="form-group col-md-4  text-center">
                                <select class="form-control methodselect" data-attr="1" name="method[1]">
                                    {foreach from=$licenseInfo.approvers.Approver.approveMethod item=method}
                                        <option value="{$method}">{$method}</option>
                                    {/foreach}
                                    <option value="EMAIL">EMAIL</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3  text-center">
                                <select data-attre="email1" class="form-control vemail" name="email[1]">
                                    <option value="" selected></option>
                                    {foreach from=$licenseInfo.approvers.Approver.approverEmail item=email}
                                        <option value="{$email}">{$email}</option>
                                    {/foreach}
                                </select>
                            </div>
                            {if !$licenseInfo.nowww}
                                <div class="form-group col-md-2  text-center">
                                    <input class="form-control" type="checkbox" name="www" checked>
                                </div>
                            {/if}

                            {/if}
                        </div>
                        <input type="hidden" name="ssl" value={$licenseInfo.id}>
                        <input type="hidden" name="changeData" value='changeData'>
                        <input type="hidden" name="step" value='changeaction'>
                        <input class="btn btn-success btn-block" type="submit" value="{$LANG.ChangeApprovers}">

                    </div>
                </div>
            </div>
        </div>
        {*<input type="hidden" name="ssl" value={$licenseInfo.id}>*}
        {*<input type="hidden" name="step" value='changeaction'>*}
        {*<input type="hidden" name="changeData" value='changeData'>*}
    </form>
{/if}
{*{if $licenseInfo.changeApproverstep4 == true}
    Done!
    {/if}*}
{****************************end new**************************************}
{***********************************************************************}
{if $licenseInfo.showChangeApprover == true}
    {* <div class="tab-content clearfix">
         <div class="tab-pane active" id="tab0">
             <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                 <div class="listtable">
                     <div class="dataTables_info" id="tableServicesList_info" role="status" aria-live="polite">
                         <div class="row">
                             <div class="form-group col-md-3 text-center">
                                 <label>{$LANG.Domain}</label>
                             </div>
                             <div class="form-group col-md-4 text-center">
                                 <label>{$LANG.VerificationMethod}</label>
                             </div>
                             <div class="form-group col-md-3 text-center">
                                 <label>{$LANG.VerificationEmail}</label>
                             </div>
                             <div class="form-group col-md-2 text-center">
                                 <label>{$LANG.WithWWW}</label>
                             </div>
                         </div>
                     </div>
                     <form class="form" id="approvers_form" method="post">
                     <div class="row">

                         <div class="form-group col-md-3 text-center">
                             <label for="{$licenseInfo.approver.FQDN}">{$licenseInfo.approver.FQDN}</label>
                             <input type="hidden" name="FQDN-changeApprover" value="{$licenseInfo.approver.FQDN}">
                             <input type="hidden" name="FQDN-changeApprover" value="1">
                         </div>
                         <div class="form-group col-md-4">
                             <select class="form-control methodselect" data-attr="1" name="method[1]">
                                     {foreach from=$licenseInfo.approver.approveMethod item=method}
                                         <option value="{$method}">{$method}</option>
                                     {/foreach}
                                     <option value="EMAIL">EMAIL</option>
                             </select>
                         </div>
                         <div class="form-group col-md-3">
                             <select data-attre="email1" class="form-control vemail" name="email[1]">
                                 <option value="" selected></option>
                                 {foreach from=$licenseInfo.approver.approverEmail item=email}
                                     <option value="{$email}">{$email}</option>
                                 {/foreach}
                             </select>
                         </div>
                         <div class="form-group col-md-2 text-center">
                             <input class="" type="checkbox" name="www">
                         </div>
                     </div>
                     <div class="form-group text-center">
                         <input type="hidden" name="ssl" value={$licenseInfo.id}>
                         <input type="hidden" name="changeData" value='changeData'>
                         <input type="hidden" name="step" value='2'>
                         <input class="btn btn-warning" type="submit" value="{$LANG.ChangeApprovers}">
                     </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>*}
{/if}
{*************************************************************************}
{if $licenseInfo.selectChangeApprover == true}
    {*<form class="form" id="approvers_form" method="post">
        {if $licenseInfo.domaincount == 1}
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="tab0">
                    <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                        <div class="listtable">
                            <div class="dataTables_info" id="tableServicesList_info" role="status" aria-live="polite">
                                <div class="row">
                                    <div class="form-group col-md-3 text-center">
                                        <label>{$LANG.Domain}</label>
                                    </div>
                                    <div class="form-group col-md-4 text-center">
                                        <label>{$LANG.VerificationMethod}</label>
                                    </div>
                                    <div class="form-group col-md-3 text-center">
                                        <label>{$LANG.VerificationEmail}</label>
                                    </div>
                                    <div class="form-group col-md-2 text-center">
                                        <label>{$LANG.WithWWW}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3  text-center">
                                        <label for="{$licenseInfo.approvers.Approver.FQDN}">{$licenseInfo.approvers.Approver.FQDN}</label>
                                        <input type="hidden" name="FQDN-changeApprover" value="{$licenseInfo.approvers.Approver.FQDN}">
                                    </div>
                                    <div class="form-group col-md-4  text-center">
                                        <select class="form-control methodselect" data-attr="1" name="method[1]">
                                                {foreach from=$licenseInfo.approvers.Approver.approveMethod item=method}
                                                    <option value="{$method}">{$method}</option>
                                                {/foreach}
                                                <option value="EMAIL">EMAIL</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3  text-center">
                                        <select data-attre="email1" class="form-control vemail" name="email[1]">
                                            <option value="" selected></option>
                                            {foreach from=$licenseInfo.approvers.Approver.approverEmail item=email}
                                                <option value="{$email}">{$email}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {if !$licenseInfo.nowww}
                                        <div class="form-group col-md-2  text-center">
                                            <input class="form-control" type="checkbox" name="www">
                                        </div>
                                    {/if}
                                </div>
                            </div>
                                <input type="hidden" name="ssl" value={$licenseInfo.id}>
                                <input type="hidden" name="changeData" value='changeData'>
                                <input type="hidden" name="step" value='2'>
                            <input class="btn btn-success btn-block" type="submit" value="{$LANG.ChangeApprovers}">
                        </div>
                    </div>
                </div>
            </div>
        {else}*}
    {* <div style="text-align:left">
     {foreach from=$licenseInfo.fqdnList item=fqdns}
         <label for="{$fqdns}" style="margin: 5px;">{$fqdns}</label><input type="radio" name="fqdn-selectdomain" value="{$fqdns}"><br>
     {/foreach}
     </div>
     <input class="btn btn-success btn-block" type="submit" value="{$LANG.selectDomain}">
 {/if}
 <input type="hidden" name="ssl" value={$licenseInfo.id}>
 <input type="hidden" name="step" value='1'>
 <input type="hidden" name="changeData" value='changeData'>
</form>*}
{/if}
{**************************************************************************}
{if $licenseInfo.renewResponse == true}
    <div class="row">
        <div class="alert alert-success">{$LANG.renewSuccess}
            <a class="btn btn-success"
               href="{$systemurl}clientarea.php?action=productdetails&id={$id}&changeData=changeData">{$LANG.back}</a>
        </div>
    </div>
{/if}
{if $licenseInfo.reissueResponse}
    <div class="row">
        <div class="alert alert-success">{$LANG.reissueSuccess}
            <a class="btn btn-success"
               href="{$systemurl}clientarea.php?action=productdetails&id={$id}&changeData=changeData">{$LANG.back}</a>
        </div>
    </div>
{/if}
{if $licenseInfo.sendNotificatoinResponse == true}
    <div class="row">
        <div class="alert alert-success">{$LANG.notificationSuccess}
            <a class="btn btn-success"
               href="{$systemurl}clientarea.php?action=productdetails&id={$id}&changeData=changeData">{$LANG.back}</a>
        </div>
    </div>
{/if}
{if $licenseInfo.changeApproverResponse == true}
    <div class="row">
        <div class="alert alert-success">{$LANG.changeApproverSuccess}
            <a class="btn btn-success"
               href="{$systemurl}clientarea.php?action=productdetails&id={$id}&changeData=changeData">{$LANG.back}</a>
        </div>
    </div>
{/if}
{***************************************************************************}
{* {if $record.error == true}
      {$record.errors|@print_r}
    {foreach from=$record.errors item=err}

        <div class="row" style="margin-bottom: 8px;">
            <div class="alert alert-danger col-md-12"><strong>Error!</strong>{$err}</div><br>
        </div>
    {/foreach}
{/if}*}
{if $record.message == true}
    {foreach from=$record.messages item=msg}
        <div class="row" style="margin-bottom: 8px;">
            <div class="alert alert-warning col-md-12"><strong>Warning!</strong>{$msg}</div>
            <br>
        </div>
    {/foreach}
{/if}
{***********************************************************************************************}
{if $licenseInfo.showDetails == true}
    <ul class="nav nav-tabs">
        {foreach from=$licenseInfo key=k item=record}
            {if $record.details.orderStatus.orderID}
                <li {if $k==0}class="active"{/if}><a href="#tab{$k}"
                                                     data-toggle="tab">{$record.productTitle} {*#{$record.details.orderStatus.orderID}*}</a>
                </li>
            {/if}
        {/foreach}
    </ul>
    <div class="tab-content clearfix">
        {foreach from=$licenseInfo key=k item=record}
            {if $record.details.orderStatus.orderID}
                <div class="tab-pane {if $k==0} active{/if}" id="tab{$k}">
                    <div id="tableServicesList_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="panel panel-default">
                            <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                                 aria-live="polite">
                                <a data-toggle="collapse" href="#collapse{$k}">
                                    <h6>{$LANG.ProductDetails}</h6></a>
                            </div>
                            <div id="collapse{$k}" class="panel-collapse collapse in">
                                <table id="tableServicesList" class="table table-list dataTable no-footer dtr-inline"
                                       aria-describedby="tableServicesList_info" role="grid">
                                    <tbody>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.Status}</strong></td>
                                        <td class="text-center">{$record.details.orderStatus.orderStatus}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.MainDomain}</strong></td>
                                        <td class="text-center " style="direction: ltr">{if $record.details.certificateDetails.commonName}{$record.details.certificateDetails.commonName}{else}{$domain}{/if}</td>
                                    </tr>
                                    {if $record.details.certificateDetails.commonName}
                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><strong>{$LANG.SNA}</strong></td>
                                            <td class="text-center"  style="direction: ltr">{$record.details.certificateDetails.DNSNames}</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><strong>{$LANG.CertificateStatus} </strong></td>
                                            <td class="text-center">{$record.details.certificateDetails.certificateStatus}</td>
                                        </tr>
                                    {/if}
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.FirstName}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.firstName}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.LastName}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.lastName}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.Address}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.addressLine1}</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1"><strong>{$LANG.City}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.city}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.Country}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.country}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.Email}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.email}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><strong>{$LANG.PostalCode}</strong></td>
                                        <td class="text-center">{$record.details.orderDetails.requestorInfo.postalCode}</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1" ><strong>{$LANG.Phone}</strong></td>
                                        <td class="text-center" style="direction: ltr">{$record.details.orderDetails.requestorInfo.phone}</td>
                                    </tr>


                                    {*$record|@print_r*}
                                    {if $record.cabundle != '' || $record.cabundle != NULL}
                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><strong>{$LANG.cabundle}</strong></td>
                                            <td class="text-center" style="text-align: left;direction: ltr;">
                                                {foreach from=$record.cabundle key=j item=ca}
                                                    <br>
                                                    <code style="white-space:pre-wrap; font-family: Tahoma;">{$ca}</code>
                                                {/foreach}

                                            </td>
                                        </tr>
                                    {/if}
                                    {if $record.details.certificateDetails.X509Cert != '' || $record.details.certificateDetails.X509Cert != NULL}
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" style="font-family: Tahoma;">
                                                <strong>{$LANG.CertificateX509Cert}</strong></td>
                                            <td class="text-center"
                                                style="text-align: left;direction: ltr; font-family: Tahoma;"><code
                                                        style="font-family: Tahoma;">-----BEGIN
                                                    CERTIFICATE-----<br>{$record.details.certificateDetails.X509Cert}
                                                    <br>-----END CERTIFICATE-----</code></td>
                                        </tr>
                                    {/if}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    {if $record.reissueDetail}
                        <div id="tableServicesList_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="panel panel-default">
                                <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                                     aria-live="polite">
                                    <a data-toggle="collapse" href="#collapser0" class="btn-primary">
                                        <h6>{$LANG.ReissueDetails}</h6></a>
                                </div>
                                <div id="collapser0" class="panel-collapse collapse in">
                                    <table id="tableServicesList"
                                           class="table table-list dataTable no-footer dtr-inline"
                                           aria-describedby="tableServicesList_info" role="grid">
                                        <tbody>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><strong>{$LANG.Status}</strong></td>
                                            <td class="text-center">{$record.reissueDetail.orderStatus.orderStatus}</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1"><strong>{$LANG.CertificateStatus}</strong></td>
                                            <td class="text-center">{$record.reissueDetail.certificateDetails.certificateStatus}</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" style="font-family: Tahoma;">
                                                <strong>{$LANG.CertificateX509Cert}</strong></td>
                                            {* <td class="text-center">{$record.reissueDetail.certificateDetails.X509Cert}</td>*}
                                            <td class="text-center"
                                                {if $record.reissueDetail.orderStatus.orderStatus != "ENROLLED"}
                                                    >
                                                    {$LANG.waitENROLLED}
                                               {else}
                                                style="text-align: left;direction: ltr; font-family: Tahoma;">
                                                <code
                                                        style="font-family: Tahoma;">-----BEGIN
                                                    CERTIFICATE-----<br>{$record.reissueDetail.certificateDetails.X509Cert}
                                                    <br>-----END CERTIFICATE-----</code></td>
                                            {/if}
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    {/if}
                    {if $record.showSendNotifLink == true}
                        <div class="row"><a class="btn btn-danger btn-block"
                                            href="{$systemurl}clientarea.php?action=productdetails&id={$record.serviceId}&ssl={$record.id}&request=sendnotification&changeData=changeData">{$LANG.sendNotification}    </a>
                        </div>
                    {/if}
                    {if $record.showChangeAppLink == true}
                        <br>
                        <div class="row"><a class="btn btn-warning btn-block"
                                            href="{$systemurl}clientarea.php?action=productdetails&id={$record.serviceId}&ssl={$record.id}&request=changeapprover&changeData=changeData"> {$LANG.changeApprover}   </a>
                        </div>
                    {/if}
                    {if $record.showRenewLink}
                        <br>
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="tab0">
                                <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                                    <div class="panel panel-default">
                                        <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                                             aria-live="polite">
                                            <a data-toggle="collapse" href="#collapserenew" class="btn-primary">
                                                <h6>{$LANG.Renew}</h6></a>
                                        </div>

                                        <div id="collapserenew" class="panel-collapse collapse">
                                            <label> {$LANG.RenewHead}</label>

                                            <div class="panel-title panel-heading alert alert-info"  role="status"
                                                 aria-live="polite">
                                                <div class="row">
                                                    <div class="form-group col-md-3 text-center">
                                                        <label>{$LANG.Domain}</label>
                                                    </div>
                                                    <div class="form-group col-md-4 text-center">
                                                        <label>{$LANG.VerificationMethod}</label>
                                                    </div>
                                                    <div class="form-group col-md-3 text-center">
                                                        <label>{$LANG.VerificationEmail}</label>
                                                    </div>
                                                    <div class="form-group col-md-2 text-center">
                                                        <label>{$LANG.WithWWW}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                {foreach from=$record.approvers   item=approvers}
                                                    <br>
                                                    <div class="row">
                                                        <div class="form-group col-md-3 text-center">
                                                            <label>{$approvers.fqdn}</label>
                                                        </div>
                                                        <div class="form-group col-md-4 text-center">
                                                            <label>{if $approvers.method == ""}Email{else}{$approvers.method}{/if}</label>
                                                        </div>
                                                        <div class="form-group col-md-3 text-center">
                                                            <label>{$approvers.email}</label>
                                                        </div>
                                                        <div class="form-group col-md-2 text-center">
                                                            <label>{$approvers.www}</label>
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            </div>
                                            <br>
                                            <form class="form" id="details_form22" method="post">
                                                <div class="form-group col-md-12">
                                                    <label for="csr">* {$LANG.CSR}: </label>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <textarea class="form-control" name="csr" rows="5"
                                                              required></textarea>
                                                </div>

                                                <input type="hidden" name="renew" value="true">
                                                <input class="btn btn-success btn-block" type="submit"
                                                       value="{$LANG.Renew}">
                                                <input type="hidden" name="ssl" value={$record.id}>
                                                <input type="hidden" name="changeData" value='changeData'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                    {if $record.showReissueLink}
                        {* <br>
                         <div class="row"><div class="alert alert-info"> <a href="{$systemurl}clientarea.php?action=productdetails&id={$record.serviceId}&ssl={$record.id}&request=reissue&changeData=changeData" class="button button-editor-solid">reissue</a></div> </div>
                        *}
                        {*                        <br>*}
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="tab10">
                                <div id="tableServicesList_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                                    <div class="panel panel-default">
                                        <div class="panel-title panel-heading" id="tableServicesList_info" role="status"
                                             aria-live="polite">
                                            <a data-toggle="collapse" href="#collapsereissue" class="btn-primary">
                                                <h6>{$LANG.Reissue}</h6></a>
                                        </div>
                                        <div id="collapsereissue" class="panel-collapse collapse">
                                            <form class="form" id="details_form32" method="post">
                                                <div class="form-group col-md-12">
                                                    <label for="csr">{$LANG.CSR}*: </label>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <textarea class="form-control" name="csr" rows="5"
                                                              required></textarea>
                                                </div>
                                                <input type="hidden" name="reissue" value="true">
                                                <input class="btn btn-success btn-block" type="submit"
                                                       value="{$LANG.Reissue}">
                                                <input type="hidden" name="ssl" value={$record.id}>
                                                <input type="hidden" name="changeData" value='changeData'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
            {/if}
        {/foreach}
    </div>
{/if}
{***************************************************************************}

{if $licenseInfo.successOrder == true}
    <div class="row">
        <div class="alert alert-success">{$LANG.orderSuccess}
            <a class="btn btn-success"
               href="{$systemurl}clientarea.php?action=productdetails&id={$id}&changeData=changeData">{$LANG.back}</a>
        </div>
    </div>
{/if}



{*******************************************************************************}
<script type="text/javascript">
    $(document).ready(function () {
        $(".vemail").hide();
    });

    $(".methodselect").change(function (e) {
        data = $(this).attr("data-attr");
        if ($(this).val() == "EMAIL") {
            $("select[data-attre='email" + data + "']").show();
        } else {
            $("select[data-attre='email" + data + "']").hide();
        }
    });
</script>
