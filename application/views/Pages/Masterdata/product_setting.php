<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-left">
              <div>
                <h3 class="fw-bold mb-3">Pengaturan Harga Produk</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <div class="btn-group dropdown">
                 <a href="<?php echo base_url(); ?>Masterdata/product"><button class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Kembali</button></a>
                 <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><span class="btn-label"><i class="far fa-edit sizing-fa"></i></span> Edit</button>
                 <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Setting Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4 border-right">
                            <h4 style="text-align:center;">Detail Item</h4>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Item / Barcode</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" class="form-control input-full" id="item_id" value="<?php echo $_GET['id']; ?>" readonly>
                                <input type="text" class="form-control input-full" id="item_code" value="BAT00075" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Beli</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="item_purchase_price" value="0">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">HPP</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="item_hpp" value="0">
                              </div>
                            </div>

                          </div>



                          <div class="col-md-4 border-right">
                            <h4 style="text-align:center;">Margin & Harga Jual</h4>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Jual Normal</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_1_percentage" name="item_price_1_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_1" name="item_price_1" type="text" class="form-control text-right"  value="0">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Jual Toko</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_2_percentage" name="item_price_2_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_2" name="item_price_2" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Sales</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_3_percentage" name="item_price_3_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_3" name="item_price_3" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Khusus</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_4_percentage" name="item_price_4_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_4" name="item_price_4" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4 border-right">
                            <h4 style="text-align:center;">Disc</h4>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Disc Normal</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_disc_1_percentage" name="item_disc_1_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_disc_1" name="item_disc_1" type="text" class="form-control text-right"  value="0" readonly>
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Disc Toko</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_disc_2_percentage" name="item_disc_2_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_disc_2" name="item_disc_2" type="text" class="form-control text-right"  value="0" readonly>
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Disc Sales</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_disc_3_percentage" name="item_disc_3_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_disc_3" name="item_disc_3" type="text" class="form-control text-right"  value="0" readonly>
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Disc Khusus</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_disc_4_percentage" name="item_disc_4_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_disc_4" name="item_disc_4" type="text" class="form-control text-right"  value="0" readonly>
                                </div>
                              </div>
                            </div>

                          </div>

                        </div>

                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?php foreach ($settingproduct as $row) { ?>
              <table width="100%" class="mb-3">
                <tbody>
                  <tr>
                    <th width="15%">Kode Produk</th>
                    <td width="1%">:</td>
                    <td width="84%" id="setup_product_code"><?php echo $row->product_code; ?></td>
                  </tr>
                  <tr>
                    <th>Nama Produk</th>
                    <td>:</td>
                    <td id="setup_product_name"><?php echo $row->product_name; ?></td>
                  </tr>
                </tbody>
              </table>

              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Kode:</th>
                          <td colspan="4"><?php echo $row->product_code; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Nama Produk:</th>
                          <td colspan="4"><?php echo $row->product_name; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Kategori:</th>
                          <td colspan="4"><?php echo $row->category_name; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Brand:</th>
                          <td colspan="4"><?php echo $row->brand_name; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Supplier:</th>
                          <td colspan="4"><?php foreach(explode(",",$row->product_supplier_tag) as $rows){ echo '<span class="badge badge-primary " style="margin-right:1px;">'.$rows.'</span>';} ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Item Supplier:</th>
                          <td colspan="4"><?php echo $row->product_supplier_name; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Paket:</th>
                          <td colspan="4">
                            <?php if($row->is_package == 'Y'){
                              echo '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
                            }else{
                              echo '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
                            } ?>
                          </td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">PPN:</th>
                          <td colspan="4">
                            <?php if($row->is_ppn == 'PPN'){
                              echo '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
                            }else{
                              echo '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
                            } ?>
                          </td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Satuan:</th>
                          <td colspan="4"><?php echo $row->unit_name; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Min Stock:</th>
                          <td colspan="4"><?php echo $row->product_min_stock; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Berat:</th>
                          <td colspan="4"><?php echo $row->product_weight; ?> Gram</td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">HPP:</th>
                          <td colspan="4"><?php echo number_format($row->product_hpp); ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Harga Beli:</th>
                          <td colspan="4"><?php echo number_format($row->product_price); ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Lokasi Stok:</th>
                          <td colspan="4"><?php echo $row->product_location; ?></td>
                        </tr>
                        <tr>
                          <th scope="col" class="productinfo-text-right">Catatan:</th>
                          <td colspan="4"><?php echo $row->product_desc; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <th scope="col" rowspan="2">Umum</th>
                          <td>Margin</td>
                          <td>Hrg.Jual</td>
                          <td>Diskon(%)</td>
                          <td>Diskon(Rp)</td>
                        </tr>
                        <tr>
                          <td>20%</td>
                          <td><span class="badge badge-danger">240.000</span></td>
                          <td>10%</td>
                          <td>216.000</td>
                        </tr>
                        <tr>
                          <th scope="col" rowspan="2">Toko</th>
                          <td>Margin</td>
                          <td>Hrg.Jual</td>
                          <td>Diskon(%)</td>
                          <td>Diskon(Rp)</td>
                        </tr>
                        <tr>
                          <td>20%</td>
                          <td><span class="badge badge-danger">240.000</span></td>
                          <td>10%</td>
                          <td>216.000</td>
                        </tr>
                        <tr>
                          <th scope="col" rowspan="2">Sales</th>
                          <td>Margin</td>
                          <td>Hrg.Jual</td>
                          <td>Diskon(%)</td>
                          <td>Diskon(Rp)</td>
                        </tr>
                        <tr>
                          <td>20%</td>
                          <td><span class="badge badge-danger">240.000</span></td>
                          <td>10%</td>
                          <td>216.000</td>
                        </tr>
                        <tr>
                          <th scope="col" rowspan="2">Khusus</th>
                          <td>Margin</td>
                          <td>Hrg.Jual</td>
                          <td>Diskon(%)</td>
                          <td>Diskon(Rp)</td>
                        </tr>
                        <tr>
                          <td>20%</td>
                          <td><span class="badge badge-danger">240.000</span></td>
                          <td>10%</td>
                          <td>216.000</td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table table-head-bg-info">
                      <thead>
                        <tr>
                          <th>Stock</th>
                          <th>Qty</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Cabang Kobar</td>
                          <td>15 Pcs</td>
                        </tr>
                        <tr>
                          <td>Cabang Serdam</td>
                          <td>2 Pcs</td>
                        </tr>
                        <tr>
                          <td>Gudang Bongkar</td>
                          <td>2 Pcs</td>
                        </tr>
                        <tr>
                          <td>Gudang Retur</td>
                          <td>1 Pcs</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>

  let item_purchase_price = new AutoNumeric('#item_purchase_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_hpp = new AutoNumeric('#item_hpp', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_1 = new AutoNumeric('#item_price_1', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_2 = new AutoNumeric('#item_price_2', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  let item_price_3 = new AutoNumeric('#item_price_3', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  let item_price_4 = new AutoNumeric('#item_price_4', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_1_percentage = new AutoNumeric('#item_price_1_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_price_2_percentage = new AutoNumeric('#item_price_2_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_price_3_percentage = new AutoNumeric('#item_price_3_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_price_4_percentage = new AutoNumeric('#item_price_4_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_disc_1 = new AutoNumeric('#item_disc_1', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_disc_2 = new AutoNumeric('#item_disc_2', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  let item_disc_3 = new AutoNumeric('#item_disc_3', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_disc_4 = new AutoNumeric('#item_disc_4', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  
  let item_disc_1_percentage = new AutoNumeric('#item_disc_1_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_disc_2_percentage = new AutoNumeric('#item_disc_2_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_disc_3_percentage = new AutoNumeric('#item_disc_3_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_disc_4_percentage = new AutoNumeric('#item_disc_4_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  $('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('.js-example-basic-multiple').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#myModal').length !== 0)
        dropdownParent = $("#myModal");
      $(this).select2({
        dropdownParent: $("#myModal")
      // ...
      });
    });
  });

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });

  $('#btnsave').click(function(e){
    e.preventDefault();
    var item_purchase_price       = $("#item_purchase_price").val();
    var item_hpp                  = $("#item_hpp").val();
    var item_price_1_percentage   = $("#item_price_1_percentage").val();
    var item_price_2_percentage   = $("#item_price_2_percentage").val();
    var item_price_3_percentage   = $("#item_price_3_percentage").val();
    var item_price_4_percentage   = $("#item_price_4_percentage").val();
    var item_price_1              = $("#item_price_1").val();
    var item_price_2              = $("#item_price_2").val();
    var item_price_3              = $("#item_price_3").val();
    var item_price_4              = $("#item_price_4").val();
    var item_disc_1_percentage    = $("#item_disc_1_percentage").val();
    var item_disc_2_percentage    = $("#item_disc_2_percentage").val();
    var item_disc_3_percentage    = $("#item_disc_3_percentage").val();
    var item_disc_4_percentage    = $("#item_disc_4_percentage").val();
    var item_disc_1               = $("#item_disc_1").val();
    var item_disc_2               = $("#item_disc_2").val();
    var item_disc_3               = $("#item_disc_3").val();
    var item_disc_4               = $("#item_disc_4").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/save_salesman",
      dataType: "json",
      data: {salesman_name:salesman_name, salesman_phone:salesman_phone, salesman_address:salesman_address, salesman_branch:salesman_branch},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/salesman";
          Swal.fire('Saved!', '', 'success');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  });


  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)
    modal.find('.modal-title').text('Edit Harga')
    var id = $("#item_id").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_edit_product",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          let row = data.result[0];
          modal.find('#item_code').val(row.product_code)
          item_purchase_price.set(row.product_price)
          item_hpp.set(row.product_hpp)

          item_price_1.set(row.product_sell_price_1)
          item_price_2.set(row.product_sell_price_2)
          item_price_3.set(row.product_sell_price_3)
          item_price_4.set(row.product_sell_price_4)
          item_price_1_percentage.set(row.product_sell_percentage_1)
          item_price_2_percentage.set(row.product_sell_percentage_2)
          item_price_3_percentage.set(row.product_sell_percentage_3)
          item_price_4_percentage.set(row.product_sell_percentage_4)
          item_disc_1_percentage.set(row.product_disc_1_percentage)
          item_disc_2_percentage.set(row.product_disc_2_percentage)
          item_disc_3_percentage.set(row.product_disc_3_percentage)
          item_disc_4_percentage.set(row.product_disc_4_percentage)
          item_disc_1.set(row.product_disc_1_price)
          item_disc_2.set(row.product_disc_2_price)
          item_disc_3.set(row.product_disc_3_price)
          item_disc_4.set(row.product_disc_4_price)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });

  })

</script>