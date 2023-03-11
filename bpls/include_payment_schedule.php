<!-- Payment Schedule -->

<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse14322" aria-expanded="true">
            PAYMENT SCHEDULE 
        </div>
        <div id="collapse14322" class="panel-collapse collapse in" aria-expanded="true">
            <div class="row" style="margin:2px;">
                <div class="col-md-12">
                    <table class="table" style="text-align:center;">
                        <tr>
                            <td><b>PAYMENT DATE</b></td>
                            <td><b>PAYMENT AMOUNT</b></td>
                        </tr>
                        <?php
                        $backtax022_surcharges = 0;
                        $qpf = mysqli_query($conn, "SELECT * FROM `geo_bpls_payment_frequency` where payment_frequency_desc = '$mode_of_payment' ");
                        $rpf = mysqli_fetch_assoc($qpf);
                        $total_amount =0;
                            if ($mode_of_payment == "Annual") {
                                $total_amount = $total_tax_due;
                                $total_surcharges_amount_ps = $total_surcharges_amount;
                                ?>
                                <tr>
                                    <td><?php 
                                        $aa1 = "2020-" . $rpf['payment_anndue1'];
                                        $aa = strtotime($aa1);
                                        $bb = date('F d', $aa);
                                        echo $bb;

                                    ?></td>        
                                    <td><?php 
                                     
                                      // lalagyan ng surcharges ang backtax
                                      if($backtax022 != 0 ){

                                        $backtax022_surcharges = $backtax022 * $surcharges_rate;
                                        }

                                    echo number_format($total_amount + $total_surcharges_amount_ps + $backtax022_surcharges + $backtax022, 2);

                                    if($total_surcharges_amount != 0 ){
                                        echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . number_format($total_surcharges_amount_ps+$backtax022_surcharges,2) . "</span>)</i>";
                                    }
                                    if($backtax022 != 0 ){
                                        echo " &nbsp; <i>with backtax(<span style='color:red;'> " . number_format($backtax022,2) . "</span>)</i>";
                                    }
                                    
                                    ?></td>        
                                         
                                </tr>
                                <?php
                            }elseif ($mode_of_payment == "Semi-annual") {
                                $total_surcharges_amount_ps = $total_surcharges_amount  / 2;

                            for($k=1; $k<3; $k++){
                                        $total_amount = 0;
                                        $total_amount = $total_tax_due / 2;
                                        // get all amount to paid

                                ?>
                            <tr>
                                    <td><?php 
                                        $aa1 = "2020-" . $rpf['payment_semdue'.$k];
                                        $aa = strtotime($aa1);
                                        $bb = date('F d', $aa);
                                        echo $bb;

                                    ?></td>        
                                    <td><?php 

                                    if($current_quarter == $k){

                                         // lalagyan ng surcharges ang backtax
                                         if($backtax022 != 0 ){

                                            $backtax022_surcharges = $backtax022 * $surcharges_rate;
                                            }

                                        echo number_format($total_amount + $total_surcharges_amount_ps + $backtax022_surcharges + $backtax022, 2);
                                        if($total_surcharges_amount_ps != 0 ){

                                            echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . number_format($total_surcharges_amount_ps + $backtax022_surcharges,2) . "</span>)</i>";
                                        }
                                        if($backtax022 != 0 ){

                                            echo " &nbsp; <i>with backtax(<span style='color:red;'> " . number_format($backtax022,2) . "</span>)</i>";
                                        }
                                    }else{
                                        echo number_format($total_amount, 2);
                                    }
                                    ?></td>        
                                </tr>
                                <?php
                                }

                            }elseif ($mode_of_payment == "Quarterly") {
                                $total_surcharges_amount_ps = $total_surcharges_amount  / 4;

                            for($k=1; $k<5; $k++){
                                
                                        $total_amount =   $total_tax_due/4;
                                        // get all amount to paid
                                ?>
                            <tr>
                                    <td><?php 
                                        $aa1 = "2020-" . $rpf['payment_qtrdue'.$k];
                                        $aa = strtotime($aa1);
                                        $bb = date('F d', $aa);
                                        echo $bb;
                                    ?></td>        
                                    <td><?php
                                         if($current_quarter == $k){

                                            // lalagyan ng surcharges ang backtax
                                            if($backtax022 != 0 ){

                                            $backtax022_surcharges = $backtax022 * $surcharges_rate;
                                            }
                                            // lalagyan ng surcharges ang backtax

                                        echo number_format($total_amount + $total_surcharges_amount_ps + $backtax022_surcharges + $backtax022, 2);
                                            if($sur != 0 ){

                                                echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . number_format($total_surcharges_amount_ps+$backtax022_surcharges,2) . "</span>)</i>";
                                            }
                                            if($backtax022 != 0 ){

                                                echo " &nbsp; <i>with backtax(<span style='color:red;'> " . number_format($backtax022,2). "</span>)</i>";
                                            }
                                        }else{
                                            echo number_format($total_amount, 2);
                                        }
                                    ?></td>        
                                </tr>
                                <?php
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Payment Schedule -->