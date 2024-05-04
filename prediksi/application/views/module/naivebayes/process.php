           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
           <div class="card-box">
            <!-- Left sidebar -->
            <div class="inbox-leftbar">
                <div class="mt-4">
                    <a href="<?=base_url()?>Naivebayes/dataset" class="list-group-item border-0 <?=$page=='process'?'font-weight-bold ':'';?>"><i class="fas fa-plus fa-sm fa-fw mr-2"></i>Add Data</a>
                    <a href="<?=base_url()?>NaiveBayes/process/dataset" class="list-group-item border-0 <?=$page=='dataset'?'font-weight-bold':'';?>"><i class="fas fa-table fa-sm fa-fw mr-2"></i>Dataset</a>
                    <a href="<?=base_url()?>NaiveBayes/process/performance" class="list-group-item border-0 <?=$page=='performance'?'font-weight-bold':'';?>"><i class="fas fa-flask fa-sm fa-fw mr-2"></i>Data Uji</a>
                    <a href="<?=base_url()?>NaiveBayes/process/prediksi" class="list-group-item border-0 <?=$page=='prediksi'?'font-weight-bold':'';?>"><i class="fas fa-chart-line fa-sm fa-fw mr-2"></i>Prediksi</a>
                 </div>
            </div>
            <!-- End Left sidebar -->
            <div class="inbox-rightbar">
              <?php
                $history = $this->db->query("select
                `tugas`, `uts`, `uas`, `ketidakhadiran`, `ekskul`, `class`
                from dataset_risma")->result_array();
                $column = array();
                if(sizeof($history)>0){
                  $column = $history[0];
                  $column = array_keys($column);
                }
              ?>
            <?php
                //Dataset
                if($page == 'dataset' && sizeof($column)>0){
                ?>
                    <?php
                    $index = $column;
                    $dataset = $history;
                    ?>
                    <div class="table-responsive">
                      <h4>Dataset Siswa</h4>
                      <table class="table">
                        <thead>
                          <tr>
                            <?php
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dataset as $key) {
                                ?>
                                <tr>
                                    <?php
                                     foreach ($index as $keys) {
                                        ?>
                                            <td><?=$key[$keys]?></td>
                                        <?php
                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                <?php
                }
                if($page == 'prediksi' && sizeof($column)>0){
                    $index = $column;
                    $dataset = $history;
                      foreach ($index as $key) {
                          $label[$key] = array_unique(array_column($dataset,$key));
                      }
                      $datatoprediksi = [];
                      foreach ($dataset as $key) {
                          $rowdata=[];
                         foreach ($index as $keys) {
                          $rowdata[]=$key[$keys];
                         }
                         $datatoprediksi[]=$rowdata;
                      }
                      ?>
                          <div class="row">
                          <div class="col-md-6">
                          <form method="POST" action="">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="name" name="name"
                                placeholder = "Masukkan Nama" value="<?= set_value('name');?>"> <?= form_error('name', '<small class="text-danger pl-3">','</small>')?>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" id="class" name="class"
                                 placeholder = "Masukkan Kelas" value="<?= set_value('kelas');?>"> <?= form_error('class', '<small class="text-danger pl-3">','</small>')?>
                            </div>
                              <?php
                              $x=0;
                              $lab = [];
                              foreach ($label as $key => $value) {
                                  $x++;array_push($lab,$key);
                                  if((sizeof($label))>$x){
                                    ?>
                                    <div class="form-group">
                                     <label><?=$key?></label>
                                        <select name="pred[]" class="form-control">
                                         <?php
                                             foreach ($value as $keys) {
                                               $PRED = $this->input->post('pred');
                                                ?>
                                                 <option value="<?=$keys?>" <?=isset($PRED[$x-1])?$PRED[$x-1]==$keys?'selected':'':''?>><?=$keys?></option>
                                                <?php
                                             }
                                         ?>
                                        </select>
                                    </div>
                                    <?php
                                  }
                              }
                          ?>
                          <div class="form-group">
                             <button class="btn btn-primary" name="prediksi" value="1" type="submit">Proses</button>
                          </div>
                          </form>
                          </div>
                          <div class="col-md-6">
                              <?php
                                  if($this->input->post('prediksi') !== NULL){
                                      $this->session->set_userdata("prediksi",true);
                                      $predict = $this->input->post('pred');
                                      $this->naivebayes->init($datatoprediksi,$predict);
                                      $result = $this->naivebayes->predict();
                                      $conf_matrix = $this->naivebayes->conf_matrix($datatoprediksi,$predict);
                                      $conf_matrix_label_composition = $this->naivebayes->label_composition($datatoprediksi,$predict);
                                      ?>
                                      <h4>Proses</h4>
                                      <div class="card card-body text-black">
                                          <h4 class="card-title mb-0 text-black">Total Label</h4>
                                           <p class="card-text">
                                           <?php
                                             foreach ($this->naivebayes->reslabel as $key => $val) {
                                                 ?>
                                                  <?=$key?> : <?=$val?> <?=isset($result[$key])?"(".$result[$key].")":''?><br />
                                                 <?php
                                             }
                                           ?>
                                           </p>
                                      </div>
                                      <div class="card card-body text-black">
                                      <h4 class="card-title mb-2 text-black">Hasil Prediksi</h4>
                                      <?php
                                          $hasil = $result;
                                          asort($hasil);
                                          $x=0;
                                          $prediksi="";
                                          foreach ($hasil as $key => $val) {
                                              if($x==sizeof($result)-1){
                                                  $prediksi=$key;
                                              }
                                              $x++;
                                              ?>
                                                   <?php
                                                      echo $key." : ".$val."<br />";
                                                   ?>
                                              <?php
                                          }
                                      ?>
                                      <h4 class="card-title mb-2 text-black" align="center"><?=$prediksi;?></h4>
                                      </div>
                                      <?php
                                          foreach ($this->naivebayes->resall as $key=>$val) {
                                             foreach ($val as $keys => $value) {
                                                ?>
                                                  <div class="card card-body text-black">
                                                      <h4 class="card-title mb-0 text-black"><?=$lab[$key]?> :: <?=$keys?></h4>
                                                       <p class="card-text mb-0">
                                                       <?php
                                                         foreach ($value as $keyn => $vals) {
                                                             echo $keyn." : ".$vals.",&nbsp;";

                                                         }
                                                       ?>
                                                       </p>
                                                       <hr />
                                                       <?php
                                                        foreach ($conf_matrix[$key] as $cm=>$cmv) {
                                                            echo $cm."<br />";
                                                            foreach ($cmv as $cmv2=>$cmv2v) {
                                                              echo "<div class='ml-4'>* ".$cmv2.": ".$cmv2v."</div>";
                                                              echo "<div class='ml-4'>".$cmv2v."/".$conf_matrix_label_composition[$cmv2]."=".($cmv2v/$conf_matrix_label_composition[$cmv2])."</div>";
                                                            }
                                                        }
                                                       ?>
                                                  </div>
                                                  <hr/>
                                              <?php
                                             }
                                          }
                                      ?>
                                    <!-- hasil prediksi -->
                                      <?php
                                      if($this->session->userdata('prediksi')==true){
                                        $temp = array();
                                        $labels = array_keys($label);
                                        $x=0;
                                        foreach ($labels as $key) {
                                              if($x<sizeof($labels)-1){
                                            $temp[$key] = $predict[$x];
                                          }else{
                                                $temp[$key] = $prediksi;
                                              }
                                              $x++;
                                        }
                                        //   $this->db->insert("dataset_history",$temp);
                                      //   $this->db->insert("naivebayes_history",
                                      //     array(
                                      //       "history"=>json_encode($temp)
                                      //   ));
                                      //   $this->session->set_userdata("prediksi",false);
                                      }
                                  }
                              ?>
                          </div>
                          </div>
                      </div>
                      <?php
                }
                if($page == 'performance' && sizeof($column)>0){
                      $index = $column;
                      $dataset = $history;
                    ?>
                       <div class="card-box">
                            <div class="row">
                            <div class="col-md-6">
                            <h4>Akurasi Metode</h4>
                            <form method="POST" action="" id="performance">
                                <div class="form-group">
                                    <label id="lab">Presentase Data Training <?=$this->input->post('train')!==NULL?$this->input->post('train').'%, Data Testing '.(100-$this->input->post('train')).'%':''?></label>
                                    <select name="train" required="" onchange="if($(event.target).val()!=''){$('#lab').html('Prosentase Data Training '+$(event.target).val()+'%, Data Testing '+(100-$(event.target).val())+'%');$('#performance').submit();}else{$('#lab').html('Prosentase Data Training');}" class="form-control">
                                       <option value=""> Pilih Presentase </option>
                                       <option value="10" <?=$this->input->post('train')==10?'selected':''?>>10 %</option>
                                       <option value="20" <?=$this->input->post('train')==20?'selected':''?>>20 %</option>
                                       <option value="30" <?=$this->input->post('train')==30?'selected':''?>>30 %</option>
                                       <option value="40" <?=$this->input->post('train')==40?'selected':''?>>40 %</option>
                                       <option value="50" <?=$this->input->post('train')==50?'selected':''?>>50 %</option>
                                       <option value="60" <?=$this->input->post('train')==60?'selected':''?>>60 %</option>
                                       <option value="70" <?=$this->input->post('train')==70?'selected':''?>>70 %</option>
                                       <option value="80" <?=$this->input->post('train')==80?'selected':''?>>80 %</option>
                                       <option value="90" <?=$this->input->post('train')==90?'selected':''?>>90 %</option>
                                    </select>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-6">

                            </div>
                            </div>
                        </div>
                        <?php if($this->input->post('train')!==NULL){ ?>
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Pemisahan Data Training & Testing</h4>
                                    <?php
                                        $train = $this->input->post('train');
                                        $countdata = sizeof($dataset);
                                        $ndatatrain = ($train/100)*$countdata;
                                        $ndatatrain = floor($ndatatrain);
                                        $newtraindata = [];
                                    ?>
                                    <table class="table table-border">
                                        <thead>
                                          <tr>
                                            <?php
                                                foreach ($index as $key) {
                                                  ?>
                                                   <th><?=$key?></th>
                                                  <?php
                                                }
                                            ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td align="center" colspan="<?=sizeof($index)?>"><b>Data Training</b></td>
                                        </tr>
                                            <?php
                                            $x=0;$flagtesting=0;
                                            foreach ($dataset as $key) {
                                                $x++;
                                                if($ndatatrain>=$x){
                                                ?>
                                                <tr>
                                                    <?php
                                                    $newtraindata_temp=[];
                                                    foreach ($index as $keys) {
                                                        $newtraindata_temp[]=$key[$keys];
                                                    ?>
                                                        <td class="table-"><?=$key[$keys]?></td>
                                                    <?php
                                                    }
                                                    $newtraindata[]=$newtraindata_temp;
                                                    ?>
                                                </tr>
                                                <?php
                                                }else{
                                                ?>
                                                <?php if($flagtesting==0){$flagtesting++; ?>
                                                <tr>
                                                <td align="center" colspan="<?=sizeof($index)?>"><b>Data Testing</b></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <?php
                                                    foreach ($index as $keys) {
                                                    ?>
                                                        <td class="table-"><?=$key[$keys]?></td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <h4 class="mt-3">Proses Testing</h4>
                                    <table class="table table-border">
                                        <thead>
                                          <tr>
                                            <?php
                                                foreach ($index as $key) {
                                                  ?>
                                                   <th><?=$key?></th>
                                                  <?php
                                                }
                                            ?>
                                            <th>Hasil Testing</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $x=0;$benar=0;
                                            foreach ($dataset as $key) {
                                                $x++;
                                                if($x>$ndatatrain){
                                                ?>
                                                <tr>
                                                    <?php
                                                    $predict=[];
                                                    foreach ($index as $keys) {
                                                    $predict[]=$key[$keys];
                                                    ?>
                                                        <td class="table-warning"><?=$key[$keys]?></td>
                                                    <?php
                                                    }
                                                    $pop = array_pop($predict);
                                                    $this->naivebayes->init($newtraindata,$predict);
                                                    $result = $this->naivebayes->predict();
                                                    asort($result);
                                                    $res=max($result);
                                                    ?>
                                                    <td class="table-primary">
                                                    <?php
                                                        $hsl=array_search($res, $result);
                                                        if($hsl==$pop){$benar++;}
                                                        echo $hsl;
                                                    ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <?php
                                        $akurasi=$benar/(sizeof($dataset)-$ndatatrain)*100;
                                    ?>
                                    <div class="card card-body <?php if($akurasi<60){echo 'bg-danger';}else if($akurasi<80){echo 'bg-warning';}else{echo 'bg';} ?> text-black">
                                        <h4 class="card-title mb-0 text-black">Hasil Akurasi : <?=round($akurasi,3)?>%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php
              }
            ?>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end card-box -->
    </div> <!-- end Col -->
</div>
