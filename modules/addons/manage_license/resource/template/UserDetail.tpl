
{include file="{$smarty.current_dir}/header.tpl"  }

<div class="row">
    <div class="col-md-3">
        <div class="portlet light profile-sidebar-portlet bordered">
            <div class="profile-userpic">
                <img src="https://www.gravatar.com/avatar/{$response.email|md5}.png?s=215" class="img-responsive"
                     alt="Your Gravatar Picture"></div>
            <div class="row profile-usertitle">
                <div class="profile-usertitle-name"> {$response.firstname} {$response.lastname} </div>
                <div class="profile-usertitle-job"><span class="label "
                                                         style="background-color: {$response.color};"> {$response.group} </span>
                </div>
                <div>
                    <strong>{$lang.companyname}: </strong> {$response.companyname}
                </div>
                <div>
                    <strong>{$lang.Email}: </strong> {$response.email}
                </div>
                <div>
                    <strong>{$lang.status}: </strong> {$response.status}
                </div>
                <div>
                    <strong>{$lang.separateinvoices}: </strong> {if $response.separateinvoices}{$lang.Yes}{else}{$lang.No}{/if}
                </div>
                <div>
                    <strong>{$lang.disableautocc}: </strong> {if $response.disableautocc}{$lang.Yes}{else}{$lang.No}{/if}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="portlet light ">
            <div class="portlet-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 bordered">

                            <nav class="navbar navbar-inverse" style="background-color: #1a4d80">
                                <div class=" navbar-header "><h2 class="text-center"> {$lang.Creditinfo} </h2></div>
                            </nav>
                            <div class="pic-back"><strong class="text-center"
                                                          style="display: block;color: #000000;">{$lang.balance}</strong>
                                <h3 class="text-center"> {$response.stats.creditbalance} </h3>
                            </div>


                            <div>
                                <strong>{$lang.totalUnpaid}: </strong> {$response.stats.unpaidinvoicesamount}
                                <span></span>
                            </div>
                            <div>
                                <strong>{$lang.numberUnpaid}: </strong> {$response.stats.numunpaidinvoices}
                            </div>
                            <div>
                                <strong>{$lang.totalpaid}: </strong> {$response.stats.paidinvoicesamount}
                                <span></span>
                            </div>
                            <div>
                                <strong>{$lang.numberpaid}: </strong> {$response.stats.numpaidinvoices}
                            </div>

                            <div>
                                <strong>{$lang.totalrefunded}: </strong> {$response.stats.refundedinvoicesamount}
                            </div>


                            <div>
                                <strong>{$lang.numberrefunded}: </strong> {$response.stats.numrefundedinvoices}
                            </div>
                            <div>
                                <strong>{$lang.totalcancelled}: </strong> {$response.stats.cancelledinvoicesamount}
                            </div>


                            <div>
                                <strong>{$lang.numbercancelled}: </strong> {$response.stats.numcancelledinvoices}
                            </div>




                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 bordered">

                            <nav class="navbar navbar-inverse" style="background-color: #1a4d80">
                                <div class=" navbar-header "><h2 class="text-center"> {$lang.Tikcets} </h2></div>
                            </nav>

                            <div class="pic-back">
                                <strong class="text-center"
                                        style="display: block;color: #000000;"> {$lang.Tikcets}</strong>
                                <h3 class="text-center"> {$response.stats.numactivetickets} </h3>
                            </div>

                            <div class="dates">
                                <div class="start">
                                    <strong>{$lang.active}: </strong> {$response.stats.numactivetickets}
                                    <span></span>
                                </div>
                                <div class="ends">
                                    <strong>{$lang.deactive}: </strong> 5
                                </div>
                            </div>


                        </div>


                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 bordered">

                            <nav class="navbar navbar-inverse" style="background-color: #1a4d80">
                                <div class=" navbar-header "><h2 class="text-center">  {$lang.Products} </h2></div>
                            </nav>
                            <div class="pic-back">
                                <strong class="text-center"
                                        style="display: block;color: #000000;">{$lang.Products}</strong>
                                <h3 class="text-center"> {$response.stats.productsnumtotal} </h3>
                            </div>

                            <div class="dates">
                                <div class="start">
                                    <strong>{$lang.active}: </strong> {$response.stats.productsnumtotal}
                                    <span></span>
                                </div>
                                <div class="ends">
                                    <strong>{$lang.deactive}: </strong> {$response.stats.productsnumactive}
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{include file="{$smarty.current_dir}/footer.tpl"  }

{*</div>*}