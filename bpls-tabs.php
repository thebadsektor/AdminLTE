 <div class="row ">
     <div class="col-md-12">
         <!-- Custom Tabs -->

         <div class="nav-tabs-custom">
             <ul class="nav nav-pills">
                 <li <?php if ($_GET["redirect"] === "dashboard" || !isset($_GET["redirect"])) {
                            echo "class='active'";
                        } ?>><a href="bplsmodule.php?redirect=dashboard">Dashboard</a></li>
                 <li <?php if ($_GET["redirect"] === "business_entries") {
                            echo "class='active'";
                        } ?>><a href="bplsmodule.php?redirect=business_entries">Business Entries</a></li>
                 <li <?php if ($_GET["redirect"] === "business_registration" || $_GET["redirect"] == "business_registration_multistep" && isset($_GET["target"])) {
                            echo "class='active'";
                        } ?>><a href="bplsmodule.php?redirect=business_registration">Business Registration</a></li>
                 <li <?php if ($_GET["redirect"] === "business_renewal") {
                            echo "class='active'";
                        } ?>><a href="bplsmodule.php?redirect=business_renewal">Business List
                     </a> </li>
                 <li <?php if ($_GET["redirect"] === "online_transac" || $_GET["redirect"] === "OAV" ||  $_GET["redirect"] ===  "OAV2") {
                            echo "class='active'";
                        } ?>><a href="bplsmodule.php?redirect=online_transac">Onine Transaction</a></li>
                 <li <?php if ($_GET["redirect"] === "bpls_uploaded_req") {
                            echo "class='active'";
                        } ?>> <a href="bplsmodule.php?redirect=bpls_uploaded_req">List of Uploaded Requirements</a></li>

                 <li <?php if ($_GET["redirect"] === "audit_trail") {
                            echo "class='active'";
                        } ?>> <a href="bplsmodule.php?redirect=audit_trail">Audit Trail</a></li>

                 <li <?php if ($_GET["redirect"] === "bpls_settings" || $_GET["redirect"] === "tax_fees"  || $_GET["redirect"] === "address_settings") {
                            echo "class='active'";
                        } ?>> <a href="bplsmodule.php?redirect=bpls_settings">Setting</a></li>

                 <li <?php if ($_GET["redirect"] === "bpls_reports") {
                            echo "class='active'";
                        } ?>> <a href="bplsmodule.php?redirect=bpls_reports">Reports</a></li>

             </ul>
             <!-- nav-tabs-custom -->
         </div>
     </div>
     <!-- /.col -->
 </div>