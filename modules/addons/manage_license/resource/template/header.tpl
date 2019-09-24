<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{if !{$smarty.get.Action}}active{/if}"><a href="addonmodules.php?module=manage_license"><i
                                class="fas fa-home"></i> {$lang.AddonHome}</a></li>
                <li class="{if {$smarty.get.Action == "billing"}}active{/if} dropdown" ><a
                            href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i
                                class="fas fa-dollar-sign"></i> {$lang.billing}</a>
                    <ul class="dropdown-menu">
                        <li class="{if {$smarty.get.Sub == "AllInvoices"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=billing&Sub=AllInvoices">{$lang.AllInvoices} </a></li>
                        <li class="{if {$smarty.get.Sub == "PaidInvoices"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=billing&Sub=PaidInvoices">{$lang.PaidInvoices} </a></li>
                        <li class="{if {$smarty.get.Sub == "UnpaidInvoices"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=billing&Sub=UnpaidInvoices">{$lang.UnpaidInvoices}</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="{if {$smarty.get.Sub == "AddFund"}}active{/if}" ><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=billing&Sub=AddFund">{$lang.AddFund}</a></li>

                    </ul>

                </li>
                <li class="{if {$smarty.get.Action == "yourservice"}}active{/if}"><a
                            href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=yourservice"><i class="fas fa-server"></i> {$lang.yourservice}</a></li>

                <li class="{if {$smarty.get.Action == "setting"}}active{/if} dropdown" ><a
                            href="#" class="dropdown-toggle" data-toggle="dropdown" ><i
                        <i class="fas fa-wrench"></i> {$lang.setting}</a>
                    <ul class="dropdown-menu">
                        <li class="{if {$smarty.get.Sub == "Products"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=setting&Sub=Products">{$lang.Products} </a></li>
                        <li class="{if {$smarty.get.Sub == "Option"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=setting&Sub=Option">{$lang.Option} </a></li>
                        <li class="{if {$smarty.get.Sub == "Reseller"}}active{/if}"><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=setting&Sub=Reseller">{$lang.Reseller}</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="{if {$smarty.get.Sub == "connect"}}active{/if}" ><a href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=setting&Sub=connect">{$lang.connect}</a></li>

                    </ul>

                </li>

                <li class="{if {$smarty.get.Action == "help"}}active{/if}"><a
                            href="addonmodules.php?module=manage_license&SId={$smarty.get.SId}&Action=help"><i
                                class="fas fa-question-circle"></i> {$lang.help}</a></li>


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>