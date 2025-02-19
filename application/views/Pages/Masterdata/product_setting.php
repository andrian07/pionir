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
                <h3 class="fw-bold mb-3">Pengaturan Satuan & Harga Produk</h3>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table width="100%" class="mb-3">
              <tbody>
                <tr>
                  <th width="15%">Kode Produk</th>
                  <td width="1%">:</td>
                  <td width="84%" id="setup_product_code">BAT00075</td>
                </tr>
                <tr>
                  <th>Nama Produk</th>
                  <td>:</td>
                  <td id="setup_product_name">Baterai Dynamax A2</td>
                </tr>
                <tr>
                  <th>Satuan Dasar</th>
                  <td>:</td>
                  <td id="setup_base_unit">Pcs</td>
                </tr>
              </tbody>
            </table>

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col" rowspan="2">Aksi</th>
                    <th scope="col" rowspan="2">Kode</th>
                    <th scope="col" rowspan="2">Satuan</th>
                    <th scope="col" rowspan="2">Isi</th>
                    <th scope="col" rowspan="2">DPP</th>
                    <th scope="col" rowspan="2">PPN</th>
                    <th scope="col" rowspan="2">Harga Beli</th>
                    <th scope="col" colspan="4" style="text-align:center;">Normal</th>
                    <th scope="col" colspan="4" style="text-align:center;">Toko</th>
                    <th scope="col" colspan="4" style="text-align:center;">Sales</th>
                    <th scope="col" colspan="4" style="text-align:center;">Khusus</th>
                  </tr>
                  <tr>
                    <td scope="col" style="text-align:center;">Margin</td>
                    <td scope="col" style="text-align:center;">Hrg.Jual</td>
                    <td scope="col" style="text-align:center;">Diskon(%)</td>
                    <td scope="col" style="text-align:center;">Diskon(Rp)</td>
                    <td scope="col" style="text-align:center;">Margin</td>
                    <td scope="col" style="text-align:center;">Hrg.Jual</td>
                    <td scope="col" style="text-align:center;">Diskon(%)</td>
                    <td scope="col" style="text-align:center;">Diskon(Rp)</td>
                    <td scope="col" style="text-align:center;">Margin</td>
                    <td scope="col" style="text-align:center;">Hrg.Jual</td>
                    <td scope="col" style="text-align:center;">Diskon(%)</td>
                    <td scope="col" style="text-align:center;">Diskon(Rp)</td>
                    <td scope="col" style="text-align:center;">Margin</td>
                    <td scope="col" style="text-align:center;">Hrg.Jual</td>
                    <td scope="col" style="text-align:center;">Diskon(%)</td>
                    <td scope="col" style="text-align:center;">Diskon(Rp)</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                    </td>
                    <td>BAT00075</td>
                    <td>PCS</td>
                    <td>1</td>
                    <td>180.000</td>
                    <td>20.000</td>
                    <td>200.000</td>
                    <td>20%</td>
                    <td><span class="badge badge-danger">240.000</span></td>
                    <td>10%</td>
                    <td>216.000</td>
                    <td>10%</td>
                    <td><span class="badge badge-danger">220.000</span></td>
                    <td>0%</td>
                    <td>220.000</td>
                    <td>5%</td>
                    <td><span class="badge badge-danger">210.000</span></td>
                    <td>0%</td>
                    <td>210.000</td>
                    <td>3%</td>
                    <td><span class="badge badge-danger">206.000</span></td>
                    <td>0%</td>
                    <td>206.000</td>
                  </tr>
                  <tr>
                    <td>
                      <button type="button" class="btn btn-icon btn-warning btn-sm mb-2-btn"><i class="far fa-edit sizing-fa"></i></button>
                    </td>
                    <td>BAT00076</td>
                    <td>KTK</td>
                    <td>10</td>
                    <td>1.800.000</td>
                    <td>200.000</td>
                    <td>2.000.000</td>
                    <td>20%</td>
                    <td><span class="badge badge-danger">2.400.000</span></td>
                    <td>10%</td>
                    <td>2.160.000</td>
                    <td>10%</td>
                    <td><span class="badge badge-danger">2.200.000</span></td>
                    <td>0%</td>
                    <td>2.200.000</td>
                    <td>5%</td>
                    <td><span class="badge badge-danger">2.100.000</span></td>
                    <td>0%</td>
                    <td>2.100.000</td>
                    <td>3%</td>
                    <td><span class="badge badge-danger">2.060.000</span></td>
                    <td>0%</td>
                    <td>2.060.000</td>
                  </tr>
                  <tr>
                    <td colspan="15">
                      <a href="#" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><i class="fas fa-plus"></i> Tambahkan</a>

                      <div class="ms-md-auto py-2 py-md-0">
                        <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Satuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <div class="modal-body">
                                <div class="row">
                                  <div class="col-md-6 border-right">
                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Kode Item / Barcode</label>
                                      <div class="col-md-12 p-0">
                                        <input type="text" class="form-control input-full" id="item_code" value="Auto">
                                      </div>
                                    </div>

                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Satuan</label>
                                      <div class="col-md-12 p-0">
                                        <select class="form-control input-full js-example-basic-single" id="item_unit" name="product_unit">
                                          <option>-- Pilih Satuan Dasar --</option>
                                          <option>Pcs</option>
                                          <option>Kotak</option>
                                          <option>Lusin</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Isi</label>
                                      <div class="col-md-12 p-0">
                                        <input type="text" class="form-control input-full" id="item_containt">
                                      </div>
                                    </div>

                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Harga Jual Normal</label>
                                      <div class="row">
                                        <div class="col-sm-4">
                                          <input id="margin_rate_G1" name="margin_rate_G1" type="text" class="form-control text-right" placeholder="0%">
                                        </div>

                                        <div class="col-sm-8">
                                          <input id="sales_price_G1" name="sales_price_G1" type="text" class="form-control text-right"  placeholder="RP. 1.000.000">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Harga Jual Toko</label>
                                      <div class="row">
                                        <div class="col-sm-4">
                                          <input id="margin_rate_G1" name="margin_rate_G1" type="text" class="form-control text-right" value="0">
                                        </div>

                                        <div class="col-sm-8">
                                          <input id="sales_price_G1" name="sales_price_G1" type="text" class="form-control text-right" data-parsley-vsalespriceg1="" value="0">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Harga Sales</label>
                                      <div class="row">
                                        <div class="col-sm-4">
                                          <input id="margin_rate_G1" name="margin_rate_G1" type="text" class="form-control text-right" value="0">
                                        </div>

                                        <div class="col-sm-8">
                                          <input id="sales_price_G1" name="sales_price_G1" type="text" class="form-control text-right" data-parsley-vsalespriceg1="" value="0">
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group form-inline">
                                      <label for="inlineinput" class="col-md-3 col-form-label">Harga Khusus</label>
                                      <div class="row">
                                        <div class="col-sm-4">
                                          <input id="margin_rate_G1" name="margin_rate_G1" type="text" class="form-control text-right" value="0">
                                        </div>

                                        <div class="col-sm-8">
                                          <input id="sales_price_G1" name="sales_price_G1" type="text" class="form-control text-right" data-parsley-vsalespriceg1="" value="0">
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>

                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <a href="<?php echo base_url(); ?>Masterdata/product"><button class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Kembali</button>
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

    $(".delete").click(function (e) {
      swal({
        title: "Hapus !!",
        text: "Hapus Data!",
        type: "warning",
        buttons: {
          cancel: {
            visible: true,
            text: "Tidak, Batal!",
            className: "btn btn-danger",
          },
          confirm: {
            text: "Ya, Hapus!",
            className: "btn btn-success",
          },
        },
      }).then((willDelete) => {
        if (willDelete) {
          swal("Sukses Hapus Data!", {
            icon: "success",
            buttons: {
              confirm: {
                className: "btn btn-success",
              },
            },
          });
        }
      });
    });
  </script>